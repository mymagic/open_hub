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

	public static function getAllActiveServices()
	{
		return Service::model()->findAllByAttributes(array('is_active' => 1));
	}

	public static function getServiceSlug($slug)
	{
		return Service::model()->findByAttributes(array('slug' => $slug));
	}

	public static function listBookmarkable()
	{
		$return = Service::model()->isActive()->isBookmarkable()->findAll(array('order' => 'slug ASC'));

		return $return;
	}

	public static function setBookmarkByUser($user, $csvServices)
	{
		if (empty($csvServices)) {
			throw new Exception(Yii::t('app', 'You must insert at least one service to bookmark'));
		}
		$csvServices = explode(',', $csvServices);

		if (!empty($csvServices)) {
			// clear all existing service of user
			Service2User::model()->deleteAll("user_id='{$user->id}'");

			foreach ($csvServices as $serviceSlug) {
				$serviceSlug = trim($serviceSlug);
				$service = self::getServiceSlug($serviceSlug);
				if ($service->canBookmarkByUser($user->id)) {
					$service2user = new Service2User();
					$service2user->user_id = $user->id;
					$service2user->service_id = $service->id;
					$service2user->save();
				}
			}
		}

		return self::listBookmarkByUser($user);
	}

	public static function listBookmarkByUser($user)
	{
		$return = Service2User::model()->with('service')->findAll(array('condition' => sprintf("user_id='%s'", $user->id), 'order' => 'service.slug ASC'));

		return $return;
	}
}
