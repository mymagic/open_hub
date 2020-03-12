<?php

Yii::import('modules.boilerplateStart.models.*');

// this allow you to inject method into member object
class BoilerplateStartMemberBehavior extends Behavior
{
	// the member model
	public $model;

	//
	// items
	public function countAllBoilerplateStartItems()
	{
		return HubBoilerplateStart::countAllMemberBoilerplateStarts($this->model);
	}

	public function getActiveBoilerplateStartItems($limit = 100)
	{
		return HubBoilerplateStart::getActiveMemberBoilerplateStarts($this->model, $limit);
	}

	public function shout()
	{
		return 'I am from BoilerplateStart module!';
	}
}
