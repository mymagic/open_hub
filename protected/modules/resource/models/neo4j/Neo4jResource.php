<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

/**
 * @OGM\Node(label="Neo4jResource")
 */
class Neo4jResource extends Neo4j
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

	/**
	 * @var boolean
	 * @OGM\Property(type="boolean")
	 */
	protected $is_active;

	/**
	 * @var boolean
	 * @OGM\Property(type="boolean")
	 */
	protected $is_featured;

	/**
	 * @var boolean
	 * @OGM\Property(type="boolean")
	 */
	protected $is_blocked;

	/**
	 * @var Neo4jIndustry[]|NeoCollection
	 * @OGM\Relationship(type="HAS_INDUSTRY", direction="OUTGOING", collection=true, targetEntity="Neo4jIndustry")
	 */
	protected $industries;

	/**
	 * @var Neo4jStartupStage[]|NeoCollection
	 * @OGM\Relationship(type="HAS_STARTUPSTAGE", direction="OUTGOING", collection=true, targetEntity="Neo4jStartupStage")
	 */
	protected $startupStages;

	/**
	 * @var Neo4jPersona[]|NeoCollection
	 * @OGM\Relationship(type="HAS_PERSONA", direction="OUTGOING", collection=true, targetEntity="Neo4jPersona")
	 */
	protected $personas;

	public $relationships = ['inputIndustries', 'inputStartupStages', 'inputPersonas'];

	public $entityManager;

	public $repository;

	public $relationshipData;


	public function __construct($model = '')
	{
		$this->init();
		$this->setAttributes($model);

		$this->industries = new NeoCollection();

		$this->startupStages = new NeoCollection();

		$this->personas = new NeoCollection();
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


	/**
	 * @param boolean $is_active
	 */
	public function setIsActive($value)
	{
		$this->is_active = $value;
	}


	/**
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->is_active;
	}


	/**
	 * @param boolean $is_featured
	 */
	public function setIsFeatured($value)
	{
		$this->is_featured = $value;
	}


	/**
	 * @return boolean
	 */
	public function getIsFeatured()
	{
		return $this->is_featured;
	}


	/**
	 * @param boolean $is_blocked
	 */
	public function setIsBlocked($value)
	{
		$this->is_blocked = $value;
	}


	/**
	 * @return boolean
	 */
	public function getIsBlocked()
	{
		return $this->is_blocked;
	}


	/**
	 * @return Neo4jIndustry[]|NeoCollection
	 */
	public function getIndustries()
	{
		return $this->industries;
	}


	/**
	 * @param Neo4jIndustry $industry
	 */
	public function addIndustries(Neo4jIndustry $industry)
	{
		if (!$this->industries->contains($industry)) {
		$this->industries->add($industry);
		$this->entityManager->flush();
		}
	}


	/**
	 * @param Neo4jIndustry $industry
	 */
	public function removeIndustries(Neo4jIndustry $industry)
	{
		if ($this->industries->contains($industry)) {
		$keys = $this->industries->getKeys();
		foreach($keys as $key) {
		$this->industries->remove($key);
		}
		$this->entityManager->flush();
		}
	}


	/**
	 * @return Neo4jStartupStage[]|NeoCollection
	 */
	public function getStartupStages()
	{
		return $this->startupStages;
	}


	/**
	 * @param Neo4jStartupStage $startupStage
	 */
	public function addStartupStages(Neo4jStartupStage $startupStage)
	{
		if (!$this->startupStages->contains($startupStage)) {
		$this->startupStages->add($startupStage);
		$this->entityManager->flush();
		}
	}


	/**
	 * @param Neo4jStartupStage $startupStage
	 */
	public function removeStartupStages(Neo4jStartupStage $startupStage)
	{
		if ($this->startupStages->contains($startupStage)) {
		$keys = $this->startupStages->getKeys();
		foreach($keys as $key) {
		$this->startupStages->remove($key);
		}
		$this->entityManager->flush();
		}
	}


	/**
	 * @return Neo4jPersona[]|NeoCollection
	 */
	public function getPersonas()
	{
		return $this->personas;
	}


	/**
	 * @param Neo4jPersona $persona
	 */
	public function addPersonas(Neo4jPersona $persona)
	{
		if (!$this->personas->contains($persona)) {
		$this->personas->add($persona);
		$this->entityManager->flush();
		}
	}


	/**
	 * @param Neo4jPersona $persona
	 */
	public function removePersonas(Neo4jPersona $persona)
	{
		if ($this->personas->contains($persona)) {
		$keys = $this->personas->getKeys();
		foreach($keys as $key) {
		$this->personas->remove($key);
		}
		$this->entityManager->flush();
		}
	}

	public function getRecommendation() {

		$userId = Yii::app()->user->id;

        $resources = $this->entityManager->createQuery("MATCH (interest:Neo4jInterest {user_id: '$userId'})-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE|:HAS_SDG|:HAS_CLUSTER]->()<-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE|:HAS_SDG|:HAS_CLUSTER]-(resource:Neo4jResource)
        WHERE resource.is_active = 1 AND resource.is_blocked = 0
        RETURN resource.id, count(resource) as frequency
        ORDER BY frequency DESC
        LIMIT 3")->execute();

        $resourceIds = array();

        foreach($resources as $resource) {
            array_push($resourceIds, $resource['resource.id']);
        }

		return $resourceIds;

	}
}
