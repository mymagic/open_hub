<?php

use GraphAware\Neo4j\Client\Exception\Neo4jException as NeoException;

class HubInterest
{
	public function countAllOrganizationInterests($organization)
	{
		//return Comment::countByObjectKey(sprintf('organization-%s', $organization->id));
		return 0;
	}

	public function getActiveOrganizationInterests($organization, $limit = 100)
	{
		/*return Comment::model()->findAll(array(
			'condition' => 'object_key=:objectKey AND is_active=1',
			'params' => array(':objectKey'=> sprintf('organization-%s', $organization->id)),
			'limit' => $limit,
			'order' => 'id DESC'
		));*/
		return array();
	}

	public function getRecommendationForResources()
	{
		try {
			$client = Yii::app()->neo4j->getClient();
			$records = $client->run("
			MATCH (user:User {username: {username}})-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE]->()<-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE]-(resource:Resource)
			RETURN resource.id, count(resource) as frequency
			ORDER BY frequency DESC
			LIMIT 5
		", ['username' => Yii::app()->user->username]);
			$resources = array();
			foreach ($records->getRecords() as $record) {
				array_push($resources, Resource::model()->findByPk($record->value('resource.id')));
			}

			return $resources;
		} catch (NeoException $err) {

			return null;
		}
	}

	public function getRecommendationForEvents()
	{
		try {
			$client = Yii::app()->neo4j->getClient();
			$records = $client->run("
			MATCH (user:User {username: {username}})-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE]->()<-[:HAS_PERSONA|:HAS_INDUSTRY|:HAS_STARTUPSTAGE]-(event:Event)
			WHERE event.end > {time}
			RETURN event.id, count(event) as frequency
			ORDER BY frequency DESC
			LIMIT 5
		", ['username' => Yii::app()->user->username, 'time' => (string) time()]);
			$events = array();
			foreach ($records->getRecords() as $record) {
				array_push($events, Event::model()->findByPk($record->value('event.id')));
			}

			return $events;
		} catch (NeoException $err) {
			return null;
		}
	}

	public function getRecommendationForChallenges()
	{
		try {

			$client = Yii::app()->neo4j->getClient();
			$records = $client->run("
			MATCH (user:User {username: {username}})-[:HAS_INDUSTRY]->()<-[:HAS_INDUSTRY]-(challenge:Challenge)
			WHERE challenge.end > {time}
			RETURN challenge.id, count(challenge) as frequency
			ORDER BY frequency DESC
			LIMIT 5
		", ['username' => Yii::app()->user->username, 'time' => (string) time()]);
			$challenges = array();
			foreach ($records->getRecords() as $record) {
				array_push($challenges, Challenge::model()->findByPk($record->value('challenge.id')));
			}

			return $challenges;
		} catch (NeoException $err) {
			return null;
		}
	}

	public function syncNeo()
	{
		$client = Yii::app()->neo4j->getClient();

		$client->run('MATCH (n:User) DELETE n');
		$client->run('CREATE (n:User)');
		$client->run('MATCH (n:User) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:User) ASSERT n.id IS UNIQUE');

		echo "\nUser Table Created\n";

		$client->run('MATCH (n:Event) DELETE n');
		$client->run('CREATE (n:Event)');
		$client->run('MATCH (n:Event) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Event) ASSERT n.id IS UNIQUE');

		echo "\nEvent Table Created\n";

		$client->run('MATCH (n:Resource) DELETE n');
		$client->run('CREATE (n:Resource)');
		$client->run('MATCH (n:Resource) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Resource) ASSERT n.id IS UNIQUE');

		echo "\nResource Table Created\n";

		$client->run('MATCH (n:Challenge) DELETE n');
		$client->run('CREATE (n:Challenge)');
		$client->run('MATCH (n:Challenge) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Challenge) ASSERT n.id IS UNIQUE');

		echo "\nChallenge Table Created\n";

		$client->run('MATCH (n:Persona) DELETE n');
		$client->run('CREATE (n:Persona)');
		$client->run('MATCH (n:Persona) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Persona) ASSERT n.id IS UNIQUE');

		echo "\nPersona Table Created\n";

		$client->run('MATCH (n:StartupStage) DELETE n');
		$client->run('CREATE (n:StartupStage)');
		$client->run('MATCH (n:StartupStage) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:StartupStage) ASSERT n.id IS UNIQUE');

		echo "\nStartupStage Table Created\n";

		$client->run('MATCH (n:Industry) DELETE n');
		$client->run('CREATE (n:Industry)');
		$client->run('MATCH (n:Industry) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Industry) ASSERT n.id IS UNIQUE');

		echo "\nIndustry Table Created\n";

		$client->run('MATCH (n:Sdg) DELETE n');
		$client->run('CREATE (n:Sdg)');
		$client->run('MATCH (n:Sdg) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Sdg) ASSERT n.id IS UNIQUE');

		echo "\nSdg Table Created\n";

		$client->run('MATCH (n:Cluster) DELETE n');
		$client->run('CREATE (n:Cluster)');
		$client->run('MATCH (n:Cluster) DELETE n');
		$client->run('CREATE CONSTRAINT ON (n:Cluster) ASSERT n.id IS UNIQUE');

		echo "\nCluster Table Created\n";

		$stack = $client->stack();
		$users = User::model()->findAll();

		foreach ($users as $user) {
			if ($user->is_active) {
				try {
					$stack->push('CREATE (user:User {id: {id}, username: {username}})', ['id' => $user->id, 'username' => $user->username]);
				} catch (NeoException $err) {
					print_r($err);
				}
			}
		}

		try {
			$client->runStack($stack);
			echo "\nUsers data inserted\n";
		} catch (NeoException $err) {
			echo $err;
		}

		$stack = $client->stack();
		$events = Event::model()->findAll();

		foreach ($events as $key => $event) {
			if ($event->is_active) {
				$stack->push('CREATE (event:Event {id: {id}, title: {title}, start: {start}, end: {end}})', ['id' => $event->id, 'title' => $event->title, 'start' => (string) $event->date_started, 'end' => (string) $event->date_ended]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nEvents data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$resources = Resource::model()->findAll();

		foreach ($resources as $resource) {
			if ($resource->is_active) {
				$stack->push('CREATE (resource:Resource {id: {id}, slug: {slug}, title: {title}})', ['id' => $resource->id, 'title' => $resource->title, 'slug' => $resource->slug]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nResources data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$challenges = Challenge::model()->findAll();

		foreach ($challenges as $challenge) {
			if ($challenge->is_active) {
				$stack->push('CREATE (challenge:Challenge {id: {id}, title: {title}, start: {start}, end: {end}})', ['id' => $challenge->id, 'title' => $challenge->title, 'start' => (string) $challenge->date_open, 'end' => (string) $challenge->date_close]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nChallenge data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$personas = Persona::model()->findAll();

		foreach ($personas as $persona) {
			if ($persona->is_active) {
				$stack->push('CREATE (persona:Persona {id: {id}, slug: {slug}, title: {title}})', ['id' => $persona->id, 'title' => $persona->title, 'slug' => $persona->slug]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nPersonas data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$stages = StartupStage::model()->findAll();

		foreach ($stages as $stage) {
			if ($stage->is_active) {
				$stack->push('CREATE (stage:StartupStage {id: {id}, slug: {slug}, title: {title}})', ['id' => $stage->id, 'title' => $stage->title, 'slug' => $stage->slug]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nStartup stages data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$industries = Industry::model()->findAll();

		foreach ($industries as $industry) {
			if ($industry->is_active) {
				$stack->push('CREATE (industry:Industry {id: {id}, slug: {slug}, title: {title}})', ['id' => $industry->id, 'title' => $industry->title, 'slug' => $industry->slug]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nIndustries data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$sdgs = Sdg::model()->findAll();

		foreach ($sdgs as $sdg) {
			if ($sdg->is_active) {
				$stack->push('CREATE (sdg:Sdg {id: {id}, title: {title}})', ['id' => $sdg->id, 'title' => $sdg->title]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nSdgs data inserted\n";
		} catch (NeoException $err) {
		}

		$stack = $client->stack();
		$clusters = Cluster::model()->findAll();

		foreach ($clusters as $cluster) {
			if ($cluster->is_active) {
				$stack->push('CREATE (cluster:Cluster {id: {id}, title: {title}})', ['id' => $cluster->id, 'title' => $cluster->title]);
			}
		}

		try {
			$client->runStack($stack);
			echo "\nClusters data inserted\n";
		} catch (NeoException $err) {
		}

		$stack = $client->stack();
		$users = User::model()->findAll();
		foreach ($users as $user) {
			$individual = Individual::getIndividualByEmail($user->username);
			foreach ($individual->personas as $persona) {
				$stack->push('MATCH (user:User),(persona:Persona) WHERE user.id = {userId} AND persona.id = {personaId} CREATE (user)-[r:HAS_PERSONA]->(persona)', ['userId' => $user->id, 'personaId' => $persona->id]);
			}
		}
		try {
			$client->runStack($stack);
			echo "\nUser relationship data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$events = Event::model()->findAll();
		foreach ($events as $event) {
			foreach ($event->personas as $persona) {
				$stack->push('MATCH (event:Event),(persona:Persona) WHERE event.id = {eventId} AND persona.id = {personaId} CREATE (event)-[r:HAS_PERSONA]->(persona)', ['eventId' => $event->id, 'personaId' => $persona->id]);
			}
			foreach ($event->industries as $industry) {
				$stack->push('MATCH (event:Event),(industry:Industry) WHERE event.id = {eventId} AND industry.id = {industryId} CREATE (event)-[r:HAS_INDUSTRY]->(industry)', ['eventId' => $event->id, 'industryId' => $industry->id]);
			}
			foreach ($event->startupStages as $stage) {
				$stack->push('MATCH (event:Event),(stage:StartupStage) WHERE event.id = {eventId} AND stage.id = {stageId} CREATE (event)-[r:HAS_STARTUPSTAGE]->(stage)', ['eventId' => $event->id, 'stageId' => $stage->id]);
			}
		}
		try {
			$client->runStack($stack);
			echo "\nEvent relationship data inserted\n";
		} catch (NeoException $err) {
		}


		$stack = $client->stack();
		$resources = Resource::model()->findAll();
		foreach ($resources as $resource) {
			if ($resource->is_active) {
				foreach ($resource->personas as $persona) {
					$stack->push('MATCH (resource:Resource),(persona:Persona) WHERE resource.id = {resourceId} AND persona.id = {personaId} CREATE (resource)-[r:HAS_PERSONA]->(persona)', ['resourceId' => $resource->id, 'personaId' => $persona->id]);
				}
				foreach ($resource->industries as $industry) {
					$stack->push('MATCH (resource:Resource),(industry:Industry) WHERE resource.id = {resourceId} AND industry.id = {industryId} CREATE (resource)-[r:HAS_INDUSTRY]->(industry)', ['resourceId' => $resource->id, 'industryId' => $industry->id]);
				}
				foreach ($resource->startupStages as $stage) {
					$stack->push('MATCH (resource:Resource),(stage:StartupStage) WHERE resource.id = {resourceId} AND stage.id = {stageId} CREATE (resource)-[r:HAS_STARTUPSTAGE]->(stage)', ['resourceId' => $resource->id, 'stageId' => $stage->id]);
				}
			}
		}
		try {
			$client->runStack($stack);
			echo "\nResource relationship data inserted\n";
		} catch (NeoException $err) {
			echo $err;
		}


		$stack = $client->stack();
		$challenges = Challenge::model()->findAll();
		foreach ($challenges as $challenge) {
			foreach ($challenge->industries as $industry) {
				$stack->push('MATCH (challenge:Challenge),(industry:Industry) WHERE challenge.id = {challengeId} AND industry.id = {industryId} CREATE (challenge)-[r:HAS_INDUSTRY]->(industry)', ['challengeId' => $challenge->id, 'industryId' => $industry->id]);
			}
		}
		try {
			$client->runStack($stack);
			echo "\nChallenge relationship data inserted\n";
		} catch (NeoException $err) {
		}

		$stack = $client->stack();
		$users = User::model()->findAll();

		foreach ($users as $user) {
			if ($user->is_active) {
				$interest = Interest::model()->findByAttributes(array('user_id' => $user->id));
				foreach ($interest->industries as $industry) {
					$stack->push('MATCH (user:User),(industry:Industry) WHERE user.id = {userId} AND industry.id = {industryId} CREATE (user)-[r:HAS_INDUSTRY]->(industry)', ['userId' => $user->id, 'industryId' => $industry->id]);
				}
				foreach ($interest->startupStages as $stage) {
					$stack->push('MATCH (user:User),(stage:StartupStage) WHERE user.id = {userId} AND stage.id = {stageId} CREATE (user)-[r:HAS_STARTUPSTAGE]->(stage)', ['userId' => $user->id, 'stageId' => $stage->id]);
				}
				foreach ($interest->clusters as $cluster) {
					$stack->push('MATCH (user:User),(cluster:Cluster) WHERE user.id = {userId} AND cluster.id = {clusterId} CREATE (user)-[r:HAS_CLUSTER]->(cluster)', ['userId' => $user->id, 'clusterId' => $cluster->id]);
				}
				foreach ($interest->sdgs as $sdg) {
					$stack->push('MATCH (user:User),(sdg:Sdg) WHERE user.id = {userId} AND sdg.id = {sdgId} CREATE (user)-[r:HAS_SDG]->(sdg)', ['userId' => $user->id, 'sdgId' => $sdg->id]);
				}
			}
		}

		try {
			$client->runStack($stack);
			echo "\nUsers interest data inserted\n";
		} catch (NeoException $err) {
		}
	}
}
