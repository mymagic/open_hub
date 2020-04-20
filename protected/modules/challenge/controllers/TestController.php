<?php

class TestController extends Controller
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
		$reflection = new ReflectionClass(TestController);
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

	public function actionGet($id)
	{
		$challenge = challenge::model()->findByPk($id);
		echo '<pre>';
		print_r($challenge->toApi());
		echo '<pre>';
		print_r($challenge->ownerOrganization->toApi());
		echo '<pre>';
		print_r($challenge->creatorUser->toApi());
	}
}
