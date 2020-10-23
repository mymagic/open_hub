<?php

Yii::import('modules.cv.models.*');

// this allow you to inject method into member object
class CvMemberBehavior extends Behavior
{
	// the member model
	public $model;

	//
	// items
	public function countAllCvItems()
	{
		return HubCv::countAllMemberCvs($this->model);
	}

	public function getActiveCvItems($limit = 100)
	{
		return HubCv::getActiveMemberCvs($this->model, $limit);
	}

	public function shoutCv()
	{
		return 'I am from Cv module!';
	}
}
