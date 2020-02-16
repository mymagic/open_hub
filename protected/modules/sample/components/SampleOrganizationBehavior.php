<?php
Yii::import('modules.sample.models.*');

// this allow you to inject method into organization object
class SampleOrganizationBehavior extends Behavior
{
    // the organization model
    public $model;

    //
    // items
    function countAllSampleItems()
    {
        return HubSample::countAllOrganizationSamples($this->model);
    }

    function getActiveSampleItems($limit=100)
    {
        return HubSample::getActiveOrganizationSamples($this->model, $limit);
    }

    function shoutSample()
    {
        return 'I am from sample module!';
    }
}
