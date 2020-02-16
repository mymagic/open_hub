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
                'actions' => array('eventUpdate', 'eventCreate', 'attendeeChanges'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionEventUpdate()
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

        $junk = new Junk();
        $junk->code = 'eventbrite-callback-eventUpdate-'.rand(10000, 99999);
        $junk->content = $payload;
        $junk->save();

        $jsonArray_payload = json_decode($payload);

        if (!empty($jsonArray_payload) && !empty($jsonArray_payload->api_url)) {
            // call api_url with token thru guzzle
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', $jsonArray_payload->api_url, array(
                'query' => ['token' => Yii::app()->getModule('eventbrite')->oauthSecret],
            ));

            $eventArray = json_decode($response->getBody(), true);
            $result = HubEventbrite::syncEventFromEventbrite($eventArray);

            $junk2 = new Junk();
            $junk2->code = 'eventbrite-callback-eventUpdate-response-'.rand(10000, 99999);
            $junk2->content = serialize($eventArray);
            $junk2->save();

            print_r($result);
        }

        return false;
    }

    public function actionEventCreate()
    {
        $payload = file_get_contents('php://input');

        /*$payload = '{
            "api_url": "https://www.eventbriteapi.com/v3/events/65162904000/",
            "config": {
              "action": "event.created",
              "endpoint_url": "https://hub.mymagic.my/eventbrite/callback/eventCreate",
              "user_id": "107038522227",
              "webhook_id": "1750790"
            }
        }';*/

        $junk = new Junk();
        $junk->code = 'eventbrite-callback-eventCreate-'.rand(10000, 99999);
        $junk->content = $payload;
        $junk->save();

        $jsonArray_payload = json_decode($payload);

        if (!empty($jsonArray_payload) && !empty($jsonArray_payload->api_url)) {
            // call api_url with token thru guzzle
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', $jsonArray_payload->api_url, array(
                'query' => ['token' => Yii::app()->getModule('eventbrite')->oauthSecret],
            ));

            $eventArray = json_decode($response->getBody(), true);
            $result = HubEventbrite::syncEventFromEventbrite($eventArray);

            $junk2 = new Junk();
            $junk2->code = 'eventbrite-callback-eventCreate-response-'.rand(10000, 99999);
            $junk2->content = serialize($eventArray);
            $junk2->save();

            print_r($result);
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
        $junk->code = 'eventbrite-callback-attendeeChanges-'.rand(10000, 99999);
        $junk->content = $payload;
        $junk->save();

        $jsonArray_payload = json_decode($payload);

        if (!empty($jsonArray_payload) && !empty($jsonArray_payload->api_url)) {
            // call api_url with token thru guzzle
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', $jsonArray_payload->api_url, array(
                'query' => ['token' => Yii::app()->getModule('eventbrite')->oauthSecret],
            ));
            $attendeeArray = json_decode($response->getBody(), true);
            $result = HubEventbrite::syncEventRegistrationFromEventbrite(array($attendeeArray));

            $junk2 = new Junk();
            $junk2->code = 'eventbrite-callback-attendeeChanges-response-'.rand(10000, 99999);
            $junk2->content = serialize($attendeeArray);
            $junk2->save();

            print_r($result);
        }

        return false;
    }
}
