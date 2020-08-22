<?php

class getMemberSystemActFeed extends Action
{
	public function run()
	{
		$meta = array();

		$dateStart = Yii::app()->request->getPost('dateStart');
		$dateEnd = Yii::app()->request->getPost('dateEnd');
		$page = Yii::app()->request->getPost('page');
		$forceRefresh = Yii::app()->request->getPost('forceRefresh');

		if (!isset($page)) {
			$page = 1;
		}

		$meta['input']['dateStart'] = $dateStart;
		$meta['input']['dateEnd'] = $dateEnd;
		$meta['input']['page'] = $page;
		$meta['input']['forceRefresh'] = $forceRefresh;

		if (!isset($dateStart) || !isset($dateEnd)) {
			$result['status'] = 'fail';
			$result['msg'] = 'Date start and end required';
		} else {
			$useCache = Yii::app()->params['cache'];
			$useCache = false;
			$cacheId = sprintf('%s::%s-%s', 'journey', 'getMemberSystemActFeed', sha1(json_encode(array('v4', $dateStart, $dateEnd))));

			$result = Yii::app()->cache->get($cacheId);
			if ($result === false || $useCache === false || $forceRefresh) {
				$meta['output']['useCache'] = false;

				$tmps = HubMember::getSystemActFeed($dateStart, $dateEnd, $page);
				$result = null;
				$result['status'] = $tmps['status'];
				$result['msg'] = $tmps['msg'];

				if ($tmps['status'] == 'success') {
					foreach ($tmps['data'] as $member) {
						$result['data'][] = $member->toApi();
					}
				}

				Yii::app()->cache->set($cacheId, $result, 15 * 60);
			} else {
				$meta['output']['useCache'] = true;
			}
		}

		$result['meta'] = $meta;

		$this->getController()->outputPipe($result);
	}
}
