<?php

class HubService
{
    public function countAllOrganizationServices($organization)
    {
        //return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
        return 0;
    }

    public function getActiveOrganizationServices($organization, $limit = 100)
    {
        /*return Comment::model()->findAll(array(
            'condition' => 'object_key=:objectKey AND is_active=1',
            'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
            'limit' => $limit,
            'order' => 'id DESC'
        ));*/
        return array();
    }
}
