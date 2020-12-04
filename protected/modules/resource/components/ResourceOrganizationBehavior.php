<?php

Yii::import('modules.resource.models.*');

// this allow you to inject method into organization object
class ResourceOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	public function getResources()
	{
		return HubResource::getResourcesFromOrganization($this->model);
	}
}
