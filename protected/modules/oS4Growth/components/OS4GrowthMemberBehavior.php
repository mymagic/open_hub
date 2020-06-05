<?php

Yii::import('modules.oS4Growth.models.*');

// this allow you to inject method into member object
class OS4GrowthMemberBehavior extends Behavior
{
	// the member model
	public $model;

	//
	// items
	public function countAllOS4GrowthItems()
	{
		return HubOS4Growth::countAllMemberOS4Growths($this->model);
	}

	public function getActiveOS4GrowthItems($limit = 100)
	{
		return HubOS4Growth::getActiveMemberOS4Growths($this->model, $limit);
	}

	public function shoutOS4Growth()
	{
		return 'I am from OS4Growth module!';
	}
}
