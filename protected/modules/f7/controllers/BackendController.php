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
				'actions' => array('syncForm2Event', 'syncForm2EventConfirmed', 'getOpeningForms'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->activeMenuCpanel = 'f7';
		$this->activeMenuMain = 'f7';
	}

	public function actionSyncForm2Event($id)
	{
		$form = Form::model()->findByPk($id);
		if ($form) {
			if (!empty($form->jsonArray_event_mapping)) {
				Notice::page(Yii::t('f7', 'You are about to sync F7 form submissions to event. Existing paricipated organizations and registrations in the event may be override.'), Notice_WARNING, array(
					'url' => $this->createUrl('//f7/backend/syncForm2EventConfirmed', array('id' => $id)),
					'urlLabel' => Yii::t('f7', 'Ok, proceed'),
					'cancelUrl' => $this->createUrl('//event/view', array('id' => $id)),
				));
			} else {
				Notice::page(Yii::t('f7', 'Unable to proceed: Event Mapping instruction not found'));
			}
		} else {
			Notice::page(Yii::t('f7', 'Form not found'));
		}
	}

	public function actionSyncForm2EventConfirmed($id)
	{
		$form = Form::model()->findByPk($id);
		if ($form) {
			$result = HubForm::syncSubmissions2Event($form);
			if ($result['status'] == 'success') {
				Notice::page(Yii::t('f7', "F7 successfully synced your form to event '{eventTitle}'", array('{eventTitle}' => $result['data']['event']->title)), Notice_SUCCESS, array(
					'url' => $this->createUrl('//event/view', array('id' => $result['data']['event']->id)),
					'urlLabel' => Yii::t('f7', 'View Event'),
				));
			}
		} else {
			Notice::page(Yii::t('f7', 'Form not found'));
		}
	}

	public function actionGetOpeningForms($dateStart, $dateEnd, $forceRefresh = 0)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getF7OpeningForms',
			[
				'form_params' => [
					'dateStart' => $dateStart, 'dateEnd' => $dateEnd, 'forceRefresh' => $forceRefresh,
				],
				'verify' => false,
			]
			);
		} catch (Exception $e) {
			$this->outputJsonFail($e->getMessage());
		}

		header('Content-type: application/json');
		echo $response->getBody();
	}
}
