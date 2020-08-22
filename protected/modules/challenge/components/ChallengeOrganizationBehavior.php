<?php

Yii::import('modules.challenge.models.*');

// this allow you to inject method into organization object
class ChallengeOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllItems()
	{
		return HubChallenge::countAllOrganizationChallenges($this->model);
	}

	public function getActiveItems($limit = 100)
	{
		return HubChallenge::getActiveOrganizationChallenges($this->model, $limit);
	}
}
