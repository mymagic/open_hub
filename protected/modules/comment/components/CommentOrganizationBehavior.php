<?php
Yii::import('modules.comment.models.*');

class CommentOrganizationBehavior extends Behavior
{
    public $model;

    //
    // comments
    function countAllComments()
    {
        return HubComment::countAllOrganizationComments($this->model);
    }

    function getActiveComments($limit=100)
    {
        return HubComment::getActiveOrganizationComments($this->model, $limit);
    }
}
