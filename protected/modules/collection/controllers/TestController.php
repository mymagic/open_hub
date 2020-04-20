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

	public function actionAddCollection()
	{
		$saved = false;
		$userId = Yii::app()->user->id;

		$transaction = Yii::app()->db->beginTransaction();
		try {
			$collection = new Collection();
			$collection->creator_user_id = $userId;
			$collection->title = sprintf('Test Collection %s', time());
			$collection->save();

			$collectionSub = new CollectionSub();
			$collectionSub->collection_id = $collection->id;
			$collectionSub->title = 'First Sub';
			$collectionSub->save();

			$collectionItem = new CollectionItem();
			$collectionItem->collection_sub_id = $collectionSub->id;
			$collectionItem->table_name = 'organization';
			$collectionItem->ref_id = 1;
			$collectionItem->save();

			$transaction->commit();
			$saved = true;
		} catch (Exception $e) {
			$exceptionMessage = $e->getMessage();
			$saved = false;
			$transaction->rollBack();

			echo $exceptionMessage;
			exit;
		}

		echo '<pre>';
		print_r($collectionItem);
		print_r($collectionItem->collectionSub);
		print_r($collectionItem->collectionSub->collection);
	}

	public function actionHubAddCollectionItem($username, $tableName, $itemId, $collectionKey, $collectionSubKey)
	{
		$user = HUB::getUserByUsername($username);

		try {
			$collectionItem = HubCollection::addCollectionItem($user, $tableName, $itemId, $collectionKey, $collectionSubKey);
			echo '<pre>';
			echo sprintf("collection '%s #%s' added in %s\%s", $collectionItem->table_name, $collectionItem->ref_id, $collectionItem->collectionSub->collection->title, $collectionItem->collectionSub->title);
			//print_r($collectionItem);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionHubGetCollectionByUser($username)
	{
		$user = HUB::getUserByUsername($username);
		$collections = HubCollection::getActiveUserCollections($user);
		echo sprintf('<p>%s</p>', $username);

		foreach ($collections as $collection) {
			echo sprintf('<h2>#%s - %s</h2>', $collection->id, $collection->title);
			foreach ($collection->collectionSubs as $collectionSub) {
				echo '<div style="padding-left:2em">';
				echo sprintf('<h3>#%s - %s</h3>', $collectionSub->id, $collectionSub->title);
				foreach ($collectionSub->collectionItems as $collectionItem) {
					echo sprintf('<li>#%s (#%s, %s) - %s</li>', $collectionItem->id, $collectionItem->ref_id, $collectionItem->table_name, HubCollection::renderCollectionItem($this, $collectionItem));
				}
				echo '</div>';
			}
		}
	}

	public function actionHubDeleteCollection($username, $id)
	{
		$user = HUB::getUserByUsername($username);
		try {
			$result = HubCollection::deleteCollection($user, $id);
			echo '<pre>';
			print_r($result);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionHubRenameCollection($username, $id, $newTitle)
	{
		$user = HUB::getUserByUsername($username);
		try {
			$result = HubCollection::renameCollection($user, $id, $newTitle);
			echo '<pre>';
			print_r($result);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionHubMoveCollectionSub($username, $collectionSubId, $targetCollectionId)
	{
		$user = HUB::getUserByUsername($username);
		try {
			$collectionSub = HubCollection::moveCollectionSub($user, $collectionSubId, $targetCollectionId);
			echo '<pre>';
			print_r($collectionSub);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionHubRenameCollectionSub($username, $id, $newTitle)
	{
		$user = HUB::getUserByUsername($username);
		try {
			$result = HubCollection::renameCollectionSub($user, $id, $newTitle);
			echo '<pre>';
			print_r($result);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionHubDeleteCollectionSub($username, $id)
	{
		$user = HUB::getUserByUsername($username);
		try {
			$result = HubCollection::deleteCollectionSub($user, $id);
			echo '<pre>';
			print_r($result);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionHubDeleteCollectionItem($username, $id)
	{
		$user = HUB::getUserByUsername($username);
		try {
			$result = HubCollection::deleteCollectionItem($user, $id);
			echo '<pre>';
			print_r($result);
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionTestZone()
	{
		$model['organizations'] = Organization::model()->findAll(array('condition' => 'is_active=1', 'limit' => 10));
		$model['resources'] = Resource::model()->findAll(array('condition' => 'is_active=1', 'limit' => 10));
		$model['events'] = Event::model()->findAll(array('condition' => 'is_active=1', 'limit' => 10));
		$this->render('testzone', array('model' => $model));
	}
}
