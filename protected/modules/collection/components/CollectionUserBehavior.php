<?php

Yii::import('modules.collection.models.*');

// this allow you to inject method into organization object
class CollectionUserBehavior extends Behavior
{
    // the organization model
    public $model;

    //
    // items
    public function countAllItems()
    {
        return HubCollection::countAllUserCollections($this->model);
    }

    public function getActiveItems($limit = 100)
    {
        return HubCollection::getActiveUserCollections($this->model, $limit);
    }
}
