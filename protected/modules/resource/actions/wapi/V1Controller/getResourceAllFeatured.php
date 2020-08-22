<?php

class getResourceAllFeatured extends Action
{
	public function run()
	{
		$meta = array();

		$tmps = HubResource::getAllFeatured();

		if (!empty($tmps['items'])) {
			foreach ($tmps['items'] as $tmp) {
				$result[] = $tmp->toApi();
			}
		}

		$meta['output']['sql'] = $tmps['sql'];
		$meta['output']['limit'] = $tmps['limit'];
		$meta['output']['countPageItems'] = $tmps['countPageItems'];
		$meta['output']['totalItems'] = $tmps['totalItems'];
		$meta['output']['totalPages'] = $tmps['totalPages'];
		$meta['output']['filters'] = $tmps['filters'];

		$this->getController()->outputSuccess($result, $meta);
	}
}
