<?php

Yii::import('modules.boilerplateStart.models.*');

// this allow you to inject method into organization object
class BoilerplateStartOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllBoilerplateStartItems()
	{
		return HubBoilerplateStart::countAllOrganizationBoilerplateStarts($this->model);
	}

	public function getActiveBoilerplateStartItems($limit = 100)
	{
		return HubBoilerplateStart::getActiveOrganizationBoilerplateStarts($this->model, $limit);
	}

	public function shout()
	{
		return 'I am from BoilerplateStart module!';
	}
}
