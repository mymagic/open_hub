<?php

class getEsLogSystemActFeed extends Action
{
	// get latest log by page, start with 1
	// dateStart: optional, default to now
	// dateEnd: optional, default to 1 jan 2014
	public function run()
	{
		$meta = array();
		$page = Yii::app()->request->getPost('page');
		$filter = Yii::app()->request->getPost('filter');

		$page = empty($page) ? 1 : $page;

		$meta['input']['page'] = $page;
		$meta['input']['filter'] = $filter;

		$limit = 1000;
		$offset = $limit * ($page - 1);
		$filterDecoded = null;
		if (!empty($filter)) {
			$filterDecoded = json_decode($filter, true);
		}

		try {
			$result = HubEsLog::getAll(
					Yii::app()->esLog->getClient(),
					$page,
					$filterDecoded,
					$offset,
					$limit
				);

			//if(Yii::app()->params['dev']) $meta['output']['sql'] = $tmps['sql'];
			$meta['output']['limit'] = $limit;
			/*$meta['output']['countPageItems'] = $tmps['countPageItems'];
			$meta['output']['totalItems'] = $tmps['totalItems'];
			$meta['output']['totalPages'] = $tmps['totalPages'];
			$meta['output']['filters'] = $tmps['filters'];*/

			$this->getController()->outputSuccess($result, $meta);
		} catch (Exception $e) {
			$this->getController()->outputFail($e->getMessage(), $meta);
		}
	}
}
