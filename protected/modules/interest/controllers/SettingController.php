<?php

class SettingController extends Controller
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
		$this->layout = '/layouts/frontend'; //default layout for cpanel
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->cpanelMenuInterface = 'cpanelNavSetting'; //cpanel menu interface type ex. cpanelNavDashboard, cpanelNavSetting, cpanelNavOrganization, cpanelNavOrganizationInformation
		$this->activeMenuCpanel = 'interest'; //active menu name based on NameModule.php getNavItems() active attribute
	}

	public function actionIndex()
	{
		$this->render('index');
	}
}
