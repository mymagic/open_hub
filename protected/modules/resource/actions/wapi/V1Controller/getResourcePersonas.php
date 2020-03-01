<?php

class getResourcePersonas extends Action
{
	public function run()
	{
		$tmps = HubResource::getPersonas();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
		}
		$this->getController()->outputSuccess($result);
	}
}
