<?php

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

/**
 * @OGM\Node(label="Neo4jChallenge")
 */
class Neo4jChallenge extends Neo4j
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
	protected $is_publish;

	/**
	 * @var boolean
	 * @OGM\Property(type="boolean")
	 */
	protected $is_highlight;

	/**
	 * @var int
	 * @OGM\Property(type="int")
	 */
	protected $date_open;

	/**
	 * @var int
	 * @OGM\Property(type="int")
	 */
	protected $date_close;

	/**
	 * @var Neo4jIndustry[]|NeoCollection
	 * @OGM\Relationship(type="HAS_INDUSTRY", direction="OUTGOING", collection=true, targetEntity="Neo4jIndustry")
	 */
	protected $industries;

	public $relationships = ['inputIndustries'];

	public $entityManager;

	public $repository;

	public $relationshipData;


	public function __construct($model = '')
	{
		$this->init();
		$this->setAttributes($model);

		$this->industries = new NeoCollection();
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
	 * @param boolean $is_publish
	 */
	public function setIsPublish($value)
	{
		$this->is_publish = $value;
	}


	/**
	 * @return boolean
	 */
	public function getIsPublish()
	{
		return $this->is_publish;
	}


	/**
	 * @param boolean $is_highlight
	 */
	public function setIsHighlight($value)
	{
		$this->is_highlight = $value;
	}


	/**
	 * @return boolean
	 */
	public function getIsHighlight()
	{
		return $this->is_highlight;
	}


	/**
	 * @param int $date_open
	 */
	public function setDateOpen($value)
	{
		$this->date_open = $value;
	}


	/**
	 * @return int
	 */
	public function getDateOpen()
	{
		return $this->date_open;
	}


	/**
	 * @param int $date_close
	 */
	public function setDateClose($value)
	{
		$this->date_close = $value;
	}


	/**
	 * @return int
	 */
	public function getDateClose()
	{
		return $this->date_close;
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


	public function getRecommendation() {

        $userId = Yii::app()->user->id;
        $time = time();

        $challenges = $this->entityManager->createQuery("MATCH (interest:Neo4jInterest {user_id: '$userId'})-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE|:HAS_SDG|:HAS_CLUSTER]->()<-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE|:HAS_SDG|:HAS_CLUSTER]-(challenge:Neo4jChallenge)
        WHERE toInteger(challenge.date_close) > $time AND challenge.is_active = 1 AND challenge.is_publish = 1
        RETURN challenge.id, count(challenge) as frequency
        ORDER BY frequency DESC
        LIMIT 10")->execute();

        $challengeIds = array();

        foreach($challenges as $challenge) {
            array_push($challengeIds, $challenge['challenge.id']);
        }

		return $challengeIds;

	}
}
