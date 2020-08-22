<?php

Yii::import('modules.comment.models.*');

class CommentOrganizationBehavior extends Behavior
{
	public $model;

	//
	// comments
	public function countAllComments()
	{
		return HubComment::countAllOrganizationComments($this->model);
	}

	public function getActiveComments($limit = 100)
	{
		return HubComment::getActiveOrganizationComments($this->model, $limit);
	}
}
