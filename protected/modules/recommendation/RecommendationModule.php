<?php

// use camelcase for class name with first character in uppsercase
class RecommendationModule extends WebModule
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
			'recommendation.models.*',
			'recommendation.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('recommendation.assets'));
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

		return $actions;
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
					array(
						'label' => Yii::t('app', 'Recommendation'),
						'url' => '/recommendation',
						'active' => $controller->activeMenuCpanel == 'recommendation' ? true : false,
						'visible' => true,
						'icon' => 'fa-cog'
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
		//$migration = new Migration();
		if ($forceReset) {
			if (Yii::app()->db->schema->getTable('boilerplate_start', true)) {
				$migration->dropTable('boilerplate_start');
			}
		}

		$migration->createTable('boilerplate_start', array(
			'id' => 'pk',
			'organization_title' => 'string NOT NULL',
			'var1' => 'integer NOT NULL',
			'json_extra' => 'text NULL',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$migration->alterColumn('boilerplate_start', 'organization_title', 'varchar(255) NULL');

		$migration->createIndex('boilerplate_start', 'boilerplate_start', array('organization_title', 'var1'), true);

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['recommendation'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'recommendation' => array(
				'tabLabel' => Yii::t('backend', 'Boilerplate'),
				'itemViewPath' => 'application.modules.recommendation.views.backend._view-recommendation-advanceSearch',
				'result' => $result['recommendation'],
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
