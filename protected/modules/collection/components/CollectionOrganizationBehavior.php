<?php
Yii::import('modules.collection.models.*');

// this allow you to inject method into organization object
class CollectionOrganizationBehavior extends Behavior
{
    // the organization model
    public $model;

    //
    // items
    function countAllItems()
    {
        return HubCollection::countAllOrganizationCollections($this->model);
    }

    function getActiveItems($limit=100)
    {
        return HubCollection::getActiveOrganizationCollections($this->model, $limit);
    }
}
