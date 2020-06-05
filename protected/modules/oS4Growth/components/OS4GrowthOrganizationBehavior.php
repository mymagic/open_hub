<?php

Yii::import('modules.oS4Growth.models.*');

// this allow you to inject method into organization object
class OS4GrowthOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllOS4GrowthItems()
	{
		return HubOS4Growth::countAllOrganizationOS4Growths($this->model);
	}

	public function getActiveOS4GrowthItems($limit = 100)
	{
		return HubOS4Growth::getActiveOrganizationOS4Growths($this->model, $limit);
	}

	public function shoutOS4Growth()
	{
		return 'I am from OS4Growth module!';
	}
}
