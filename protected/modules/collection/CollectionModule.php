<?php

// use camelcase for class name with first character in uppsercase
class CollectionModule extends WebModule
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
			'collection.models.*',
			'collection.components.*',
		));
	}

	// this allow assets like javascript and css be place in module
	// please take note that these asset files will not be automatically included by the system, you will need to explicitly include them
	public function getAssetsUrl()
	{
		if (null === $this->_assetsUrl) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('collection.assets'));
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
		switch ($forInterface) {
			case 'backendNavService':
				return null;
			case 'backendNavUserService':
				return array(
					array('label' => Yii::t('app', 'My Collection'), 'url' => array('/collection/me'), 'visible' => Yii::app()->user->getState('accessBackend') == true, 'items'),
				);
		}
	}

	public function getSharedAssets($forInterface = '*')
	{
		switch ($forInterface) {
			case 'layout-backend':
			{
				$return['css'][] = array('src' => self::getAssetsUrl() . '/css/backend.shared.css');
				$return['js'][] = array('src' => self::getAssetsUrl() . '/javascript/backend.shared.js', 'position' => CClientScript::POS_END);
				break;
			}
			default:
			{
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
			if (Yii::app()->db->schema->getTable('collection_item', true)) {
				$migration->dropTable('collection_item');
			}
			if (Yii::app()->db->schema->getTable('collection_sub', true)) {
				$migration->dropTable('collection_sub');
			}
			if (Yii::app()->db->schema->getTable('tag2collection', true)) {
				$migration->dropTable('tag2collection');
			}
			if (Yii::app()->db->schema->getTable('collection', true)) {
				$migration->dropTable('collection');
			}
		}

		$migration->createTable('collection', array(
			'id' => 'pk',
			'creator_user_id' => 'integer NOT NULL',
			'title' => 'string NOT NULL',
			'json_extra' => 'text NULL',
			'is_active' => 'boolean NOT NULL DEFAULT 1',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$migration->alterColumn('collection', 'title', 'varchar(100) NULL');
		$migration->createIndex('is_active', 'collection', 'is_active', false);
		$migration->addForeignKey('fk_collection-creator_user_id', 'collection', 'creator_user_id', 'user', 'id', 'CASCADE', 'CASCADE');

		//
		// collection_sub
		$migration->createTable('collection_sub', array(
			'id' => 'pk',
			'collection_id' => 'integer NOT NULL',
			'title' => 'string NOT NULL',
			'json_extra' => 'text NULL',
			'ordering' => 'float',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$migration->alterColumn('collection_sub', 'title', 'varchar(100) NULL');
		$migration->addForeignKey('fk_collection-collection_id', 'collection_sub', 'collection_id', 'collection', 'id', 'CASCADE', 'CASCADE');

		//
		// collection_item
		$migration->createTable('collection_item', array(
			'id' => 'pk',
			'collection_sub_id' => 'integer NOT NULL',
			'ref_id' => 'integer NOT NULL',
			'table_name' => 'string NOT NULL',
			'json_extra' => 'text NULL',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$migration->createIndex('ref_id', 'collection_item', 'ref_id', false);
		$migration->addForeignKey('fk_collection_item-collection_sub_id', 'collection_item', 'collection_sub_id', 'collection_sub', 'id', 'CASCADE', 'CASCADE');

		//
		// tag2collection
		$migration->createTable('tag2collection', array(
			'tag_id' => 'integer',
			'collection_id' => 'integer',
		));
		$migration->createIndex('tag2collection', 'tag2collection', array('tag_id', 'collection_id'), true);
		$migration->addForeignKey('fk_tag2collection_tag', 'tag2collection', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
		$migration->addForeignKey('fk_tag2collection_collection', 'tag2collection', 'collection_id', 'collection', 'id', 'CASCADE', 'CASCADE');

		return true;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		/*$searchModel = new BoilerplateModel('search');
		$result['collection'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'intake' => array(
				'tabLabel' => Yii::t('backend', 'Boilerplate'),
				'itemViewPath' => 'application.modules.collection.views.backend._view-collection-advanceSearch',
				'result' => $result['collection'],
			),
		);*/
	}

	public function doOrganizationsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		// process collection
		$sql = sprintf("UPDATE collection_item SET ref_id='%s' WHERE table_name='organization' AND ref_id='%s'", $target->id, $source->id);
		Yii::app()->db->createCommand($sql)->execute();

		$transaction->commit();

		return array($source, $target);
	}

	public function doIndividualsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();
		// todo
		$transaction->commit();

		return array($source, $target);
	}
}
