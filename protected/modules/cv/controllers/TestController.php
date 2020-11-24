<?php

class TestController extends Controller
{
	public $layout = 'layouts.backend';

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

	public function actionExperienceStateCountry($id)
	{
		$exp = CvExperience::model()->findByPk($id);
		echo '<pre>';
		echo 'Before Save<br>';
		print_r($exp);

		//$exp->full_address = '642-A, Jln Yong Pak Khian, Tmn Nam Yang, Ujong Pasir, 75050 Melaka';
		$exp->full_address = '130, Jln Warisan Indah 8/16, Kota Warisan, 43900 Selangor';
		$exp->resetAddressParts();
		$exp->save();

		echo 'After Save<br>';
		print_r($exp);
	}

	public function actionGetExperiences($username)
	{
		$limit = 30;
		$user = HUB::getUserByUsername($username);
		$portfolio = HubCv::getCvPortfolioByUser($user);
		$data = $portfolio->gaugeComposedExperiences();
		echo '<pre>';
		print_r($data);
		$data = $portfolio->getComposedExperiences(1, $limit);

		echo '<pre>';
		print_r($data);
	}

	public function actionCvOrganizationBehavior()
	{
		$organization = new Organization;
		var_dump($organization->shoutCv());
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
}
