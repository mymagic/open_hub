<?php

class HubCollection
{
	public function countAllOrganizationCollections($organization)
	{
		//return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
		return 0;
	}

	public function getActiveOrganizationCollections($organization, $limit = 100)
	{
		/*return Comment::model()->findAll(array(
			'condition' => 'object_key=:objectKey AND is_active=1',
			'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
			'limit' => $limit,
			'order' => 'id DESC'
		));*/
		return array();
	}

	public function countAllUserCollections($user)
	{
		return Collection::model()->countByAttributes(array(
			'creator_user_id' => $user->id,
		));
	}

	public function getActiveUserCollections($user, $limit = 100)
	{
		return Collection::model()->findAll(array(
			'condition' => 'creator_user_id=:userId AND is_active=1',
			'params' => array(':userId' => $user->id),
			'limit' => $limit,
			'order' => 'title ASC',
		));
	}

	public function getCollectionById($id)
	{
		$model = Collection::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested collection does not exist.');
		}

		return $model;
	}

	public function getCollectionByTitle($user, $title)
	{
		return Collection::title2Obj($user, $title);
	}

	public function getCollectionSubById($id)
	{
		$model = CollectionSub::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested sub collection grouping does not exist.');
		}

		return $model;
	}

	public function getCollectionSubByTitle($collection, $title)
	{
		return CollectionSub::title2Obj($collection, $title);
	}

	// user, the user object after validated with session and ensure user can access backend
	// tableName: the table where this item belongs to
	// itemId: the resource id to add as item
	// collection: name or number. if number passed in, existing collection will be use; if string, new collection will be created, even though there's existing with same name; if empty, default will be use
	public function addCollectionItem($user, $tableName, $itemId, $collectionKey = 'Default', $collectionSubKey = 'Default')
	{
		$saved = false;
		$transaction = Yii::app()->db->beginTransaction();
		try {
			//
			// prepare collection object
			// collection = numeric, find the existing one, else:
			if (is_numeric($collectionKey)) {
				$collection = HubCollection::getCollectionById($collectionKey);
			}
			// collection = name, find the collection with exact name match of this user, else:
			else {
				$collection = HubCollection::getCollectionByTitle($user, $collectionKey);
				if (empty($collection)) {
					$collection = new Collection();
					$collection->title = $collectionKey;
					$collection->creator_user_id = $user->id;
					$collection->save();
				}
			}

			//
			// prepare sub collection object
			// sub collection = numeric, find the existing one, else:
			if (is_numeric($collectionSubKey)) {
				$collectionSub = HubCollection::getCollectionSubById($collectionSubKey);
			}
			// sub collection = name, find the collection with exact name match of this user, else:
			else {
				$collectionSub = HubCollection::getCollectionSubByTitle($collection, $collectionSubKey);
				if (empty($collectionSub)) {
					$collectionSub = new CollectionSub();
					$collectionSub->title = $collectionSubKey;
					$collectionSub->collection_id = $collection->id;
					$collectionSub->save();
				}
			}

			//
			// insert record
			// collection do not check duplicate, same resource can be inserted multiple times
			$collectionItem = new CollectionItem();
			$collectionItem->collection_sub_id = $collectionSub->id;
			$collectionItem->ref_id = $itemId;
			$collectionItem->table_name = $tableName;
			$collectionItem->save();

			$transaction->commit();
			$saved = true;
		} catch (Exception $e) {
			$exceptionMessage = $e->getMessage();
			$saved = false;
			$transaction->rollBack();
		}

		// return the record object
		if ($saved) {
			return $collectionItem;
		} else {
			return false;
		}
	}

	public function renderCollectionItem($controller, $item)
	{
		$result = '';
		$refObject = $item->getItemObject();
		$modelClass = get_class($refObject);

		if ($modelClass == 'Organization') {
			$result = $controller->renderPartial('application.modules.collection.views.backend._renderCollectionItem-organization', array('model' => $refObject), true);
		} elseif ($modelClass == 'Individual') {
			$result = $controller->renderPartial('application.modules.collection.views.backend._renderCollectionItem-individual', array('model' => $refObject), true);
		} elseif ($modelClass == 'Event') {
			$result = $controller->renderPartial('application.modules.collection.views.backend._renderCollectionItem-event', array('model' => $refObject), true);
		} elseif ($modelClass == 'Resource') {
			$result = $controller->renderPartial('application.modules.collection.views.backend._renderCollectionItem-resource', array('model' => $refObject), true);
		} elseif ($modelClass == 'Tag') {
			$result = $controller->renderPartial('application.modules.collection.views.backend._renderCollectionItem-tag', array('model' => $refObject), true);
		}

		return $result;
	}

	public function deleteCollectionItem($user, $id)
	{
		$collectionItem = CollectionItem::model()->findByPk($id);
		if (empty($collectionItem)) {
			throw new Exception('Collection item not found');
		}
		if ($collectionItem->collectionSub->collection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, collection item do not owned by user');
		}

		return $collectionItem->delete();
	}

	public function deleteCollectionSub($user, $id)
	{
		$collectionSub = CollectionSub::model()->findByPk($id);
		if (empty($collectionSub)) {
			throw new Exception('Sub collection not found');
		}
		if ($collectionSub->collection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, sub collection do not owned by user');
		}

		return $collectionSub->delete();
	}

	public function deleteCollection($user, $id)
	{
		$collection = Collection::model()->findByPk($id);
		if (empty($collection)) {
			throw new Exception('Collection not found');
		}
		if ($collection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, collection do not owned by user');
		}

		return $collection->delete();
	}

	public function moveCollectionSub($user, $id, $targetCollectionId)
	{
		$collectionSub = CollectionSub::model()->findByPk($id);
		if (empty($collectionSub)) {
			throw new Exception('Sub collection not found');
		}
		if ($collectionSub->collection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, sub collection do not owned by user');
		}
		$destCollection = Collection::model()->findByPk($targetCollectionId);
		if (empty($destCollection)) {
			throw new Exception('Destination collection not found');
		}
		if ($destCollection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, destination collection do not owned by user.');
		}

		$collectionSub->collection_id = $destCollection->id;
		$collectionSub->save();

		return $collectionSub;
	}

	public function renameCollectionSub($user, $id, $newTitle)
	{
		$collectionSub = CollectionSub::model()->findByPk($id);
		if (empty($collectionSub)) {
			throw new Exception('Sub collection not found');
		}
		if ($collectionSub->collection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, sub collection do not owned by user.');
		}

		$collectionSub->title = $newTitle;
		$collectionSub->save();

		return $collectionSub;
	}

	public function renameCollection($user, $id, $newTitle)
	{
		$collection = Collection::model()->findByPk($id);
		if (empty($collection)) {
			throw new Exception('Collection not found');
		}
		if ($collection->creator_user_id != $user->id || empty($user->id)) {
			throw new Exception('Invalid access, collection do not owned by user.');
		}

		$collection->title = $newTitle;
		$collection->save();

		return $collection;
	}
}
