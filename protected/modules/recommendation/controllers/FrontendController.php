<?php

class FrontendController extends Controller
{
	// customParse is for cpanelNavOrganizationInformation to pass in organization ID
	//public $customParse = '';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array(''),
				'users' => array('*'),
			),
			array(
				'allow',
				'actions' => array('index'),
				'users' => array('@'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();

		// for cpanel navigation
		$this->layout = 'frontend'; //default layout for cpanel
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->cpanelMenuInterface = 'cpanelNavDashboard'; //cpanel menu interface type ex. cpanelNavDashboard, cpanelNavSetting, cpanelNavOrganization, cpanelNavOrganizationInformation
		$this->activeMenuCpanel = 'recommendation'; //active menu name based on NameModule.php getNavItems() active attribute
	}

	public function actionIndex()
	{
		$resources = array();
		foreach (Neo4jResource::model()->getRecommendation() as $data) {
			array_push($resources, Resource::model()->findByPk($data));
		}
		$events = array();
		foreach (Neo4jEvent::model()->getRecommendation() as $data) {
			array_push($events, Event::model()->findByPk($data));
		}
		$challenges = array();
		foreach (Neo4jChallenge::model()->getRecommendation() as $data) {
			array_push($challenges, Challenge::model()->findByPk($data));
		}
		$this->render('index', array('resources' => $resources, 'events' => $events, 'challenges' => $challenges));
	}
}
