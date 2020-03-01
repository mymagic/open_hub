<?php

class getResourceOrganizations extends Action
{
	public function run()
	{
		$result = HubResource::getOrganizations();

		$this->getController()->outputSuccess($result);
	}
}
