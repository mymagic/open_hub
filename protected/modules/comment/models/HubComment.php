<?php 

class HubComment
{
    public function countAllOrganizationComments($organization)
    {
        return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
    }
    public function getActiveOrganizationComments($organization, $limit=100)
    {
        return Comment::model()->findAll(array(
            'condition' => 'object_key=:objectKey AND is_active=1',
            'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
            'limit' => $limit,
            'order' => 'id DESC'
        ));
    }
    
    public function countAllIndividualComments($individual)
    {
        return Comment::countByObjectKey(sprintf('individual-%s', $individual->id));
    }
    public function getActiveIndividualComments($individual, $limit=100)
    {
        return Comment::model()->findAll(array(
            'condition' => 'object_key=:objectKey AND is_active=1',
            'params' => array(':objectKey'=> sprintf('individual-%s', $individual->id)),
            'limit' => $limit,
            'order' => 'id DESC'
        ));
    }
    
    public function countAllEventComments($event)
    {
        return Comment::countByObjectKey(sprintf('event-%s', $event->id));
    }
    public function getActiveEventComments($event, $limit=100)
    {
        return Comment::model()->findAll(array(
            'condition' => 'object_key=:objectKey AND is_active=1',
            'params' => array(':objectKey'=> sprintf('event-%s', $event->id)),
            'limit' => $limit,
            'order' => 'id DESC'
        ));
    }
    
    public function countAllResourceComments($resource)
    {
        return Comment::countByObjectKey(sprintf('resource-%s', $resource->id));
    }
    public function getActiveResourceComments($resource, $limit=100)
    {
        return Comment::model()->findAll(array(
            'condition' => 'object_key=:objectKey AND is_active=1',
            'params' => array(':objectKey'=> sprintf('resource-%s', $resource->id)),
            'limit' => $limit,
            'order' => 'id DESC'
        ));
    }
}

?>