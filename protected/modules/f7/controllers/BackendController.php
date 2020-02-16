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
                'actions' => array('sync2Event', 'sync2EventConfirmed'),
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
        $this->activeMenuCpanel = 'f7';
        $this->activeMenuMain = 'f7';
    }

    public function actions()
    {
        return array(
        );
    }

    public function actionIndex()
    {
    }
    
    public function actionSync2Event($pipeline = '', $id = '', $title = '')
    {
        $pipeline = $_POST['pipeline'];
        $selectedForm = $_POST['form'];
        $importAs = $_POST['importAs'];

        $id = $_POST['id_hidden'];
        $title = $_POST['title_hidden'];

        Notice::page(Yii::t('backend', 'You are about to sync F7 form submissions to event. Click OK to continue.'), Notice_WARNING, array(
            'url' => $this->createUrl('//f7/backend/sync2EventConfirmed', array('id' => $id, 'title' => $title, 'pipeline' => $pipeline, 'form' => $selectedForm, 'importas' => $importAs)),
            'cancelUrl' => $this->createUrl("//event/view?id=$id"),
        ));
    }

    public function actionSync2EventConfirmed($id = '', $title, $pipeline = '', $form = '', $importas = '')
    {
        HubForm::SyncSubmissionsToEvent($title, $pipeline, $form, $importas);

        $this->redirect(array('//event/view', 'id' => $id));
    }
}
