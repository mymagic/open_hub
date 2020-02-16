<?php

class FrontendController extends Controller
{
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
                'actions' => array('index', 'register'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array(),
                'users' => array('@'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ), g,
        );
    }

    public function init()
    {
        parent::init();
        $this->layout = 'frontend';
        $this->activeMenuCpanel = 'eventbrite';
        $this->activeMenuMain = 'eventbrite';
        $this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
        $this->layoutParams['isShowMenuSubLanguageSelector'] = false;
    }

    public function actions()
    {
        return array(
        );
    }

    public function actionIndex()
    {
        $this->activeMenuSub = 'index';

        $this->layoutParams['containerFluid'] = true;
    }

    // id is actually eventbrite event code
    public function actionRegister($id)
    {
        $this->activeMenuSub = 'index';

        $this->layoutParams['containerFluid'] = false;
        $this->menuSub = array(
            'start' => array('label' => Yii::t('app', 'Browse Events'), 'url' => '//mymagic.my/events/?fwp_event_date=upcoming'),
        );

        $event = HubEventbrite::getEventByCode($id);
        if (empty($event)) {
            Notice::page(Yii::t('eventbrite', 'Event Not Found'));
        }

        $this->pageTitle = Yii::t('app', 'Event Registration - {eventName}', array('{eventName}' => $event->title));

        $this->render('register', array('event' => $event));
    }

    public function actionRegisterCheck($id)
    {
        $this->redirect(array('register', 'id' => $id));
    }
}
