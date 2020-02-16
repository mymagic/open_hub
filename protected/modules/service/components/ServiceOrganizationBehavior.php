<?php

Yii::import('modules.service.models.*');

// this allow you to inject method into organization object
class ServiceOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllItems()
	{
		return HubService::countAllOrganizationServices($this->model);
	}

	public function getActiveItems($limit = 100)
	{
		return HubService::getActiveOrganizationServices($this->model, $limit);
	}
}
