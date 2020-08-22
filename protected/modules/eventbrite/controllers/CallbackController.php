<?php

class CallbackController extends Controller
{
	public $layout = 'frontend';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'eventbriteCallback' actions
				'actions' => array('eventChanges', 'attendeeChanges'),
				'users' => array('*'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionEventChanges()
	{
		$payload = file_get_contents('php://input');
		/*$payload = '{
			"config":
			{
				"action": "event.updated",
				"user_id": "107038522227",
				"endpoint_url": "https://hub.mymagic.my/eventbrite/callback/index",
				"webhook_id": "1750758"
			},
			"api_url": "https://www.eventbriteapi.com/v3/events/64592778740/"
		}';*/
		/*$payload = '{
			"api_url": "https://www.eventbriteapi.com/v3/events/65162904000/",
			"config": {
			  "action": "event.created",
			  "endpoint_url": "https://hub.mymagic.my/eventbrite/callback/eventCreate",
			  "user_id": "107038522227",
			  "webhook_id": "1750790"
			}
		}';*/

		$jsonArray_payload = json_decode($payload);

		$actionKey = 'eventUpdate';
		if ($jsonArray_payload->config->action == 'event.created') {
			$actionKey = 'eventCreate';
		}

		$junk = new Junk();
		$junk->code = sprintf('eventbrite-callback-%s-%s', $actionKey, rand(10000, 99999));
		$junk->content = $payload;
		$junk->save();

		if (!empty($jsonArray_payload) && !empty($jsonArray_payload->api_url) && !empty($jsonArray_payload->config)) {
			$webhook = HubEventbrite::getWebhookByAccountId($jsonArray_payload->config->user_id);

			// call api_url with token thru guzzle
			$client = new GuzzleHttp\Client();
			$response = $client->request('GET', $jsonArray_payload->api_url, array(
				'query' => ['token' => $webhook->eventbrite_oauth_secret],
			));

			$eventArray = json_decode($response->getBody(), true);
			$result = HubEventbrite::syncEventFromEventbrite($webhook, $eventArray);

			$junk2 = new Junk();
			$junk->code = sprintf('eventbrite-callback-%s-response-%s', $actionKey, rand(10000, 99999));
			$junk2->content = serialize($eventArray);
			$junk2->save();
		}

		return false;
	}

	public function actionAttendeeChanges()
	{
		$payload = file_get_contents('php://input');
		/*$payload = '{
			"api_url": "https://www.eventbriteapi.com/v3/events/65162904000/attendees/1254029469/",
			"config": {
				"action": "attendee.updated",
				"endpoint_url": "https://hub.mymagic.my/eventbrite/callback/attendeeChanges",
				"user_id": "107038522227",
				"webhook_id": "1750804"
			}
		}';*/

		$junk = new Junk();
		$junk->code = 'eventbrite-callback-attendeeChanges-' . rand(10000, 99999);
		$junk->content = $payload;
		$junk->save();

		$jsonArray_payload = json_decode($payload);

		if (!empty($jsonArray_payload) && !empty($jsonArray_payload->api_url) && !empty($jsonArray_payload->config)) {
			$webhook = HubEventbrite::getWebhookByAccountId($jsonArray_payload->config->user_id);

			// call api_url with token thru guzzle
			$client = new GuzzleHttp\Client();
			$response = $client->request('GET', $jsonArray_payload->api_url, array(
				'query' => ['token' => $webhook->eventbrite_oauth_secret],
			));
			$attendeeArray = json_decode($response->getBody(), true);
			$result = HubEventbrite::syncEventRegistrationFromEventbrite(array($attendeeArray));

			$junk2 = new Junk();
			$junk2->code = 'eventbrite-callback-attendeeChanges-response-' . rand(10000, 99999);
			$junk2->content = serialize($attendeeArray);
			$junk2->save();
		}

		return false;
	}
}
