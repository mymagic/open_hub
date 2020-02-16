<?php

Yii::import('modules.recommendation.models.*');

// this allow you to inject method into organization object
class RecommendationOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllRecommendationItems()
	{
		return HubRecommendation::countAllOrganizationRecommendations($this->model);
	}

	public function getActiveRecommendationItems($limit = 100)
	{
		return HubRecommendation::getActiveOrganizationRecommendations($this->model, $limit);
	}

	public function shout()
	{
		return 'I am from Recommendation module!';
	}
}
