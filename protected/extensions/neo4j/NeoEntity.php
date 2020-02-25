<?php

use GraphAware\Neo4j\OGM\EntityManager;

class NeoEntity extends CApplicationComponent
{
	public $neoConnectionString;
	public $neoClient;
	public $enable;

	public function init()
	{
		parent::init();
		$this->neoClient = EntityManager::create($this->neoConnectionString);
	}

	public function getClient()
	{
		return $this->neoClient;
	}

	public function getStatus()
	{
		return $this->enable;
	}
}
