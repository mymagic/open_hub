<?php

// use camelcase for class name with first character in uppsercase
class SampleModule extends WebModule
{
	public $defaultController = 'frontend';
	private $_assetsUrl;

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
			'sample.models.*',
			'sample.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('sample.assets'));
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

			/*$actions['sample'][] = array(
				'visual' => 'primary',
				'label' => 'Backend Action 1',
				'title' => 'Backend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/sample/backend/action1', array('id' => $model->id)),
			);*/
		} elseif ($realm == 'cpanel') {
			/*$actions['sample'][] = array(
				'visual' => 'primary',
				'label' => 'Frontend Action 1',
				'title' => 'Frontend Action 1 short description',
				'url' => Yii::app()->controller->createUrl('/sample/frontend/action1', array('id' => $model->id)),
			);*/
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
			case 'backendNavDev':

				return array(
					array(
						'label' => Yii::t('backend', 'Sample'), 'url' => '#',
						'visible' => Yii::app()->user->getState('accessBackend') == true,
						'active' => $controller->activeMenuMain == 'sample' ? true : false,
						'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => array(
							array('label' => Yii::t('app', 'Sample'), 'url' => array('/sample/sample/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true),
							array('label' => Yii::t('app', 'Sample Group'), 'url' => array('/sample/sampleGroup/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true),
							array('label' => Yii::t('app', 'Sample Zone'), 'url' => array('/sample/sampleZone/admin'), 'visible' => Yii::app()->user->getState('accessBackend') == true),
						),
					),
				);

				break;
		}
	}

	public function install($forceReset = false)
	{
		// create db
		return self::installDb($forceReset)
		// create required setting
		&& Setting::setSetting('sample-var1', 'Hello World', 'string');
		// create folder in upload
	}

	public function installDb($forceReset = false)
	{
		$migration = Yii::app()->db->createCommand();
		//$migration = new Migration();
		if ($forceReset) {
			self::uninstallDb();
		}

		//
		// sample_zone
		// create structure
		$migration->createTable('sample_zone', array(
			'id' => 'pk',
			'code' => 'string NOT NULL',
			'label' => 'string NOT NULL',
			'date_added' => 'integer NOT NULL',
			'date_modified' => 'integer NOT NULL',
		));
		$migration->alterColumn('sample_zone', 'code', 'varchar(32) NOT NULL');
		$migration->alterColumn('sample_zone', 'label', 'varchar(128) NOT NULL');
		$migration->createIndex('sample_zone', 'sample_zone', 'code', true);

		// setup meta
		// preload data

		//
		// sample_group
		// create structure
		$migration->createTable('sample_group', array(
			'id' => 'pk',
			'title_en' => 'string NOT NULL',
			'title_ms' => 'string NOT NULL',
			'title_zh' => 'string NOT NULL',
			'date_added' => 'integer NOT NULL',
			'date_modified' => 'integer NOT NULL',
		));
		$migration->alterColumn('sample_group', 'title_en', 'varchar(128) NOT NULL');
		$migration->alterColumn('sample_group', 'title_ms', 'varchar(128) NOT NULL');
		$migration->alterColumn('sample_group', 'title_zh', 'varchar(128) NOT NULL');

		// setup meta
		// preload data

		//
		// sample
		// create structure
		$migration->createTable('sample', array(
			'id' => 'pk',
			'code' => 'string NOT NULL',
			'sample_group_id' => 'integer NULL',
			'sample_zone_code' => 'string NULL',
			'title_en' => 'string NOT NULL',
			'title_ms' => 'string NOT NULL',
			'title_zh' => 'string NOT NULL',
			'text_short_description_en' => 'string NOT NULL',
			'text_short_description_ms' => 'string NOT NULL',
			'text_short_description_zh' => 'string NOT NULL',
			'html_content_en' => 'longtext NULL',
			'html_content_ms' => 'longtext NULL',
			'html_content_zh' => 'longtext NULL',
			'image_main' => 'string NULL',
			'file_backup' => 'string NULL',
			'price_main' => 'decimal(10,0) NULL DEFAULT 0',
			'gender' => 'string NULL',
			'age' => 'integer NULL',
			'csv_keyword' => 'mediumtext NULL',
			'ordering' => 'double NOT NULL DEFAULT 1',
			'date_posted' => 'integer NOT NULL',
			'is_active' => 'boolean NOT NULL DEFAULT 1',
			'is_public' => 'boolean NOT NULL DEFAULT 1',
			'is_member' => 'boolean NOT NULL DEFAULT 1',
			'is_admin' => 'boolean NOT NULL DEFAULT 1',
			'date_added' => 'integer NOT NULL',
			'date_modified' => 'integer NOT NULL',
		));
		$migration->alterColumn('sample', 'code', 'varchar(32) NOT NULL');
		$migration->alterColumn('sample', 'sample_zone_code', 'varchar(32) NULL');
		$migration->alterColumn('sample', 'title_en', 'varchar(100) NOT NULL');
		$migration->alterColumn('sample', 'title_ms', 'varchar(100) NOT NULL');
		$migration->alterColumn('sample', 'title_zh', 'varchar(100) NOT NULL');
		$migration->alterColumn('sample', 'text_short_description_en', 'varchar(255) NOT NULL');
		$migration->alterColumn('sample', 'text_short_description_ms', 'varchar(255) NOT NULL');
		$migration->alterColumn('sample', 'text_short_description_zh', 'varchar(255) NOT NULL');
		$migration->alterColumn('sample', 'image_main', 'varchar(255) NULL');
		$migration->alterColumn('sample', 'file_backup', 'varchar(255) NULL');
		$migration->alterColumn('sample', 'gender', "ENUM('male', 'female', 'secret') NULL");
		$migration->alterColumn('sample', 'age', 'smallint(6) NULL');

		$migration->createIndex('code', 'sample', 'code', true);
		$migration->createIndex('sample_group_id', 'sample', 'sample_group_id', false);
		$migration->createIndex('sample_zone_code', 'sample', 'sample_zone_code', false);
		$migration->addForeignKey('fk_sample-sample_group_id', 'sample', 'sample_group_id', 'sample_group', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_sample-sample_zone_code', 'sample', 'sample_zone_code', 'sample_zone', 'code', 'CASCADE', 'CASCADE');

		// setup meta
		MetaStructure::initMeta('organization', 'sample', 'extraColumn1', 'boolean', 'Highlight in Sample', 'Is this organization a lighted sample?', '');
		// preload data

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['boilerplateStart'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'intake' => array(
				'tabLabel' => Yii::t('backend', 'Sample'),
				'itemViewPath' => 'application.modules.boilerplateStart.views.backend._view-boilerplateStart-advanceSearch',
				'result' => $result['boilerplateStart'],
			),
		);*/
	}

	public function uninstall()
	{
		return self::uninstallDb()
		&& Setting::deleteSetting('sample-var1');
	}

	public function uninstallDb()
	{
		$migration = Yii::app()->db->createCommand();

		if (Yii::app()->db->schema->getTable('sample', true)) {
			$migration->dropTable('sample');
		}
		if (Yii::app()->db->schema->getTable('sample_group', true)) {
			$migration->dropTable('sample_group');
		}
		if (Yii::app()->db->schema->getTable('sample_zone', true)) {
			$migration->dropTable('sample_zone');
		}

		return true;
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
