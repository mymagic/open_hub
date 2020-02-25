<?php

Yii::import('modules.comment.models.*');

class CommentEventBehavior extends Behavior
{
	public $model;

	//
	// comments
	public function countAllComments()
	{
		return HubComment::countAllEventComments($this->model);
	}

	public function getActiveComments($limit = 100)
	{
		return HubComment::getActiveEventComments($this->model, $limit);
	}
}
