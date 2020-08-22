<?php

Yii::import('modules.f7.models.*');

// this allow you to inject method into organization object
class F7OrganizationBehavior extends Behavior
{
	// the organization model
	public $model;

	//
	// items
	public function getFormSubmissions($limit = 100)
	{
		return HubForm::getFormSubmissionsByOrganization($this->model, $limit);
	}
}
