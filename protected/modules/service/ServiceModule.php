<?php

// use camelcase for class name with first character in uppsercase
class ServiceModule extends WebModule
{
	public $defaultController = 'frontend';
	private $_assetsUrl;
	public $oauthSecret;
	public $organizationId;
	public $var1;
	public $var2;

	// this method is called when the module is being created
	// you may place code here to customize the module
	public function init()
	{
		$this->setComponents(array(
			'request' => array(
				'class' => 'HttpRequest',
				'enableCsrfValidation' => false,
			),
		));

		// import the module-level models and components
		$this->setImport(array(
			'service.models.*',
			'service.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('service.assets'));
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
	// these are the functions called by core organization feature
	public function getOrganizationActions($model, $realm = 'backend')
	{
		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplatStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplatStart/backend/action1', array('id' => $model->id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['boilerplatStart'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplatStart/frontend/action1', array('id' => $model->id)),
			);
		}
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
			if (Yii::app()->user->accessBackend) {
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
						array(
							'label' => Yii::t('app', 'Services'),
							'url' => '/service',
							'active' => $controller->activeMenuCpanel == 'service' ? true : false,
							'visible' => true,
							'icon' => 'fa-cogs'
						)
					);
					break;
				}
			case 'cpanelNavSetting': {
				}
			case 'cpanelNavOrganization': {
				}
			case 'cpanelNavOrganizationInformation': {
				}
			case 'backendNavDev': {
				return array(
					array('label' => Yii::t('service', 'Service'), 'url' => array('/service/service/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true)
				);

				break;
			}
		}
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
		//$migration = new Migration();
		if ($forceReset) {
		}

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['service'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'intake' => array(
				'tabLabel' => Yii::t('backend', 'Boilerplate'),
				'itemViewPath' => 'application.modules.service.views.backend._view-service-advanceSearch',
				'result' => $result['service'],
			),
		);*/
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
