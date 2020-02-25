<?php

class getResourcePersonas extends Action
{
	public function run()
	{
		$tmps = HUB::getResourcePersonas();
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				$result[] = $tmp->toApi();
			}
		}
		$this->getController()->outputSuccess($result);
	}
}
