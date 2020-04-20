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

	public function actionMatchWebhook($accountId)
	{
		$result = HubEventbrite::getWebhookByAccountId($accountId);
		echo '<pre>';
		print_r($result->organization->title);
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

	public function actionListEvents($oauthSecret, $organizationId)
	{
		$client = new exiang\eventbrite\HttpClient($oauthSecret);
		$tmps = $client->get(sprintf('/organizations/%s/events/?page=1&order_by=name_desc', $organizationId));
		echo '<pre>';
		print_r($tmps);
		exit;
	}

	public function actionTestPath()
	{
		$path = 'https://www.abc.com?a=3&b=4&c=5';
		if (strstr($path, '?')) {
			list($path, $pathParams) = explode('?', $path);
		}

		echo $pathParams;
	}
}
