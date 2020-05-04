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
				'actions' => array('index'),
				'users' => array('*'),
			),
			array(
				'allow',
				'actions' => array(),
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
		$this->layout = 'frontend';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);

		// for cpanel navigation
		// $this->layout = 'layout.cpanel'; //default layout for cpanel
		// $this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		// $this->cpanelMenuInterface = 'cpanelNavDashboard'; //cpanel menu interface type ex. cpanelNavDashboard, cpanelNavSetting, cpanelNavOrganization, cpanelNavOrganizationInformation
		// $this->customParse = ''; //to pass in organization ID for cpanelNavOrganizationInformation
		// $this->activeMenuCpanel = ''; //active menu name based on NameModule.php getNavItems() active attribute
	}

	public function actionIndex()
	{
		$this->render('index');
	}
}
