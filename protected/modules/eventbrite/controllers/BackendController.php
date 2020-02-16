<?php

class BackendController extends Controller
{
    public $layout = 'backend';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('sync2Event', 'sync2EventConfirmed', 'sync2EventRegistrationConfirmed'),
                'users' => array('@'),
                'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ), g,
        );
    }

    public function init()
    {
        parent::init();
        $this->activeMenuCpanel = 'eventbrite';
        $this->activeMenuMain = 'eventbrite';
    }

    public function actions()
    {
        return array(
        );
    }

    public function actionIndex()
    {
    }

    public function actionSync2Event($page = 1, $code = '')
    {
        $realm = 'backend';
        $this->layout = 'backend';

        // get all events and list for user to select which to sync
        $result = HubEventbrite::getEvents(1);

        if (!empty($code)) {
            $event = HubEventbrite::getEvent($code);
            Notice::page(Yii::t('eventbrite', "Are you sure to sync event '{eventTitle}' and all its registrations from Eventbrite to this system?", array('{eventTitle}' => $event['name']['text'])), Notice_WARNING,
                array(
                    'url' => $this->createUrl('/eventbrite/backend/sync2EventConfirmed', array('code' => $code)),
                    'urlLabel' => Yii::t('core', 'Yes'),
                    'cancelUrl' => $this->createUrl('/eventbrite/backend/sync2Event', array('page' => $page)),
                    'cancelUrlLabel' => Yii::t('core', 'No'),
                )
            );
        }

        /*echo '<pre>';
        print_r($result);
        exit;*/

        $this->render('sync2Event', array('result' => $result, 'page' => $page));
    }

    public function actionSync2EventConfirmed($code)
    {
        if (!empty($code)) {
            // get event and update/insert to db
            $event = HubEventbrite::getEvent($code);
            HubEventbrite::syncEventFromEventbrite($event);

            // redirect to sync2EventRegistrationConfirmed
            $this->redirect(array('/eventbrite/backend/sync2EventRegistrationConfirmed', 'code' => $code));
        }
    }

    public function actionSync2EventRegistrationConfirmed($code)
    {
        if (!empty($code)) {
            $event = HubEventbrite::getEventByCode($code);
            $attendees = HubEventbrite::getAttendeesAllPages($code);
            if (count($attendees) > 0) {
                $result = HubEventbrite::syncEventRegistrationFromEventbrite($attendees);
            } else {
                Notice::page(Yii::t('eventbrite', 'This program has no attendee yet'), Notice_INFO);
            }

            if ($result['status'] == 'success') {
                Notice::page($result['msg'], Notice_SUCCESS, array('url' => $this->createUrl('/event/view', array('id' => $event->id))));
            }
        }
    }
}
