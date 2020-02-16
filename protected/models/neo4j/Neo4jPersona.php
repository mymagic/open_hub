<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use Neo4j;

/**
 *
 * @OGM\Node(label="Neo4jPersona")
 */

class Neo4jPersona extends Neo4j
{

    /**
     * @var int
     * 
     * @OGM\GraphId()
     */
    protected $graphid;

    /**
     * @var int
     * 
     * @OGM\Property(type="int")
     */
    protected $id;

    /**
     * @var string
     * 
     * @OGM\Property(type="string")
     */
    protected $title;

    /**
     * @var boolean
     * 
     * @OGM\Property(type="boolean")
     */
    protected $is_active;

    protected $relationships;

    protected $entityManager;
    protected $repository;
    protected $relationshipData;

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
     * @return string
     */

    public function getId()
    {
        return $this->id;
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

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */

    public function setTitle($value)
    {
        $this->title = $value;
    }

     /**
     * @return boolean
     */

    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param boolean $is_active
     */

    public function setIsActive($value)
    {
        $this->is_active = $value;
    }

}
