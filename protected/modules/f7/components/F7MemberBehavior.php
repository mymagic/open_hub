<?php

Yii::import('modules.f7.models.*');

// this allow you to inject method into member object
class F7MemberBehavior extends Behavior
{
	// the member model
	public $model;

	//
	// items
	public function getFormSubmissions($limit = 100)
	{
		return HubForm::getFormSubmissions($this->model->user, $limit);
	}
}
