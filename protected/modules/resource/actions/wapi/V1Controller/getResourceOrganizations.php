<?php

class getResourceOrganizations extends Action
{
    public function run()
	{
        $result = HUB::getResourceOrganizations();

		$this->getController()->outputSuccess($result);
    }
}