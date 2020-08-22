<?php

class HubEsLog
{
	// filter is in array format, eg: array('match' => ['organizationId' => '3584'])
	public function getAll($esLogClient, $page, $filter = null, $offset = 0, $limit = 100)
	{
		$params = [
			'index' => Yii::app()->params['esLogIndexCode'],
			'from' => $offset,
			'size' => $limit,
			'body' => [
				'sort' => [
					'dateLog' => ['order' => 'desc']
				]
			]
		];
		if (!empty($filter)) {
			$params['body']['query'] = $filter;
		}
		$response = $esLogClient->search($params);

		foreach ($response['hits']['hits'] as $r) {
			$rCustom = json_decode($r['_source']['customJson'], true);
			$result[] = array('msg' => $r['_source']['msg'], 'context' => $r['_type'], 'username' => $r['_source']['username'], 'dateLog' => $r['_source']['dateLog'], 'fDateLog' => Html::formatDateTime($r['_source']['dateLog']), 'custom' => $rCustom);
		}

		return $result;
	}

	public function getBackendUrl()
	{
		$urlParams['id'] = $r['_source']['id'];
		$action = 'view';
		$controller = $r['_source']['model'];
		if ($controller == 'user') {
			$controller = 'member';
		}

		if ($r['_type'] == 'mentor') {
			$controller = 'mentor/program';
			$action = 'viewBooking';
			$urlParams['programId'] = $rCustom['programId'];
		}
	}
}
