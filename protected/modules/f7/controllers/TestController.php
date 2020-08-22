<?php

class TestController extends Controller
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
			array('allow',  // deny all users
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)["id"=>"custom","action"=>(object)["id"=>"developer"]])',
	  ),
	  array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		//if you want to use reflection
		$reflection = new ReflectionClass('TestController');
		$methods = $reflection->getMethods();
		$actions = array();
		foreach ($methods as $method) {
			if (substr($method->name, 0, 6) == 'action' && $method->name != 'actionIndex' && $method->name != 'actions') {
				$methodName4Url = lcfirst(substr($method->name, 6));
				$actions[] = $methodName4Url;
			}
		}

		Yii::t('test', 'Test actions');

		$this->render('index', array('actions' => $actions));
	}

	public function actionExecHook($fid)
	{
		$form = Form::model()->findByPk($fid);
		$submission = FormSubmission::model()->findByPk(1984);
		if ($hook = $form->hasHook('onNotifyAfterSubmitForm')) {
			//var_dump(call_user_func($hook->call, array('submission' => $submission)));
			var_dump($form->execHook('onNotifyAfterSubmitForm', array('submission' => $submission)));
		}
	}

	public function actionHasHook($fid)
	{
		$form = Form::model()->findByPk($fid);
		print_r($form->hasHook('onNotifyAfterSubmitForm'));
	}

	public function actionRenderJsonData($sid)
	{
		$submission = FormSubmission::model()->findByPk($sid);
		print_r($submission->renderJsonData('csv'));
	}

	// https://hubd.mymagic.my/f7/test/notifyMakerAfterChangedSubmit2Draft?sid=1982
	public function actionNotifyMakerAfterSubmitForm($sid)
	{
		$submission = FormSubmission::model()->findByPk($sid);
		$notifyMaker = HubForm::notifyMaker_user_afterSubmitForm($submission);
		print_r($notifyMaker);
		exit;
	}

	// https://hubd.mymagic.my/f7/test/notifyMakerAfterChangedSubmit2Draft?sid=1982
	public function actionNotifyMakerAfterChangedSubmit2Draft($sid)
	{
		$submission = FormSubmission::model()->findByPk($sid);
		$notifyMaker = HubForm::notifyMaker_user_afterChangedSubmit2Draft($submission);
		print_r($notifyMaker);
		exit;
	}

	public function actionCountRelation($formId)
	{
		$form = Form::model()->findByPk($formId);
		//echo $form->countSubmittedFormSubmissions();
		echo '<br >';
		//echo $form->countDraftFormSubmissions();
		echo '<br >';
		echo '<pre>';
		print_r($form->countWorkflowFormSubmissions());
	}

	public function actionF7OrganizationBehavior($id)
	{
		$organization = Organization::model()->findByPk($id);
		foreach ($organization->getFormSubmissions() as $submission) {
			echo sprintf('<li>#%d - %s</li>', $submission->id, $submission->status);
		}
	}

	public function actionGetF7UserActFeed()
	{
		$year = date('Y');
		$timestampStart = mktime(0, 0, 0, 1, 1, $year);
		$timestampEnd = mktime(0, 0, 0, 1, 1, $year + 1);

		$user = HUB::getUserByUsername('yee.siang@mymagic.my');
		$formSubmissions = HubForm::getFormSubmissions($user);
		//print_r($formSubmissions);

		if (!empty($formSubmissions)) {
			foreach ($formSubmissions as $formSubmission) {
				// filter all booking by email to this year
				if ($formSubmission->date_added >= $timestampStart && $formSubmission->date_added < $timestampEnd) {
					$msg = Yii::t('f7', "Your submission #{submissionId} for '{formTitle}' is in {status} mode.", array('{submissionId}' => $formSubmission->id, '{formTitle}' => $formSubmission->form->title, '{status}' => $formSubmission->formatEnumStatus($formSubmission->status)));
					echo $msg;
				}
			}
		}
	}
}
