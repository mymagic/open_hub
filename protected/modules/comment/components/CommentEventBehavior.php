<?php
Yii::import('modules.comment.models.*');

class CommentEventBehavior extends Behavior
{
    public $model;

    //
    // comments
    function countAllComments()
    {
        return HubComment::countAllEventComments($this->model);
    }

    function getActiveComments($limit=100)
    {
        return HubComment::getActiveEventComments($this->model, $limit);
    }
}
