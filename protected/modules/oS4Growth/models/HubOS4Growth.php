<?php

class HubOS4Growth
{
	public function countAllOrganizationOS4Growths($organization)
	{
		//return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
		return 0;
	}

	public function getActiveOrganizationOS4Growths($organization, $limit = 100)
	{
		/*return Comment::model()->findAll(array(
			'condition' => 'object_key=:objectKey AND is_active=1',
			'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
			'limit' => $limit,
			'order' => 'id DESC'
		));*/
		return array();
	}

	public function countAllMemberOS4Growths($member)
	{
		return 0;
	}

	public function getActiveMemberOS4Growths($member, $limit = 100)
	{
		return array();
	}
}
