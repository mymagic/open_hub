<?php

// use camelcase for class name with first character in uppsercase
class BoilerplateStartModule extends WebModule
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
			'boilerplateStart.models.*',
			'boilerplateStart.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('boilerplateStart.assets'));
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

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/frontend/action1', array('id' => $model->id)),
			);
		}

		return $actions;
	}

	public function getOrganizationActFeed($organization, $year)
	{
		return null;
	}

	//
	// organizationFunding
	public function getOrganizationFundingViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core event feature
	public function getOrganizationFundingActions($model, $realm = 'backend')
	{
		$actions = array();

		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} */

		return $actions;
	}

	//
	// organizationRevenue
	public function getOrganizationRevenueViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core event feature
	public function getOrganizationRevenueActions($model, $realm = 'backend')
	{
		$actions = array();

		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} */

		return $actions;
	}

	//
	// organizationStatus
	public function getOrganizationStatusViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core event feature
	public function getOrganizationStatusActions($model, $realm = 'backend')
	{
		$actions = array();

		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} */

		return $actions;
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
	// event
	public function getEventViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core event feature
	public function getEventActions($model, $realm = 'backend')
	{
		$actions = array();

		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} */

		return $actions;
	}

	//
	// event
	public function getEventGroupViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core event feature
	public function getEventGroupActions($model, $realm = 'backend')
	{
		$actions = array();

		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} */

		return $actions;
	}

	//
	// eventRegistration
	public function getEventRegistrationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core event registration feature
	public function getEventRegistrationActions($model, $realm = 'backend')
	{
		$actions = array();

		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} */

		return $actions;
	}

	//
	// member
	public function getMemberViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core member feature
	public function getMemberActions($model, $realm = 'backend')
	{
		$actions = array();
		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/frontend/action1', array('id' => $model->user_id)),
			);
		}*/

		return $actions;
	}

	//
	// admin
	public function getAdminViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}
		}

		return $tabs;
	}

	// these are the functions called by core member feature
	public function getAdminActions($model, $realm = 'backend')
	{
		$actions = array();
		/*if ($realm == 'backend') {
			if (!Yii::app()->user->accessBackend) {
				return;
			}

			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/backend/action1', array('id' => $model->user_id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['boilerplateStart'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/boilerplateStart/frontend/action1', array('id' => $model->user_id)),
			);
		}*/

		return $actions;
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
						// 	'url' => '/boilerplateStart/boilerplateStart',
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

	public function enable()
	{
		return array('status' => 'success', 'msg' => 'Not Implemented', 'data' => array());
	}

	public function disable()
	{
		return array('status' => 'success', 'msg' => 'Not Implemented', 'data' => array());
	}

	public function install($forceReset = false)
	{
		return self::installDb($forceReset);
	}

	public function installDb($forceReset = false)
	{
		$migration = Yii::app()->db->createCommand();
		$migration = new Migration();

		// comment off code block below to initialize database structure for this module
		/*if ($forceReset) {
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

		$migration->createIndex('boilerplate_start', 'boilerplate_start', array('organization_title', 'var1'), true);*/

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['boilerplateStart'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'boilerplateStart' => array(
				'tabLabel' => Yii::t('backend', 'Boilerplate'),
				'itemViewPath' => 'application.modules.boilerplateStart.views.backend._view-boilerplateStart-advanceSearch',
				'result' => $result['boilerplateStart'],
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
