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
		$this->neoClient = ($this->getStatus()) ? EntityManager::create($this->neoConnectionString) : false;
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
