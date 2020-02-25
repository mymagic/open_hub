<?php

class TestController extends Controller
{
	public $layout = 'layouts.frontend';

	public function actionIndex()
	{
		//if you want to use reflection
		$reflection = new ReflectionClass(TestController);
		$methods = $reflection->getMethods();
		$actions = array();
		foreach ($methods as $method) {
			if (substr($method->name, 0, 6) == 'action' && $method->name != 'actionIndex' && $method->name != 'actions') {
				$methodName4Url = lcfirst(substr($method->name, 6));
				$actions[] = $methodName4Url;
			}
		}

		Yii::t('test', 'Testing');

		$this->render('index', array('actions' => $actions));
	}

	public function actionComment()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if (empty($user)) {
			Notice::page('User Session not found');
		}

		$this->render('comment', array('user' => $user));
	}

	public function actionOriginal()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if (empty($user)) {
			Notice::page('User Session not found');
		}

		$this->render('original', array('user' => $user));
	}

	public function actionOrganizationCountComments()
	{
		$org = Organization::model()->findByPk(3582);
		echo $org->countAllComments();
	}

	public function actionOrganizationGetComments()
	{
		$org = Organization::model()->findByPk(3582);
		print_r($org->getActiveComments(10));
	}
}
