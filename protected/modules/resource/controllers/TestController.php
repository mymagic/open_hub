<?php

class TestController extends Controller
{
	public $layout = 'backend';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // deny all users
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)["id"=>"custom","action"=>(object)["id"=>"developer"]])',
	  ),
	  array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		//if you want to use reflection
		$reflection = new ReflectionClass(TestController);
		$methods = $reflection->getMethods();
		$actions = array();
		foreach ($methods as $method) {
			if (substr($method->name, 0, 6) == 'action' && $method->name != 'actionIndex' && $method->name != 'actions') {
				$methodName4Url = lcfirst(substr($method->name, 6));
				$actions[] = $methodName4Url;
			}
		}

		Yii::t('test', 'Test actions');

		$this->render('index', array('actions' => $actions));
	}

	public function actionDurianscapeFund()
	{
		$sql = "SELECT DISTINCT(o.title) as title, o.image_logo as image_logo FROM resource as r
        LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id
        LEFT JOIN organization as o ON o.id=r2o.organization_id
        LEFT JOIN resource2resource_geofocus as r2g ON r2g.resource_id=r.id
        LEFT JOIN resource_geofocus as g ON g.id=r2g.resource_geofocus_id
        WHERE r.typefor='fund'";

		$records = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($records as $record) {
			if ($record['image_logo'] == 'uploads/organization/logo.default.jpg' || empty($record['image_logo'])) {
				continue;
			}

			echo sprintf('<img src="%s" alt="" width="100px" />', StorageHelper::getUrl($record['image_logo']), $record['title']);
		}
	}

	public function actionDurianscapeAward()
	{
		$sql = "SELECT r.title as title, r.image_logo as image_logo FROM resource as r
        LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id
        LEFT JOIN organization as o ON o.id=r2o.organization_id
        LEFT JOIN resource2resource_geofocus as r2g ON r2g.resource_id=r.id
        LEFT JOIN resource_geofocus as g ON g.id=r2g.resource_geofocus_id
        WHERE r.typefor='award' GROUP BY o.id";

		$records = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($records as $record) {
			if ($record['image_logo'] == 'uploads/organization/logo.default.jpg' || empty($record['image_logo'])) {
				continue;
			}

			echo sprintf('<img src="%s" alt="" width="100px" />', StorageHelper::getUrl($record['image_logo']), $record['title']);
		}
	}

	public function actionDurianscapeMedia()
	{
		$sql = "SELECT r.title as title, r.image_logo as image_logo FROM resource as r
        LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id
        LEFT JOIN organization as o ON o.id=r2o.organization_id
        LEFT JOIN resource2resource_geofocus as r2g ON r2g.resource_id=r.id
        LEFT JOIN resource_geofocus as g ON g.id=r2g.resource_geofocus_id
        WHERE r.typefor='media' GROUP BY o.id";

		$records = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($records as $record) {
			if ($record['image_logo'] == 'uploads/organization/logo.default.jpg' || empty($record['image_logo'])) {
				continue;
			}

			echo sprintf('<img src="%s" alt="" width="100px" />', StorageHelper::getUrl($record['image_logo']), $record['title']);
		}
	}

	public function actionDurianscapeLegislation()
	{
		$sql = "SELECT r.title as title, r.image_logo as image_logo FROM resource as r
        LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id
        LEFT JOIN organization as o ON o.id=r2o.organization_id
        LEFT JOIN resource2resource_geofocus as r2g ON r2g.resource_id=r.id
        LEFT JOIN resource_geofocus as g ON g.id=r2g.resource_geofocus_id
        WHERE r.typefor='legislation' GROUP BY o.id";

		$records = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($records as $record) {
			if ($record['image_logo'] == 'uploads/organization/logo.default.jpg' || empty($record['image_logo'])) {
				continue;
			}

			echo sprintf('<img src="%s" alt="" width="100px" />', StorageHelper::getUrl($record['image_logo']), $record['title']);
		}
	}

	public function actionDurianscapeSpace()
	{
		$sql = "SELECT r.title as title, r.image_logo as image_logo FROM resource as r
        LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id
        LEFT JOIN organization as o ON o.id=r2o.organization_id
        LEFT JOIN resource2resource_geofocus as r2g ON r2g.resource_id=r.id
        LEFT JOIN resource_geofocus as g ON g.id=r2g.resource_geofocus_id
        WHERE r.typefor='space' GROUP BY o.id";

		$records = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($records as $record) {
			if ($record['image_logo'] == 'uploads/organization/logo.default.jpg' || empty($record['image_logo'])) {
				continue;
			}

			echo sprintf('<img src="%s" alt="" width="100px" />', StorageHelper::getUrl($record['image_logo']), $record['title']);
		}
	}

	public function actionDurianscapeProgram()
	{
		$sql = "SELECT r.title as title, r.image_logo as image_logo FROM resource as r
        LEFT JOIN resource2organization as r2o ON r2o.resource_id=r.id
        LEFT JOIN organization as o ON o.id=r2o.organization_id
        LEFT JOIN resource2resource_geofocus as r2g ON r2g.resource_id=r.id
        LEFT JOIN resource_geofocus as g ON g.id=r2g.resource_geofocus_id
        WHERE r.typefor='program' GROUP BY o.id";

		$records = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($records as $record) {
			if ($record['image_logo'] == 'uploads/organization/logo.default.jpg' || empty($record['image_logo'])) {
				continue;
			}

			echo sprintf('<img src="%s" alt="" width="100px" />', StorageHelper::getUrl($record['image_logo']), $record['title']);
		}
	}
}
