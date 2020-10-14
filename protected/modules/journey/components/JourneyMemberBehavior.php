<?php

Yii::import('modules.journey.models.*');

// this allow you to inject method into member object
class JourneyMemberBehavior extends Behavior
{
	// the member model
	public $model;

	//
	// items
	public function getAllIndividuals()
	{
		return HubMember::getIndividuals($this->model);
	}

	public function getAllOrganizations()
	{
		return HubMember::getOrganizations($this->model);
	}
}
