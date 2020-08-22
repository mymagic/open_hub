<?php

// use camelcase for class name with first character in uppsercase
class InterestModule extends WebModule
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
			'interest.models.*',
			'interest.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('interest.assets'));
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

	public function getIndividualActFeed($organization, $year)
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
			case 'backendNavService': {
					/*return array(
						array(
							'label' => Yii::t('interest', 'Interest'), 'url' => '#',
							'visible' => Yii::app()->user->getState('accessBackend') == true,
							'active' => $controller->activeMenuMain == 'interest' ? true : false,
							'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
							'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
							'items' => array(
								array('label' => Yii::t('interest', 'Manage All'), 'url' => array('/interest/interest/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true),
								array('label' => Yii::t('interest', 'Create'), 'url' => array('/interest/interest/create'), 'visible' => Yii::app()->user->getState('accessBackend') == true),
							),
						),
					);*/
					break;
				}
			case 'cpanelNavDashboard': {
			break;
				}
			case 'cpanelNavSetting': {
					return array(
						array(
							'label' => Yii::t('app', 'Interest'),
							'url' => '/interest/interest/setting',
							'active' => $controller->activeMenuCpanel == 'interest' ? true : false,
							'visible' => true,
							'icon' => 'fa-heart'
						)
					);
					break;
				}
			case 'cpanelNavOrganization': {
			break;
				}
			case 'cpanelNavOrganizationInformation': {
			break;
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
			if (Yii::app()->db->schema->getTable('interest', true)) {
				$migration->dropTable('interest');
			}
			if (Yii::app()->db->schema->getTable('interest_user2industry', true)) {
				$migration->dropTable('interest_user2industry');
			}
			if (Yii::app()->db->schema->getTable('interest_user2sdg', true)) {
				$migration->dropTable('interest_user2sdg');
			}
			if (Yii::app()->db->schema->getTable('interest_user2cluster', true)) {
				$migration->dropTable('interest_user2cluster');
			}
			if (Yii::app()->db->schema->getTable('interest_user2startup_stage', true)) {
				$migration->dropTable('interest_user2startup_stage');
			}
		}

		$migration->createTable('interest', array(
			'id' => 'pk',
			'user_id' => 'integer NOT NULL',
			'json_extra' => 'text NULL',
			'is_active' => 'boolean NOT NULL DEFAULT 1',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$migration->alterColumn('interest', 'json_extra', 'longtext NULL');
		$migration->createIndex('is_active', 'interest', 'is_active', false);
		$migration->createIndex('user_id', 'interest', 'user_id', true);
		$migration->addForeignKey('fk_interest-user_id', 'interest', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

		$migration->createTable('interest_user2industry', array(
			'industry_id' => 'integer',
			'interest_id' => 'integer',
		));

		$migration->createIndex('interest_user2industry', 'interest_user2industry', array('interest_id', 'industry_id'), true);
		$migration->addForeignKey('fk_interest_user2industry-interest_id', 'interest_user2industry', 'interest_id', 'interest', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_interest_user2industry-industry_id', 'interest_user2industry', 'industry_id', 'industry', 'id', 'CASCADE', 'CASCADE');

		$migration->createTable('interest_user2sdg', array(
			'sdg_id' => 'integer',
			'interest_id' => 'integer',
		));

		$migration->createIndex('interest_user2sdg', 'interest_user2sdg', array('interest_id', 'sdg_id'), true);
		$migration->addForeignKey('fk_interest_user2sdg-interest_id', 'interest_user2sdg', 'interest_id', 'interest', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_interest_user2sdg-sdg_id', 'interest_user2sdg', 'sdg_id', 'sdg', 'id', 'CASCADE', 'CASCADE');

		$migration->createTable('interest_user2cluster', array(
			'cluster_id' => 'integer',
			'interest_id' => 'integer',
		));

		$migration->createIndex('interest_user2cluster', 'interest_user2cluster', array('interest_id', 'cluster_id'), true);
		$migration->addForeignKey('fk_interest_user2cluster-interest_id', 'interest_user2cluster', 'interest_id', 'interest', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_interest_user2cluster-cluster_id', 'interest_user2cluster', 'cluster_id', 'cluster', 'id', 'CASCADE', 'CASCADE');

		$migration->createTable('interest_user2startup_stage', array(
			'startup_stage_id' => 'integer',
			'interest_id' => 'integer',
		));

		$migration->createIndex('interest_user2startup_stage', 'interest_user2startup_stage', array('interest_id', 'startup_stage_id'), true);
		$migration->addForeignKey('fk_interest_user2startup_stage-interest_id', 'interest_user2startup_stage', 'interest_id', 'interest', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_interest_user2startup_stage-cluster_id', 'interest_user2startup_stage', 'startup_stage_id', 'startup_stage', 'id', 'CASCADE', 'CASCADE');

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['interest'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'intake' => array(
				'tabLabel' => Yii::t('backend', 'Boilerplate'),
				'itemViewPath' => 'application.modules.interest.views.backend._view-interest-advanceSearch',
				'result' => $result['interest'],
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
