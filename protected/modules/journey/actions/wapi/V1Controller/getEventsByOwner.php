<?php

class getEventsByOwner extends Action
{
	public function run()
	{
		$meta = array();
		$forceRefresh = false;

		$organizationCode = Yii::app()->request->getPost('organizationCode');
		$page = Yii::app()->request->getPost('page');

		if (!isset($page)) {
			$page = 1;
		}

		$meta['input']['organizationCode'] = $organizationCode;
		$meta['input']['page'] = $page;

		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'journey', 'getEventsByOwner', sha1(json_encode(array('v3', $organizationCode, $page))));

		$result = Yii::app()->cache->get($cacheId);
		if ($result === false || $useCache === false || $forceRefresh) {
			$meta['output']['useCache'] = false;

			$organization = HubOrganization::getOrganizationByCode($organizationCode);
			$tmps = HubEvent::getEventsByOwner($organization, $page);
			$result = null;
			$result['status'] = 'success';
			$result['msg'] = '';

			if ($tmps['totalItems'] > 0) {
				foreach ($tmps['items'] as $eventOwner) {
					$result['data'][] = $eventOwner->toApi();
				}
			}

			Yii::app()->cache->set($cacheId, $result, 15 * 60);
		} else {
			$meta['output']['useCache'] = true;
		}

		$result['meta'] = $meta;

		$this->getController()->outputPipe($result);
	}
}
