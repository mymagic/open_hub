<?php

/**
 * This file contains function and attributes for Neo4jEvent::class
 *
 * @author Rosaan Ramasamy <rosaan@blazesolutions.com.my>
 *  
 */

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection as NeoCollection;

use Neo4j;

/**
 *
 * @OGM\Node(label="Neo4jEvent")
 */

class Neo4jEvent extends Neo4j
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
     * @var int
     * 
     * @OGM\Property(type="int")
     */
    protected $date_started;

    /**
     * @var int
     * 
     * @OGM\Property(type="int")
     */
    protected $date_ended;

    /**
     * @var boolean
     * 
     * @OGM\Property(type="boolean")
     */
    protected $is_active;

    /**
     * @var boolean
     * 
     * @OGM\Property(type="boolean")
     */
    protected $is_cancelled;

    /**
     * @var Neo4jPersona[]|NeoCollection
     * 
     * @OGM\Relationship(type="HAS_PERSONA", direction="OUTGOING", collection=true, targetEntity="Neo4jPersona")
     */
    protected $personas;

    /**
     * @var Neo4jIndustry[]|NeoCollection
     * 
     * @OGM\Relationship(type="HAS_INDUSTRY", direction="OUTGOING", collection=true, targetEntity="Neo4jIndustry")
     */
    protected $industries;

    /**
     * @var Neo4jStartupStage[]|NeoCollection
     * 
     * @OGM\Relationship(type="HAS_STARTUPSTAGE", direction="OUTGOING", collection=true, targetEntity="Neo4jStartupStage")
     */
    protected $startupStages;

    protected $relationships = ['inputPersonas', 'inputIndustries', 'inputStartupStages'];

    protected $entityManager;
    protected $repository;
    protected $relationshipData;

    public function __construct($model = '')
    {
        $this->init();
        $this->setAttributes($model);

        $this->personas = new NeoCollection();
        $this->industries = new NeoCollection();
        $this->startupStages = new NeoCollection();
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
     * @return int
     */

    public function getDateStarted()
    {
        return $this->date_started;
    }

    /**
     * @param int $date_started
     */

    public function setDateStarted($value)
    {
        $this->date_started = $value;
    }

    /**
     * @return int
     */

    public function getDateEnded()
    {
        return $this->date_ended;
    }

    /**
     * @param int $date_ended
     */

    public function setDateEnded($value)
    {
        $this->date_ended = $value;
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


    /**
     * @return boolean
     */

    public function getIsCancelled()
    {
        return $this->is_cancelled;
    }

    /**
     * @param boolean $is_cancelled
     */

    public function setIsCancelled($value)
    {
        $this->is_cancelled = $value;
    }

    /**
     * @return Neo4jPersona[]|NeoCollection
     */
    public function getPersonas()
    {
        return $this->personas;
    }

    /**
     * @return Neo4jPersona $persona
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
            foreach ($keys as $key) {
                $this->personas->remove($key);
            }
            $this->entityManager->flush();
        }
    }

    /**
     * @return Neo4jIndustry[]|NeoCollection
     */
    public function getIndustries()
    {
        return $this->industries;
    }

    /**
     * @return Neo4jIndustry $industry
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

    public function getRecommendation() {

        $userId = Yii::app()->user->id;
        $time = time();

        $events = $this->entityManager->createQuery("MATCH (interest:Neo4jInterest {user_id: '$userId'})-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE|:HAS_SDG|:HAS_CLUSTER]->()<-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE|:HAS_SDG|:HAS_CLUSTER]-(event:Neo4jEvent)
        WHERE event.is_active = '1' AND event.is_cancelled = '0' AND toInteger(event.date_ended) > $time
        RETURN event.id, count(event) as frequency
        ORDER BY frequency DESC
        LIMIT 3")->execute();

        $eventIds = array();

        foreach($events as $event) {
            array_push($eventIds, $event['event.id']);
        }

		return $eventIds;

	}
}
