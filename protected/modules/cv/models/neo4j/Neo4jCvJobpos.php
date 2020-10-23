<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

/**
 * @OGM\Node(label="Neo4jCvJobpos")
 */
class Neo4jCvJobpos extends Neo4j
{
	/**
	 * @var int
	 * @OGM\GraphId()
	 */
	protected $graphid;
	public $entityManager;
	public $repository;


	public function __construct($model = '')
	{
		$this->init();
		$this->setAttributes($model);
	}


	public function model($model = '')
	{
		return new self($model);
	}
}
