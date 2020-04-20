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
