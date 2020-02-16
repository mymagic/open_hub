<?php
Yii::import('modules.comment.models.*');

class CommentIndividualBehavior extends Behavior
{
    public $model;

    //
    // comments
    function countAllComments()
    {
        return HubComment::countAllIndividualComments($this->model);
    }

    function getActiveComments($limit=100)
    {
        return HubComment::getActiveIndividualComments($this->model, $limit);
    }
}
