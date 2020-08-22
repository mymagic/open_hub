<?php

class HubEventbrite
{
	// query eventbrite_organization_webhook to find detail data using eventbrite account id
	public static function getWebhookByAccountId($accountId)
	{
		$result = EventbriteOrganizationWebhook::model()->find('eventbrite_account_id=:accountId', array(':accountId' => $accountId));

		return $result;
	}

	public static function getWebhookById($webhookId)
	{
		$result = EventbriteOrganizationWebhook::model()->findByPk($webhookId);

		return $result;
	}

	public static function getAllActiveWebhooks()
	{
		$result = EventbriteOrganizationWebhook::model()->findAll('is_active=:isActive', array(':isActive' => 1));

		return $result;
	}

	public static function getSyncableWebhooks()
	{
		$result = EventbriteOrganizationWebhook::model()->findAll("is_active=:isActive AND eventbrite_oauth_secret IS NOT NULL AND eventbrite_oauth_secret != ''", array(':isActive' => 1));

		return $result;
	}

	// get event from db by eventbrite code
	public static function getEventByCode($code)
	{
		return Event::model()->findByAttributes(array('code' => $code, 'vendor' => 'eventbrite'));
	}

	// return eventbrite objects as result
	public static function getEvents($webhook, $page = 1)
	{
		$client = new exiang\eventbrite\HttpClient($webhook->eventbrite_oauth_secret);
		$result = $client->get(sprintf('/organizations/%s/events/?page=%s&order_by=start_desc', $webhook->eventbrite_account_id, $page));

		return $result;
	}

	public static function getEvent($webhook, $id)
	{
		$client = new exiang\eventbrite\HttpClient($webhook->eventbrite_oauth_secret);
		$result = $client->get(sprintf('/events/%s?expand=organizer,venue', $id));

		return $result;
	}

	public static function getAttendees($webhook, $id, $page = 1)
	{
		$client = new exiang\eventbrite\HttpClient($webhook->eventbrite_oauth_secret);
		$result = $client->get(sprintf('/events/%s/attendees?page=%s&expand=order', $id, $page));

		return $result;
	}

	// return only the attendees section of the returned json of all pages
	// https://hubd.mymagic.my/eventbrite/backend/sync2EventRegistrationConfirmed/code/28450779046
	public static function getAttendeesAllPages($webhook, $id)
	{
		$result = array();

		// get the first page of attendees
		$pages[1] = self::getAttendees($webhook, $id, 1);
		$result = $pages[1]['attendees'];

		// has multiple pages
		if ($pages[1]['pagination']['page_count'] > 1) {
			// get subsequence pages
			for ($i = 2; $i <= $pages[1]['pagination']['page_count']; ++$i) {
				$pages[$i] = self::getAttendees($webhook, $id, $i);
				$result = array_merge($result, $pages[$i]['attendees']);
			}
		}

		return $result;
	}

	// pass in event object acquited from api
	public static function syncEventFromEventbrite($webhook, $event)
	{
		$status = 'fail';
		$msg = 'Unknown error';
		$sql = '';

		if (empty($event['name']['text'])) {
			$msg = 'Cannot sync event with empty title';
		} else {
			$sql = self::buildEventInsertUpdateSql($event);

			if (Yii::app()->db->createCommand($sql)->execute()) {
				$count = 1;
				$status = 'success';
				$msg = sprintf('%s new/existing records updated', $count);

				$event = Event::model()->findByPk(Yii::app()->db->lastInsertID);
				if (!$event->hasEventOwner($webhook->organization_code, $webhook->as_role_code)) {
					// add event owner
					$owner = new EventOwner;
					$owner->event_code = $event->code;
					$owner->organization_code = $webhook->organization_code;
					$owner->as_role_code = $webhook->as_role_code;
					$owner->save();
				}

				$log = Yii::app()->esLog->log(sprintf('synced %s events from Eventbrite thru api', $count), 'event', array('trigger' => 'HubEventbrite::syncEventFromEventbrite', 'model' => 'Event', 'action' => '', 'id' => ''));
			}
		}

		return array('status' => $status, 'msg' => $msg, 'data' => '');
	}

	protected static function buildEventInsertUpdateSql($event)
	{
		$addressCountryCode = $latlong = 'NULL';
		if (!empty($event['venue']['address']) && !empty($event['venue']['address']['latitude']) && !empty($event['venue']['address']['longitude'])) {
			$latlong = sprintf('POINT(%s, %s)', $event['venue']['address']['latitude'], $event['venue']['address']['longitude']);
		}
		if (!empty($event['venue']['address']) && !empty($event['venue']['address']['country'])) {
			$addressCountryCode = Yii::app()->db->quoteValue($event['venue']['address']['country']);
		}

		if ($event['status'] == 'draft') {
			$isActive = 0;
		} else {
			$isActive = 1;
		}

		// php7 compatible
		if (!empty($event['venue']['name'])) {
			$sql = sprintf(
				'INSERT INTO event (code, title, text_short_desc, date_started, date_ended, at, email_contact, full_address, address_country_code, latlong_address, vendor, vendor_code, json_original, is_active, date_added, date_modified) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE code=VALUES(code), title=VALUES(title), text_short_desc=VALUES(text_short_desc), date_started=VALUES(date_started), date_ended=VALUES(date_ended), at=VALUES(at), email_contact=VALUES(email_contact), full_address=VALUES(full_address), address_country_code=VALUES(address_country_code), latlong_address=VALUES(latlong_address), vendor=VALUES(vendor), vendor_code=VALUES(vendor_code), json_original=VALUES(json_original), is_active=VALUES(is_active), date_modified=VALUES(date_modified); ',
				Yii::app()->db->quoteValue($event['id']),
				Yii::app()->db->quoteValue($event['name']['text']),
				Yii::app()->db->quoteValue($event['description']['text']),
				strtotime($event['start']['utc']),
				strtotime($event['end']['utc']),
				Yii::app()->db->quoteValue($event['venue']['name']),
				Yii::app()->db->quoteValue(''),
				Yii::app()->db->quoteValue($event['venue']['address']['localized_address_display']),
				$addressCountryCode,
				($latlong),
				Yii::app()->db->quoteValue('eventbrite'),
				Yii::app()->db->quoteValue($event['id']),
				Yii::app()->db->quoteValue(json_encode($event)),
				$isActive,
				time(),
				time()
			);
		} else {
			$sql = sprintf(
				'INSERT INTO event (
				code, title, text_short_desc, date_started, date_ended, 
				email_contact, full_address, address_country_code, latlong_address, vendor, 
				vendor_code, json_original, is_active, date_added, date_modified) VALUES (
				%s, %s, %s, %s, %s, 
				%s, %s, %s, %s, %s, 
				%s, %s, %s, %s, %s)
                ON DUPLICATE KEY UPDATE code=VALUES(code), title=VALUES(title), text_short_desc=VALUES(text_short_desc), date_started=VALUES(date_started), date_ended=VALUES(date_ended), at=VALUES(at), email_contact=VALUES(email_contact), full_address=VALUES(full_address), address_country_code=VALUES(address_country_code), latlong_address=VALUES(latlong_address), vendor=VALUES(vendor), vendor_code=VALUES(vendor_code), json_original=VALUES(json_original), is_active=VALUES(is_active), date_modified=VALUES(date_modified); ',
				Yii::app()->db->quoteValue($event['id']),
				Yii::app()->db->quoteValue($event['name']['text']),
				Yii::app()->db->quoteValue($event['description']['text']),
				strtotime($event['start']['utc']),
				strtotime($event['end']['utc']),
				Yii::app()->db->quoteValue(''),
				Yii::app()->db->quoteValue($event['venue']['address']['localized_address_display']),
				$addressCountryCode,
				($latlong),
				Yii::app()->db->quoteValue('eventbrite'),
				Yii::app()->db->quoteValue($event['id']),
				Yii::app()->db->quoteValue(json_encode($event)),
				$isActive,
				time(),
				time()
			);
		}

		return $sql;
	}

	// pass in attendees array
	public static function syncEventRegistrationFromEventbrite($attendees)
	{
		$status = 'fail';
		$msg = 'Unknown error';
		$sql = '';

		$event_vendor_code = 'eventbrite';
		$registration_code = [];

		foreach ($attendees as $attendee) {
			$sql .= self::buildEventRegistrationInsertUpdateSql($attendee);

			if (isset($attendee['id'])) {
				$registration_code[] = $attendee['id'];
			}
		}

		// echo $sql;
		// exit;
		if (Yii::app()->db->createCommand($sql)->execute()) {
			$count = count($attendees);
			$status = 'success';
			$msg = sprintf('%s new/existing registration records updated', $count);

			$log = Yii::app()->esLog->log(sprintf('synced %s event registrations from Eventbrite thru api', $count), 'event', array('trigger' => 'HubEventbrite::syncEventRegistrationFromEventbrite', 'model' => 'Event', 'action' => '', 'id' => ''));

			/* use for update bumi/indian status when this function is being called */
			if (!empty($registration_code)) {
				$mEventRegistration = EventRegistration::model()->findAllByAttributes(['event_vendor_code' => $event_vendor_code, 'registration_code' => $registration_code]);
				if (!empty($mEventRegistration)) {
					foreach ($mEventRegistration as $eventRegistration) {
						$update = HubBumi::updateIsBumiIndianForEventRegistration($eventRegistration);
					}
				}
			}
		}

		return array('status' => $status, 'msg' => $msg, 'data' => '');
	}

	// pass in single attendee array
	/*
		Array
		(
			[team] =>
			[costs] => Array
				(
					[base_price] => Array
						(
							[display] => RM0.95
							[currency] => MYR
							[value] => 95
							[major_value] => 0.95
						)

					[eventbrite_fee] => Array
						(
							[display] => RM0.05
							[currency] => MYR
							[value] => 5
							[major_value] => 0.05
						)

					[gross] => Array
						(
							[display] => RM1.00
							[currency] => MYR
							[value] => 100
							[major_value] => 1.00
						)

					[payment_fee] => Array
						(
							[display] => RM0.00
							[currency] => MYR
							[value] => 0
							[major_value] => 0.00
						)

					[tax] => Array
						(
							[display] => RM0.00
							[currency] => MYR
							[value] => 0
							[major_value] => 0.00
						)

				)

			[resource_uri] => https://www.eventbriteapi.com/v3/events/64592778740/attendees/1261812597/
			[id] => 1261812597
			[changed] => 2019-07-17T03:21:50Z
			[created] => 2019-07-17T03:18:48Z
			[quantity] => 1
			[variant_id] =>
			[profile] => Array
				(
					[first_name] => tan
					[last_name] => yee siang
					[addresses] => Array
						(
						)

					[company] => Minda Cerdas
					[cell_phone] => 0126130617
					[email] => exiang83@yahoo.com
					[name] => tan yee siang
				)

			[barcodes] => Array
				(
					[0] => Array
						(
							[status] => unused
							[barcode] => 9853591691261812597001
							[created] => 2019-07-17T03:21:50Z
							[changed] => 2019-07-17T03:21:50Z
							[checkin_type] => 0
							[is_printed] =>
						)

				)

			[answers] => Array
				(
					[0] => Array
						(
							[answer] => Experience Entrepreneur
							[question] => Persona
							[type] => multiple_choice
							[question_id] => 24255802
						)

				)

			[checked_in] =>
			[cancelled] =>
			[refunded] =>
			[affiliate] => etckt
			[guestlist_id] =>
			[invited_by] =>
			[status] => Attending
			[ticket_class_name] => Standard
			[delivery_method] => electronic
			[event_id] => 64592778740
			[order_id] => 985359169
			[ticket_class_id] => 117691903
			[order] => Array
				(
					[costs] => Array
						(
							[base_price] => Array
								(
									[display] => RM0.95
									[currency] => MYR
									[value] => 95
									[major_value] => 0.95
								)

							[eventbrite_fee] => Array
								(
									[display] => RM0.05
									[currency] => MYR
									[value] => 5
									[major_value] => 0.05
								)

							[gross] => Array
								(
									[display] => RM1.00
									[currency] => MYR
									[value] => 100
									[major_value] => 1.00
								)

							[payment_fee] => Array
								(
									[display] => RM0.00
									[currency] => MYR
									[value] => 0
									[major_value] => 0.00
								)

							[tax] => Array
								(
									[display] => RM0.00
									[currency] => MYR
									[value] => 0
									[major_value] => 0.00
								)

						)

					[resource_uri] => https://www.eventbriteapi.com/v3/orders/985359169/
					[id] => 985359169
					[changed] => 2019-07-17T03:21:50Z
					[created] => 2019-07-17T03:18:48Z
					[name] => tan yee siang
					[first_name] => tan
					[last_name] => yee siang
					[email] => exiang83@yahoo.com
					[status] => placed
					[time_remaining] =>
					[event_id] => 64592778740
				)

		)
	*/
	protected static function buildEventRegistrationInsertUpdateSql($attendee)
	{
		$jsonOriginal = json_encode($attendee);
		if ($attendee['profile']['email'] == 'exiang83@yahoo.com') {
			//echo '<pre>';print_r($attendee);exit;
		}
		$fullName = $attendee['profile']['name'];
		// organization
		$organizationName = null;
		if (isset($attendee['profile']['company'])) {
			$organizationName = $attendee['profile']['company'];
		}
		// mobileNumber
		$mobileNumber = null;
		if (isset($attendee['profile']['cell_phone'])) {
			$email = $attendee['profile']['cell_phone'];
		}
		// email
		$email = null;
		if (isset($attendee['profile']['email'])) {
			$email = $attendee['profile']['email'];
		}
		// gender
		$gender = 'unknown';
		if (isset($attendee['profile']['gender'])) {
			$gender = $attendee['profile']['gender'];
		}

		// age_group
		$ageGroup = null;
		if (isset($attendee['profile']['age'])) {
			$gender = $attendee['profile']['age'];
		}

		// where_found
		$whereFound = null;

		// persona
		$persona = null;
		if (isset($attendee['answers'])) {
			foreach ($attendee['answers'] as $answer) {
				if ($answer['question'] == 'Persona') {
					$persona = $answer['answer'];
				}
				if ($answer['question'] == 'Which best describes you?' && $answer['type'] == 'multiple_choice') {
					$persona = implode(';', preg_replace('/\\\\/', '', array_map('trim', explode('|', $answer['answer']))));
				}
			}
		}

		//?
		$country = null;
		//?
		$race = null;
		// ?
		$title = null;
		// ?
		$currency = null;
		if (isset($attendee['costs']['gross']['currency'])) {
			$currency = $attendee['costs']['gross']['currency'];
		}
		// ?
		$validity = null;
		// ?
		$status = null;
		// ?
		$ticketId = null;
		if (isset($attendee['id'])) {
			$ticketId = $attendee['id'];
		}
		// ?
		$paymentMethod = null;
		// ?
		$paymentStatus = null;
		// ?
		$ticketName = null;
		if (isset($attendee['ticket_class_name'])) {
			$ticketName = $attendee['ticket_class_name'];
		}
		// ?
		$orderType = null;
		// ?
		$price = null;
		// paid_fee
		$paidFee = 0;
		if (!empty($attendee['costs']['gross']['major_value'])) {
			$paidFee = $attendee['costs']['gross']['major_value'];
		}
		// ?
		$fees = null;
		// not provided by eventbrite api
		$promoCode = 'null';
		// payment date is not clearly stated in api. either date created or changed from the order object
		$datePayment = 'null';
		if (isset($attendee['order']) && !empty($attendee['order']['changed']) && $attendee['order']['status'] == 'placed') {
			$datePayment = strtotime($attendee['order']['changed']);
		}

		//print_r($jsonOriginal->venue->displayAddress);exit;
		// php7 incompatible
		$sql = sprintf(
			'INSERT INTO event_registration (event_code, event_id, event_vendor_code, registration_code, full_name, first_name, last_name, email, phone, is_attended, organization, gender, age_group, where_found, persona, paid_fee, json_original, date_registered, date_payment, date_added, date_modified) VALUES (%s, (SELECT id FROM event WHERE code=%s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) 
            ON DUPLICATE KEY UPDATE event_code=VALUES(event_code), event_id=VALUES(event_id), event_vendor_code=VALUES(event_vendor_code), registration_code=VALUES(registration_code), full_name=VALUES(full_name), first_name=VALUES(first_name), last_name=VALUES(last_name), email=VALUES(email), phone=VALUES(phone), is_attended=VALUES(is_attended), organization=VALUES(organization), gender=VALUES(gender), age_group=VALUES(age_group), where_found=VALUES(where_found), persona=VALUES(persona), paid_fee=VALUES(paid_fee), json_original=VALUES(json_original), date_registered=VALUES(date_registered), date_payment=VALUES(date_payment), date_modified=VALUES(date_modified); ',
			Yii::app()->db->quoteValue($attendee['event_id']),
			Yii::app()->db->quoteValue($attendee['event_id']),
			Yii::app()->db->quoteValue('eventbrite'),
			Yii::app()->db->quoteValue($ticketId),
			Yii::app()->db->quoteValue($fullName),
			Yii::app()->db->quoteValue($attendee['profile']['first_name']),
			Yii::app()->db->quoteValue($attendee['profile']['last_name']),
			Yii::app()->db->quoteValue($email),
			Yii::app()->db->quoteValue($mobileNumber),
			$attendee['checked_in'] ? '1' : '0',
			Yii::app()->db->quoteValue($organizationName),
			Yii::app()->db->quoteValue($gender),
			Yii::app()->db->quoteValue($ageGroup),
			Yii::app()->db->quoteValue($whereFound),
			Yii::app()->db->quoteValue($persona),
			Yii::app()->db->quoteValue($paidFee),
			Yii::app()->db->quoteValue($jsonOriginal),
			strtotime($attendee['created']),
			($datePayment),
			time(),
			time()
		);

		return $sql;
	}

	public static function eventStatus2BadgeClass($status)
	{
		if ($status == 'live') {
			return 'success';
		} elseif ($status == 'completed') {
			return 'primary';
		} else {
			return 'default';
		}
	}
}
