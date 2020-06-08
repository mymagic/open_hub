<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class HubEvent
{
	public static function getOrCreateEvent($title, $params = array())
	{
		try {
			$event = self::getEventByTitle($title);
		} catch (Exception $e) {
			$event = null;
		}

		if ($event === null) {
			$event = self::createEvent($title, $params);
		} else {
			// update attributes
			$params['event']['title'] = $title;
			$event->attributes = $params['event'];
			$event->save(false);
		}

		return $event;
	}

	public static function createEvent($title, $params = array())
	{
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$event = new Event();
			$event->title = $title;
			$event->attributes = $params['event'];

			if (!empty($event->full_address)) {
				$event->resetAddressParts();
			}

			if (!empty($event->date_started)) {
				$event->date_started = strtotime($event->date_started);
			}
			if (!empty($event->date_ended)) {
				$event->date_ended = strtotime($event->date_ended);
			}

			if ($event->save()) {
				$log = Yii::app()->esLog->log(sprintf("created '%s'", $event->title), 'event', array('trigger' => 'HubEvent::createEvent', 'model' => 'Event', 'action' => 'create', 'id' => $event->id, 'eventId' => $event->id), '', array());
				$transaction->commit();
			} else {
				throw new Exception(Yii::app()->controller->modelErrors2String($event->getErrors()));
			}
		} catch (Exception $e) {
			$transaction->rollBack();
			$exceptionMessage = $e->getMessage();
			throw new Exception($exceptionMessage);
		}

		return $event;
	}

	public static function getEvent($id)
	{
		$model = Event::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested event item does not exist.');
		}

		return $model;
	}

	public static function getEventCode($code)
	{
		return Event::model()->findByAttributes(array('code' => $code));
	}

	public static function getEventByTitle($title)
	{
		$model = Event::model()->title2obj($title);
		if ($model === null) {
			throw new CHttpException(404, 'The requested event does not exist.');
		}

		return $model;
	}

	public static function getEventRegistrationByID($registration_code)
	{
		return EventRegistration::model()->findByAttributes(array('registration_code' => $registration_code));
	}

	public function syncEventToResource($dateStart = '', $dateEnd = '', $limit = 1000000)
	{
		$status = 'fail';
		$msg = 'Unknown error';

		// todo: assume event owner is magic
		$magicSlug = 'magic-malaysian-global-innovation-creativity-centre';
		$theOrganization = Organization::slug2obj($magicSlug);

		// get all active not cancelled event
		$criteria = new CDbCriteria();
		$criteria->condition = "is_active=:isActive AND is_cancelled!=:isCancelled AND title != '' AND title IS NOT NULL AND title NOT LIKE '%test%'";
		$criteria->params = array(':isActive' => 1, ':isCancelled' => 1);
		$criteria->order = 'date_started DESC';

		$events = Event::model()->findAll($criteria);
		//print_r($events);exit;
		$count = 0;
		foreach ($events as $event) {
			// if($count>10)continue;

			echo '<li>';
			echo $event->title . '<br />';
			// check the event already exists in resource or not
			$resource = Resource::model()->findByAttributes(array('typefor' => 'program', 'title' => $event->title));
			// is new
			if (!empty($resource)) {
				echo $resource->title . '<br />';
			}

			echo '</li>';
			++$count;
		}
		exit;

		return array('status' => $status, 'msg' => $msg, 'data' => '');
	}

	public function sendSurveyEmailAfterEvent($surveyType, $eventId = '')
	{
		$settingSendEmailSurvey = Setting::code2value('event-sendPostSurveyEmail');
		if (!$settingSendEmailSurvey) {
			return;
		}

		$surveyTypes = self::getSurveyTypes($eventId);
		$numberOfDays = $surveyTypes[$surveyType]['numberOfDays'];

		$items = self::getEventParticipants($numberOfDays, $eventId);

		foreach ($items as $item) {
			self::sendEmailAfterSurvey($item, $surveyType);
		}

		return $items;
	}

	// numberOfDays: either 1 day or 180 days(6 months)
	// Here we can generalize the email and send one to multiple recipents at the same time
	// Or if we want to send individuals by name then we need to send separate email to each.
	// For now we try to send to indivitual
	/*
	item format:
	Array
	(
		[participants] => Array
			(
				[0] => Array
					(
						[email] => afidz@mymagic.my
						[fullname] => Afidz Che Rosli
					)

				[1] => Array
					(
						[email] => exiang83@gmail.com
						[fullname] => Allen Tan
					)

			)

		[eventId] => 50311
		[eventTitle] => Afidz Test Event for survey
	)*/
	protected function sendEmailAfterSurvey($item, $surveyType)
	{
		foreach ($item['participants'] as $participant) {
			$email = $participant['email'];
			$fullName = $participant['fullname'];
			$parts = explode(' ', $fullName);
			$firstName = '';
			if (count($parts) > 0) {
				$lastName = array_pop($parts);
				$firstName = implode(' ', $parts);
			}
			if (empty($firstName)) {
				$firstName = 'Participant';
			}

			$eventId = $item['eventId'];
			$eventTitle = $item['eventTitle'];

			$surveyTypes = self::getSurveyTypes($eventId);
			$numberOfDays = $surveyTypes[$surveyType]['numberOfDays'];

			// Check if the email has already sent for this user
			// registry code can take up to 128 characters
			$key = sprintf('event-postEventSurveySent-#%s-%s-%s', $eventId, $surveyType, $email);
			$value = '';

			try {
				$value = HubRegistry::get($key);
			} catch (Exception $e) {
				$value = '';
			}

			if (empty($value) || $value <= 0) {
				try {
					$urlSurveyForm = self::getSurveyFormUrl($eventId, $surveyType);

					// Send Actual Email
					if ($surveyType == '1Day') {
						$notifyMaker = NotifyMaker::event_sendPostEventSurvey1Day($eventTitle, $eventId, $firstName, $urlSurveyForm);
					} elseif ($surveyType == '6Months') {
						$notifyMaker = NotifyMaker::event_sendPostEventSurvey6Months($eventTitle, $eventId, $firstName, $urlSurveyForm);
					}

					$result = HUB::sendEmail($email, $fullName, $notifyMaker['title'], $notifyMaker['content']);

					// Mark the email as sent
					if ($result) {
						HubRegistry::set($key, 1);
					}
				} catch (Exception $e) {
					continue;
				}
			}
		}
	}

	protected function getEventParticipants($numberOfDays, $eventId = '')
	{
		// if event id is not specified, query all events base on number of days event passed
		if (empty($eventId)) {
			if ($numberOfDays == 1) {
				$startEpoch = date(strtotime('-1 days'));
				$endEpoch = date(strtotime('today'));
			} else {
				$startEpoch = date(strtotime((string) (-1 * $numberOfDays - 1) . ' days'));
				$endEpoch = date(strtotime((string) (-1 * $numberOfDays) . ' days'));
			}

			$criteria = new CDbCriteria();
			$criteria->addBetweenCondition('date_ended', $startEpoch, $endEpoch);
			$events = Event::model()->findAll($criteria);
		}
		// if event id is specified, query this event only
		else {
			$events[] = Event::model()->findByPk($eventId);
		}

		$eventParticipants = array();

		foreach ($events as $event) {
			// event must be active and not cancel
			if ($event->is_active == 1 && $event->is_cancelled != 1 && $event->is_survey_enabled) {
				$participantDetails = array();
				foreach ($event->eventRegistrationsAttended as $eventRegistration) {
					$participantDetail['email'] = $eventRegistration->email;
					$participantDetail['fullname'] = $eventRegistration->full_name;
					$participantDetails[] = $participantDetail;
				}
				$eventParticipant['participants'] = $participantDetails;
				$eventParticipant['eventId'] = $event->id;
				$eventParticipant['eventTitle'] = $event->title;

				$eventParticipants[] = $eventParticipant;
			}
		}

		return $eventParticipants;
	}

	public function getSurveyForm($eventId, $surveyType)
	{
		$surveyTypes = self::getSurveyTypes($eventId);
		$slug = $surveyTypes[$surveyType]['formSlug'];
		$form = Form::slug2obj($slug);

		return $form;
	}

	public function getSurveyFormUrl($eventId, $surveyType)
	{
		$form = self::getSurveyForm($eventId, $surveyType);
		$url = $form->getPublicUrl(array('eid' => $eventId));

		return $url;
	}

	public function getSurveyTypes($eventId)
	{
		return array(
			'1Day' => array('numberOfDays' => '1', 'formSlug' => 'Feedback1', 'participantsMode' => 'attended'),
			'6Months' => array('numberOfDays' => '180', 'formSlug' => 'Feedback2', 'participantsMode' => 'attended'),
		);
	}

	public function getSurveyTypesForeignReferList($eventId)
	{
		$result = array();
		$types = self::getSurveyTypes($eventId);
		foreach ($types as $key => $params) {
			$form = self::getSurveyForm($eventId, $key);
			$result[$key] = $form->title;
		}

		return $result;
	}

	public function getSystemActFeed($dateStart, $dateEnd, $page = 1, $forceRefresh = 0)
	{
		$limit = 30;
		$status = 'fail';
		$msg = 'Unknown error';

		$timestampStart = strtotime($dateStart);
		$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

		// date range can not be more than 60 days
		if (floor(($timestampEnd - $timestampStart) / (60 * 60 * 24)) > 60) {
			$msg = 'Max date range cannot more than 60 days';
		} else {
			$data = Event::model()->findAll(array(
				'condition' => 'is_active=1 AND is_cancelled!=1 AND (
					(:timestampStart >= date_started AND :timestampEnd <= date_ended) 
					OR 
					(:timestampStart <= date_started AND :timestampEnd >= date_started)
					OR 
					(:timestampStart <= date_ended AND :timestampEnd >= date_ended)
					OR 
					(:timestampStart <= date_started AND :timestampEnd >= date_ended) 
				)',
				'params' => array(':timestampStart' => $timestampStart, ':timestampEnd' => $timestampEnd),
				'offset' => ($page - 1) * $limit,
				'limit' => $limit,
				'order' => 'date_started DESC'
			));

			$status = 'success';
			$msg = '';
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}
}
