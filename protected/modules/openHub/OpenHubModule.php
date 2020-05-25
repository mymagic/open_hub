<?php

// use camelcase for class name with first character in uppsercase
class OpenHubModule extends WebModule
{
	public $defaultController = 'frontend';
	private $_assetsUrl;
	public $oauthSecret;
	public $organizationId;
	public $var1;
	public $var2;
	public $githubOrganization;
	public $githubRepoName;
	public $githubReleaseUrl;

	// this method is called when the module is being created
	// you may place code here to customize the module
	public function init()
	{
		require_once dirname(__FILE__) . '/vendor/autoload.php';

		$this->setComponents(array(
			'request' => array(
				'class' => 'HttpRequest',
				'enableCsrfValidation' => false,
			),
		));

		// import the module-level models and components
		$this->setImport(array(
			'openHub.models.*',
			'openHub.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('openHub.assets'));
		}

		return $this->_assetsUrl;
	}

	// this method is called before any module controller action is performed
	// you may place customized code here
	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			if (true == Yii::app()->params['dev']) {
				Yii::app()->assetManager->forceCopy = true;
			}

			return true;
		} else {
			return false;
		}
	}

	//
	// organization
	public function getOrganizationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core organization feature
	public function getOrganizationActions($model, $realm = 'backend')
	{
		return null;
	}

	public function getOrganizationActFeed($organization, $year)
	{
		return null;
	}

	//
	// individual
	// these are the functions called by core individual feature
	public function getIndividualViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	public function getIndividuaActions($model, $realm = 'backend')
	{
		return null;
	}

	public function getIndividualActFeed($individual, $year)
	{
		return null;
	}

	//
	// user
	// these are the functions called by core user feature
	public function getUserActFeed($user, $year)
	{
		$return = array();

		return $return;
	}

	public function getNavItems($controller, $forInterface)
	{
		//for cpanel
		//cpanelNavDashboard , cpanelNavSetting, cpanelNavOrganization, cpanelNavOrganizationInformation
		switch ($forInterface) {
			case 'cpanelNavDashboard': {
					return array(
						//example
						// array(
						// 	'label' => Yii::t('app', 'Boilerplate Test'),
						// 	'url' => '/openHub/openHub',
						// 	'active' => $controller->activeMenuCpanel == 'test' ? true : false,
						// 	'visible' => true,
						// 	'icon' => 'fa-edit'
						// )
					);
					break;
				}
			case 'cpanelNavSetting': {
				}
			case 'cpanelNavOrganization': {
				}
			case 'cpanelNavOrganizationInformation': {
				}
		}
	}

	public function getAsService($interface)
	{
		// $btn = '';
		// // interface type ex: idea, resource, mentor, activate, atas, sea
		// switch ($interface) {
		// 	case 'activate': {
		// 			$btn = array(
		// 				array(
		// 					'title' => 'Check out Challenges',
		// 					'url' => array('//activate')
		// 				)
		// 			);
		// 			break;
		// 		}
		// }
		// return $btn;
	}

	public function getSharedAssets($forInterface = '*')
	{
		switch ($forInterface) {
			case 'layout-backend': {
					$return['css'][] = array('src' => self::getAssetsUrl() . '/css/backend.shared.css');
					$return['js'][] = array('src' => self::getAssetsUrl() . '/javascript/backend.shared.js', 'position' => CClientScript::POS_END);
					break;
				}
			case 'layout-frontend': {
					$return['css'][] = array('src' => self::getAssetsUrl() . '/css/frontend.shared.css');
					$return['js'][] = array('src' => self::getAssetsUrl() . '/javascript/frontend.shared.js', 'position' => CClientScript::POS_END);
					break;
				}
			default: {
					break;
				}
		}

		return $return;
	}

	public function install($forceReset = false)
	{
		return self::installDb($forceReset);
	}

	public function installDb($forceReset = false)
	{
		$migration = Yii::app()->db->createCommand();

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
	}

	public function getDashboardNotices($model, $realm = 'backend')
	{
		$updateInfo = HubOpenHub::getUpdateInfo();
		if ($updateInfo['canUpdate']) {
			$notices[] = array('message' => Yii::t('openHub', 'System update: latest release  {versionReleased} is available. <a href="{urlDownload}" class="btn btn-xs btn-primary">Download</a>', array('{versionReleased}' => $updateInfo['latestRelease']['tag_name'], '{urlDownload}' => HubOpenHub::getUrlLatestRelease())), 'type' => Notice_WARNING);
		}

		return $notices;
	}

	public function doOrganizationsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		$transaction->commit();

		return array($source, $target);
	}

	public function doIndividualsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		$transaction->commit();

		return array($source, $target);
	}
}
