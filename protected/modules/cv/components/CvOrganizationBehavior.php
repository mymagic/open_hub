<?php

Yii::import('modules.cv.models.*');

// this allow you to inject method into organization object
class CvOrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function countAllCvItems()
	{
		return HubCv::countAllOrganizationCvs($this->model);
	}

	public function getActiveCvItems($limit = 100)
	{
		return HubCv::getActiveOrganizationCvs($this->model, $limit);
	}

	public function shoutCv()
	{
		return 'I am from Cv module!';
	}
}
