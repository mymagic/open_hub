<?php

class getOpenHubLatestRelease extends Action
{
	public function run()
	{
		$meta = array();
		$result = HubOpenHub::getLatestRelease();
		$this->getController()->outputSuccess($result, $meta);
	}
}
