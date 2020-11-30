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

		$this->layout = 'layouts.cpanel'; //default layout for cpanel
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->cpanelMenuInterface = 'cpanelNavDashboard'; //cpanel menu interface type ex. cpanelNavDashboard, cpanelNavSetting, cpanelNavOrganization, cpanelNavOrganizationInformation
		$this->activeMenuCpanel = 'service'; //active menu name based on NameModule.php getNavItems() active attribute
	}

	public function actionIndex()
	{
		$services = HubService::listBookmarkable();
		$result = array();
		//$selected_service_list = HUB::listServiceBookmarkByUser($user);
		$modules = YeeModule::getActiveParsableModules();

		foreach ($services as $key => $service) {
			$actions = array();
			foreach ($modules as $moduleKey => $moduleParams) {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getAsService')) {
					$tmps = Yii::app()->getModule($moduleKey)->getAsService($service->slug);
					foreach ($tmps as $action) {
						array_push($actions, $action);
					}
				}
			}
			$result[$key] = array(
				'data' => $service,
				'actions' => $actions
			);
		}
		$this->render('index', array('services' => $result));
	}
}
