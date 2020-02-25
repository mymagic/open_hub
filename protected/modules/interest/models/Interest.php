<?php

class Interest extends InterestBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		// custom code here
		// ...

		parent::init();

		// return void
	}

	public function beforeValidate()
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate()
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...
		if (Yii::app()->neo4j->getStatus()) {
			Neo4jInterest::model($this)->sync();
		}

		return parent::afterSave();
	}

	protected function afterDelete()
	{
		// custom code here
		// ...

		$model = Neo4jInterest::model()->findOneByPk($this->id);
		$model->deleteRelationships();
		Neo4jInterest::model()->deleteOneByPk($this->id);

		return parent::afterDelete();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...

		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		// custom code here
		// ...

		parent::afterFind();

		// return void
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}
}
