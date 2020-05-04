<?php

// use camelcase for class name with first character in uppsercase
class ChallengeModule extends WebModule
{
	public $defaultController = 'frontend';
	private $_assetsUrl;

	public $var1;
	public $var2;
	public $isAutoApproveNewPost;
	public $f7TemplateFormSlug = 'challenge-template';

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
			'challenge.models.*',
			'challenge.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('challenge.assets'));
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

			$actions['challenge'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/challenge/backend/action1', array('id' => $model->id)),
			);
		} elseif ($realm == 'cpanel') {
			$actions['challenge'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/challenge/frontend/action1', array('id' => $model->id)),
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
		switch ($forInterface) {
			case 'backendNavService':

				return array(
					array(
						'label' => Yii::t('backend', 'Open Innovation Challenge'), 'url' => '#',
						// 'visible' => Yii::app()->user->getState('accessBackend') == true,
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'index'], 'module' => (object)['id' => 'challenge']]),
						'active' => $controller->activeMenuMain == 'challenge' ? true : false,
						'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => array(
							array(
								'label' => Yii::t('app', 'Challenge Overview'), 'url' => array('/challenge/backend/index'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true),
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'index'], 'module' => (object)['id' => 'challenge']])
							),
						),
					),
				);

				break;
		}
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
			if (Yii::app()->db->schema->getTable('tag2challenge', true)) {
				$migration->dropTable('tag2challenge');
			}
			if (Yii::app()->db->schema->getTable('industry2challenge', true)) {
				$migration->dropTable('industry2challenge');
			}
			if (Yii::app()->db->schema->getTable('challenge', true)) {
				$migration->dropTable('challenge');
			}
		}

		//
		// challenge
		$migration->createTable('challenge', array(
			'id' => 'pk',
			'owner_organization_id' => 'integer NOT NULL',
			'creator_user_id' => 'integer NOT NULL', // user who created this
			'title' => 'string NOT NULL',
			'text_short_description' => 'string NULL',
			'html_content' => 'string NULL',
			'image_cover' => 'string NULL',
			'image_header' => 'string NULL',
			'url_video' => 'string NULL',
			'url_application_form' => 'string NULL', // insert url application form to redirect to any site, eg: google form
			'html_deliverable' => 'text NULL',
			'html_criteria' => 'text NULL',
			'prize_title' => 'string NULL',
			'html_prize_detail' => 'text NULL',
			'date_open' => 'integer',
			'date_close' => 'integer',
			'ordering' => 'float',
			'text_remark' => 'text NULL',
			'json_extra' => 'text NULL',
			'status' => 'string NOT NULL', // workflow
			'timezone' => 'string NULL',
			'is_active' => 'boolean NOT NULL DEFAULT 1',
			'is_publish' => 'boolean NOT NULL DEFAULT 0', // is publish to frontend
			'is_highlight' => 'boolean NOT NULL DEFAULT 0', // is highlighted challenge
			'process_by' => 'string NULL', // last process by which admin username
			'date_submit' => 'integer NULL',
			'date_process' => 'integer NULL',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$migration->alterColumn('challenge', 'title', 'varchar(255) NOT NULL');
		$migration->alterColumn('challenge', 'prize_title', 'varchar(255) NULL');
		$migration->alterColumn('challenge', 'timezone', 'varchar(128) NULL');
		$migration->alterColumn('challenge', 'json_extra', 'longtext NULL');
		$migration->alterColumn('challenge', 'html_content', 'longtext NULL');
		$migration->alterColumn('challenge', 'html_deliverable', 'longtext NULL');
		$migration->alterColumn('challenge', 'html_criteria', 'longtext NULL');
		$migration->alterColumn('challenge', 'html_prize_detail', 'longtext NULL');
		$migration->alterColumn('challenge', 'text_remark', 'longtext NULL');

		// new: challenge is newly created, default status
		// pending: challenge is pending for user submission
		// processing: challenge is process by admin
		// reject: challenge is reject from listed
		// approve: challenge is approve for listed
		// completed: challenge is completed
		$migration->alterColumn('challenge', 'status', "ENUM('new','pending','processing','reject','approved','completed') NOT NULL default 'new'");

		$migration->createIndex('process_by', 'challenge', 'process_by', false);
		$migration->createIndex('creator_user_id', 'challenge', 'creator_user_id', false);
		$migration->createIndex('is_active', 'challenge', 'is_active', false);
		$migration->createIndex('is_publish', 'challenge', 'is_publish', false);
		$migration->createIndex('is_highlight', 'challenge', 'is_highlight', false);

		$migration->addForeignKey('fk_challenge-creator_user_id', 'challenge', 'creator_user_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_challenge-owner_organization_id', 'challenge', 'owner_organization_id', 'organization', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_challenge-process_by', 'challenge', 'process_by', 'user', 'username', 'CASCADE', 'CASCADE');

		//
		// tag2challenge
		$migration->createTable('tag2challenge', array(
			'tag_id' => 'integer',
			'challenge_id' => 'integer',
		));
		$migration->createIndex('tag2challenge', 'tag2challenge', array('tag_id', 'challenge_id'), true);
		$migration->addForeignKey('fk_tag2challenge_tag', 'tag2challenge', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_tag2challenge_challenge', 'tag2challenge', 'challenge_id', 'challenge', 'id', 'CASCADE', 'CASCADE');

		//
		// industry2challenge
		$migration->createTable('industry2challenge', array(
			'industry_id' => 'integer NOT NULL',
			'challenge_id' => 'integer NOT NULL',
		));

		// createIndex(string $name, string $table, string|array $columns, boolean $unique=false)
		$migration->createIndex('industry_id', 'industry2challenge', 'industry_id', false);
		// createIndex(string $name, string $table, string|array $columns, boolean $unique=false)
		$migration->createIndex('challenge_id', 'industry2challenge', 'challenge_id', false);
		// createIndex(string $name, string $table, string|array $columns, boolean $unique=false)
		$migration->createIndex('industry2challenge', 'industry2challenge', array('challenge_id', 'industry_id'), true);

		// addForeignKey(string $name, string $table, string|array $columns, string $refTable, string|array $refColumns, string $delete=NULL, string $update=NULL)
		$migration->addForeignKey('fk_industry2challenge-industry_id', 'industry2challenge', 'industry_id', 'industry', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_industry2challenge-challenge_id', 'industry2challenge', 'challenge_id', 'challenge', 'id', 'CASCADE', 'CASCADE');

		return true;
	}

	public function doOrganizationsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		// process challenge
		$sql = sprintf("UPDATE challenge SET owner_organization_id='%s' WHERE owner_organization_id='%s'", $target->id, $source->id);
		Yii::app()->db->createCommand($sql)->execute();

		$transaction->commit();

		return array($source, $target);
	}
}
