<?php

Yii::import('modules.comment.models.*');

class CommentIndividualBehavior extends Behavior
{
	public $model;

	//
	// comments
	public function countAllComments()
	{
		return HubComment::countAllIndividualComments($this->model);
	}

	public function getActiveComments($limit = 100)
	{
		return HubComment::getActiveIndividualComments($this->model, $limit);
	}
}
