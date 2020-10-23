<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

/**
 * @OGM\Node(label="Neo4jCvPortfolio")
 */
class Neo4jCvPortfolio extends Neo4j
{
	/**
	 * @var int
	 * @OGM\GraphId()
	 */
	protected $graphid;

	/**
	 * @var string
	 * @OGM\Property(type="string")
	 */
	protected $id;

	/**
	 * @var string
	 * @OGM\Property(type="string")
	 */
	protected $display_name;
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


	/**
	 * @param s $id
	 */
	public function setId($value)
	{
		$this->id = $value;
	}


	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @param s $display_name
	 */
	public function setDisplayName($value)
	{
		$this->display_name = $value;
	}


	/**
	 * @return string
	 */
	public function getDisplayName()
	{
		return $this->display_name;
	}
}
