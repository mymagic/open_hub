<?php
Yii::import('modules.comment.models.*');

class CommentResourceBehavior extends Behavior
{
    public $model;

    //
    // comments
    function countAllComments()
    {
        return HubComment::countAllResourceComments($this->model);
    }

    function getActiveComments($limit=100)
    {
        return HubComment::getActiveResourceComments($this->model, $limit);
    }
}
