<?php

/**
 * This file contains classes implementing Neo4j collection feature
 *
 * @author Rosaan Ramasamy <rosaan@blazesolutions.com.my>
 *
 */

use Doctrine\Common\Inflector\Inflector;
use GraphAware\Neo4j\Client\Exception\Neo4jException as NeoException;

class Neo4j extends CComponent
{
	public function init()
	{
		$this->entityManager = Yii::app()->neo4j->getClient();
		$this->repository = $this->entityManager->getRepository(get_class($this));
	}

	public function sync()
	{
		$id = $this->id;
		$model = $this->findOneByPk($this->getId());
		if ($model) {
			$model->init();
			$model->setAttributes($this);
			$model->save();
			$this->deleteRelationships();
		} else {
			$this->save();
		}

		$this->createRelationship($id);
		$this->entityManager->clear();
	}

	public function save()
	{
		try {
			$this->entityManager->persist($this);
			$this->entityManager->flush();
		} catch (NeoException $err) {
		}
	}

	public function createRelationship($id)
	{
		if (!empty($this->relationshipData)) {
			$main = get_class($this)::model()->findOneByPk($id);
			if ($main) {
				foreach ($this->relationshipData as $key => $data) {
					$name = ucfirst(str_replace('input', '', $key));
					$setter = 'add' . $name;
					$model = 'Neo4j' . Inflector::singularize($name);
					if (class_exists($model)) {
						foreach ($data as $dt) {
							$relation = $model::model()->findOneByPk($dt);
							$main->$setter($relation);
						}
					}
				}
			}
		}
	}

	public function deleteRelationships()
	{
		if (!empty($this->relationshipData)) {
			$main = get_class($this)::model()->findOneByPk($this->getId());
			if ($main) {
				foreach ($this->relationshipData as $key => $data) {
					$name = ucfirst(str_replace('input', '', $key));
					$getter = 'get' . $name;
					$remover = 'remove' . $name;
					$model = 'Neo4j' . Inflector::singularize($name);
					if (class_exists($model)) {
						foreach ($main->$getter() as $get) {
							$relation = $model::model()->findOneByPk($get->getId());
							$main->$remover($relation);
						}
					}
				}
			}
		}
	}

	public function findAll()
	{
		$result = $this->repository->findAll();

		if ($result === null) {
			return null;
		}

		return $result;
	}

	public function findOneByAttributes($attributes)
	{
		$result = $this->repository->findOneBy($attributes);

		if ($result === null) {
			return null;
		}

		return $result;
	}

	public function findOneByPk($id)
	{
		$result = $this->repository->findOneBy(array('id' => (string) $id));

		if ($result === null) {
			return null;
		}

		return $result;
	}

	public function deleteOneByPk($id)
	{
		$result = $this->repository->findOneBy(array('id' => (string) $id));

		if ($result === null) {
			return false;
		}

		try {
			$result->deleteRelationships();
			$this->entityManager->remove($result);
			$this->entityManager->flush();
			$this->entityManager->clear();
		} catch (NeoException $err) {
			return false;
		}

		return true;
	}

	public function setAttributes($model)
	{
		foreach ($model as $key => $md) {
			$setter = 'set' . implode('', array_map('ucfirst', explode('_', $key)));
			if (method_exists($this, $setter)) {
				$this->$setter($md);
			}
		}
		if (!empty($this->relationships)) {
			foreach ($this->relationships as $relationship) {
				if (array_key_exists($relationship, $model)) {
					$this->relationshipData[$relationship] = $model->$relationship;
				}
			}
		}
	}

	public function dbSync()
	{
		$name = str_replace('Neo4j', '', get_class($this));
		$datas = $name::model()->findAll();
		foreach ($datas as $data) {
			get_class($this)::model($data)->sync();
		}
	}
}
