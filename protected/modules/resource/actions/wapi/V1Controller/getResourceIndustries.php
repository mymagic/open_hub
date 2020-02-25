<?php

class getResourceIndustries extends Action
{
	public function run()
	{
		$tmps = HUB::getResourceIndustries();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
		}
		$this->getController()->outputSuccess($result);
	}
}
