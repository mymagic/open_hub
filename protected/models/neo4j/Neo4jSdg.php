<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

/**
 * @OGM\Node(label="Neo4jSdg")
 */
class Neo4jSdg extends Neo4j
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
	protected $title;

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
	 * @param string $id
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
	 * @param string $title
	 */
	public function setTitle($value)
	{
		$this->title = $value;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
}
