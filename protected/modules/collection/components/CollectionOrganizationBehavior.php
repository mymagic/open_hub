<?php

Yii::import('modules.collection.models.*');

// this allow you to inject method into organization object
class CollectionOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllItems()
	{
		return HubCollection::countAllOrganizationCollections($this->model);
	}

	public function getActiveItems($limit = 100)
	{
		return HubCollection::getActiveOrganizationCollections($this->model, $limit);
	}
}
