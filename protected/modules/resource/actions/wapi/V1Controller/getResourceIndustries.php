<?php

class getResourceIndustries extends Action
{
	public function run()
	{
		$tmps = HubResource::getIndustries();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
		}
		$this->getController()->outputSuccess($result);
	}
}
