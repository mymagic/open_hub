<?php

// use camelcase for class name with first character in uppsercase
class CvModule extends WebModule
{
	public $defaultController = 'frontend';
	private $_assetsUrl;
	public $oauthSecret;
	public $organizationId;
	public $var1;
	public $var2;
	public $isFrontendEnabled = true;
	public $isCpanelEnabled = true;

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
			'cv.models.*',
			'cv.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('cv.assets'));
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->id)),
			);
		} elseif ($realm == 'cpanel') {
			if (Yii::app()->getModule('cv')->isCpanelEnabled) {
				$actions['cv'][] = array(
					'visual' => 'primary',
					'label' => 'Frontend Action 1',
					'title' => 'Frontend Action 1 short description',
					'url' => Yii::app()->controller->createUrl('/cv/frontend/action1', array('id' => $model->id)),
				);
			}
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/frontend/action1', array('id' => $model->user_id)),
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

			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/backend/action1', array('id' => $model->user_id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['cv'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/cv/frontend/action1', array('id' => $model->user_id)),
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
					array(
						'label' => Yii::t('app', 'My Portfolio'),
						'url' => '/cv/cpanel',
						'active' => $controller->activeMenuCpanel == 'cv' ? true : false,
						'visible' => Yii::app()->getModule('cv')->isCpanelEnabled,
						'icon' => 'fa-file-powerpoint-o'
					)
				);
				break;
			}
			case 'cpanelNavCV': {
				return array(
					//example
					array(
						'label' => Yii::t('app', 'My Portfolio'),
						'url' => '/cv/cpanel/portfolio',
						'active' => $controller->activeMenuCpanel == 'portfolio' ? true : false,
						'visible' => Yii::app()->getModule('cv')->isCpanelEnabled,
						'icon' => 'fa-file-powerpoint-o'
					),
					array(
						'label' => Yii::t('app', 'My Experiences'),
						'url' => '/cv/cpanel/experience',
						'active' => $controller->activeMenuCpanel == 'experience' ? true : false,
						'visible' => Yii::app()->getModule('cv')->isCpanelEnabled,
						'icon' => 'fa-caret-right'
					),
				);
				break;
			}
			case 'backendNavService': {
				return array(
					array(
						'label' => Yii::t('cv', 'CV'), 'url' => '#',
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'index'], 'module' => (object)['id' => 'cv']]),
						'active' => $controller->activeMenuMain == 'cv' ? true : false,
						'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => array(
							array(
								'label' => Yii::t('cv', 'Portfolio'), 'url' => array('//cv/portfolio/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true),
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'portfolio', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'cv']])
							),
							array(
								'label' => Yii::t('cv', 'Job Position'), 'url' => array('//cv/jobpos/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true),
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'jobpos', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'cv']])
							),
							array(
								'label' => Yii::t('cv', 'Job Position Group'), 'url' => array('//cv/jobposGroup/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true),
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'jobposGroup', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'cv']])
							),
						),
					),
				);

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
		$migration = new Migration();

		// comment off code block below to initialize database structure for this module
		if ($forceReset) {
			$migration->dropForeignKey('fk_cv_portfolio-high_academy_experience_id', 'cv_portfolio');

			if (Yii::app()->db->schema->getTable('cv_experience', true)) {
				$migration->dropTable('cv_experience');
			}
			if (Yii::app()->db->schema->getTable('cv_portfolio', true)) {
				$migration->dropTable('cv_portfolio');
			}
			if (Yii::app()->db->schema->getTable('cv_jobpos', true)) {
				$migration->dropTable('cv_jobpos');
			}
			if (Yii::app()->db->schema->getTable('cv_jobpos_group', true)) {
				$migration->dropTable('cv_jobpos_group');
			}
		}

		//
		$migration->createTable('cv_jobpos_group', array(
				'id' => 'pk',
				'title' => 'string NOT NULL',
				'ordering' => 'double NOT NULL DEFAULT 0',
				'is_active' => 'boolean NOT NULL DEFAULT 1',
				'json_extra' => 'text NULL',
				'date_added' => 'integer',
				'date_modified' => 'integer',
			));
		$migration->alterColumn('cv_jobpos_group', 'json_extra', 'LONGTEXT NULL');

		//
		$migration->createTable('cv_jobpos', array(
				'id' => 'pk',
				'cv_jobpos_group_id' => 'integer NOT NULL',
				'title' => 'string NOT NULL',
				'is_active' => 'boolean NOT NULL DEFAULT 1',
				'json_extra' => 'text NULL',
				'date_added' => 'integer',
				'date_modified' => 'integer',
			));
		$migration->alterColumn('cv_jobpos', 'json_extra', 'LONGTEXT NULL');
		$migration->createIndex('cv_jobpos_group_id', 'cv_jobpos', 'cv_jobpos_group_id', false);
		$migration->addForeignKey('fk_cv_jobpos-cv_jobpos_group_id', 'cv_jobpos', 'cv_jobpos_group_id', 'cv_jobpos_group', 'id', 'CASCADE', 'CASCADE');

		//
		$migration->createTable('cv_portfolio', array(
				'id' => 'pk',
				'user_id' => 'integer NOT NULL',
				'slug' => 'string NULL',
				'jobpos_id' => 'integer NULL',
				'organization_name' => 'string NULL', // map to 'at' in legacy field
				'location' => 'string NULL',
				// 'city_id' => 'integer NULL',
				'text_address_residential' => 'text NULL', // new field
				'latlong_address_residential' => 'point NULL', // new field
				'state_code' => 'string NULL',
				'country_code' => 'string NULL',
				'display_name' => 'string NOT NULL',
				'image_avatar' => 'string NULL',
				'high_academy_experience_id' => 'integer NULL',
				'text_oneliner' => 'string NULL',
				'text_short_description' => 'text NULL',
				'is_looking_fulltime' => 'boolean NOT NULL DEFAULT 0',
				'is_looking_contract' => 'boolean NOT NULL DEFAULT 0',
				'is_looking_freelance' => 'boolean NOT NULL DEFAULT 0',
				'is_looking_cofounder' => 'boolean NOT NULL DEFAULT 0',
				'is_looking_internship' => 'boolean NOT NULL DEFAULT 0',
				'is_looking_apprenticeship' => 'boolean NOT NULL DEFAULT 0',
				'visibility' => 'string NULL',
				'is_active' => 'boolean NOT NULL DEFAULT 1',
				'json_social' => 'text NULL',
				'json_extra' => 'text NULL',
				'date_added' => 'integer',
				'date_modified' => 'integer',
			));

		$migration->alterColumn('cv_portfolio', 'slug', 'varchar(100) NULL');
		$migration->alterColumn('cv_portfolio', 'text_oneliner', 'varchar(200) NULL');
		$migration->alterColumn('cv_portfolio', 'image_avatar', 'varchar(255) NULL');
		$migration->alterColumn('cv_portfolio', 'country_code', 'varchar(2) NULL');
		$migration->alterColumn('cv_portfolio', 'state_code', 'varchar(12) NULL');
		$migration->alterColumn('cv_portfolio', 'json_social', 'LONGTEXT NULL');
		$migration->alterColumn('cv_portfolio', 'json_extra', 'LONGTEXT NULL');
		$migration->alterColumn('cv_portfolio', 'visibility', "ENUM('public', 'protected', 'private') DEFAULT 'public'");

		$migration->createIndex('user_id', 'cv_portfolio', 'user_id', false);
		$migration->createIndex('jobpos_id', 'cv_portfolio', 'jobpos_id', false);
		$migration->createIndex('country_code', 'cv_portfolio', 'country_code', false);
		$migration->createIndex('state_code', 'cv_portfolio', 'state_code', false);
		$migration->createIndex('high_academy_experience_id', 'cv_portfolio', 'high_academy_experience_id', false);
		$migration->createIndex('is_active', 'cv_portfolio', 'is_active', false);

		$migration->addForeignKey('fk_cv_portfolio-user_id', 'cv_portfolio', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_cv_portfolio-jobpos_id', 'cv_portfolio', 'jobpos_id', 'cv_jobpos_group', 'id', 'SET NULL', 'CASCADE');
		$migration->addForeignKey('fk_cv_portfolio-country_code', 'cv_portfolio', 'country_code', 'country', 'code', 'SET NULL', 'CASCADE');
		$migration->addForeignKey('fk_cv_portfolio-state_code', 'cv_portfolio', 'state_code', 'state', 'code', 'SET NULL', 'CASCADE');

		//
		$migration->createTable('cv_experience', array(
				'id' => 'pk',
				'cv_portfolio_id' => 'integer NOT NULL',
				'genre' => 'string NOT NULL',
				'title' => 'string NOT NULL',
				'organization_name' => 'string NULL', // map to 'at' in legacy field
				'location' => 'string NULL',
				'full_address' => 'text NULL', // new field
				'latlong_address' => 'point NULL', // new field
				// 'city_id' => 'integer NULL',
				'state_code' => 'string NULL',
				'country_code' => 'string NULL',
				'text_short_description' => 'text NULL', // map to 'text_short_desc'
				'year_start' => 'integer NOT NULL',
				'month_start' => 'string NOT NULL',
				'year_end' => 'integer NULL',
				'month_end' => 'string NULL',
				'is_active' => 'boolean NOT NULL DEFAULT 1',
				'json_extra' => 'text NULL',
				'date_added' => 'integer',
				'date_modified' => 'integer',
			));
		$migration->alterColumn('cv_experience', 'genre', "ENUM('job', 'study', 'project', 'others') NOT NULL DEFAULT 'others'");
		$migration->alterColumn('cv_experience', 'state_code', 'varchar(12) NULL');
		$migration->alterColumn('cv_experience', 'country_code', 'varchar(2) NULL');

		$migration->alterColumn('cv_experience', 'month_start', "ENUM('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12') NULL");
		$migration->alterColumn('cv_experience', 'month_end', "ENUM('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12') NULL");
		$migration->alterColumn('cv_experience', 'json_extra', 'LONGTEXT NULL');

		$migration->createIndex('cv_portfolio_id', 'cv_experience', 'cv_portfolio_id', false);
		$migration->createIndex('state_code', 'cv_experience', 'state_code', false);
		$migration->createIndex('country_code', 'cv_experience', 'country_code', false);
		$migration->createIndex('year_start', 'cv_experience', 'year_start', false);
		$migration->createIndex('month_start', 'cv_experience', 'month_start', false);
		$migration->createIndex('is_active', 'cv_experience', 'is_active', false);

		$migration->addForeignKey('fk_cv_experience-portfolio_id', 'cv_experience', 'cv_portfolio_id', 'cv_portfolio', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_cv_experience-country_code', 'cv_experience', 'country_code', 'country', 'code', 'SET NULL', 'CASCADE');
		$migration->addForeignKey('fk_cv_experience-state_code', 'cv_experience', 'state_code', 'state', 'code', 'SET NULL', 'CASCADE');

		$migration->addForeignKey('fk_cv_portfolio-high_academy_experience_id', 'cv_portfolio', 'high_academy_experience_id', 'cv_experience', 'id', 'SET NULL', 'CASCADE');

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['cv'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'cv' => array(
				'tabLabel' => Yii::t('backend', 'Boilerplate'),
				'itemViewPath' => 'application.modules.cv.views.backend._view-cv-advanceSearch',
				'result' => $result['cv'],
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
