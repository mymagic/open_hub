<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

/**
 * @OGM\Node(label="Neo4jInterest")
 */
class Neo4jInterest extends Neo4j
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
	protected $user_id;

	/**
	 * @var boolean
	 * @OGM\Property(type="boolean")
	 */
	protected $is_active;

	/**
	 * @var Neo4jIndustry[]|NeoCollection
	 * @OGM\Relationship(type="HAS_INDUSTRY", direction="OUTGOING", collection=true, targetEntity="Neo4jIndustry")
	 */
	protected $industries;

	/**
	 * @var Neo4jSdg[]|NeoCollection
	 * @OGM\Relationship(type="HAS_SDG", direction="OUTGOING", collection=true, targetEntity="Neo4jSdg")
	 */
	protected $sdgs;

	/**
	 * @var Neo4jStartupStage[]|NeoCollection
	 * @OGM\Relationship(type="HAS_STARTUPSTAGE", direction="OUTGOING", collection=true, targetEntity="Neo4jStartupStage")
	 */
	protected $startupStages;

	/**
	 * @var Neo4jCluster[]|NeoCollection
	 * @OGM\Relationship(type="HAS_CLUSTER", direction="OUTGOING", collection=true, targetEntity="Neo4jCluster")
	 */
	protected $clusters;

	/**
	 * @var Neo4jPersona[]|NeoCollection
	 * @OGM\Relationship(type="HAS_PERSONA", direction="OUTGOING", collection=true, targetEntity="Neo4jPersona")
	 */
	protected $personas;

	public $relationships = ['inputIndustries', 'inputSdgs', 'inputStartupStages', 'inputClusters'];

	public $entityManager;

	public $repository;

	public $relationshipData;

	public function __construct($model = '')
	{
		$this->init();
		$this->setAttributes($model);

		$this->industries = new NeoCollection();

		$this->sdgs = new NeoCollection();

		$this->startupStages = new NeoCollection();

		$this->clusters = new NeoCollection();

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
	 * @param string $user_id
	 */
	public function setUserId($value)
	{
		$this->user_id = $value;
	}

	/**
	 * @return string
	 */
	public function getUserId()
	{
		return $this->user_id;
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
			foreach ($keys as $key) {
				$this->industries->remove($key);
			}
			$this->entityManager->flush();
		}
	}

	/**
	 * @return Neo4jSdg[]|NeoCollection
	 */
	public function getSdgs()
	{
		return $this->sdgs;
	}

	/**
	 * @param Neo4jSdg $sdg
	 */
	public function addSdgs(Neo4jSdg $sdg)
	{
		if (!$this->sdgs->contains($sdg)) {
			$this->sdgs->add($sdg);
			$this->entityManager->flush();
		}
	}

	/**
	 * @param Neo4jSdg $sdg
	 */
	public function removeSdgs(Neo4jSdg $sdg)
	{
		if ($this->sdgs->contains($sdg)) {
			$keys = $this->sdgs->getKeys();
			foreach ($keys as $key) {
				$this->sdgs->remove($key);
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
			foreach ($keys as $key) {
				$this->startupStages->remove($key);
			}
			$this->entityManager->flush();
		}
	}

	/**
	 * @return Neo4jCluster[]|NeoCollection
	 */
	public function getClusters()
	{
		return $this->clusters;
	}

	/**
	 * @param Neo4jCluster $cluster
	 */
	public function addClusters(Neo4jCluster $cluster)
	{
		if (!$this->clusters->contains($cluster)) {
			$this->clusters->add($cluster);
			$this->entityManager->flush();
		}
	}

	/**
	 * @param Neo4jCluster $cluster
	 */
	public function removeClusters(Neo4jCluster $cluster)
	{
		if ($this->clusters->contains($cluster)) {
			$keys = $this->clusters->getKeys();
			foreach ($keys as $key) {
				$this->clusters->remove($key);
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
			if ($this->entityManager) {
				$this->entityManager->flush();
			}
		}
	}

	/**
	 * @param Neo4jPersona $persona
	 */
	public function removePersonas(Neo4jPersona $persona)
	{
		if ($this->personas->contains($persona)) {
			$keys = $this->personas->getKeys();
			foreach ($keys as $key) {
				$this->personas->remove($key);
			}
			$this->entityManager->flush();
		}
	}

	public function addPersona($personas)
	{
		$main = get_class($this)::model()->findOneByPk($this->getId());
		$main->init();
		foreach ($personas as $persona) {
			$pers = Neo4jPersona::model()->findOneByPk($persona);
			$main->addPersonas($pers);
		}
	}

	public function deletePersonas()
	{
		$main = get_class($this)::model()->findOneByPk($this->getId());
		$main->init();
		foreach ($main->personas as $persona) {
			$main->removePersonas($persona);
		}
	}
}
