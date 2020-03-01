<?php

class getResourceStartupStages extends Action
{
	public function run()
	{
		$tmps = HubResource::getStartupStages();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
		}
		$this->getController()->outputSuccess($result);
	}
}
