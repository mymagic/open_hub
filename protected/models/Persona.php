<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/

class Persona extends PersonaBase
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
		$this->title = $this->title_en;
		$this->text_short_description = $this->text_short_description_en;

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
			Neo4jPersona::model($this)->sync();
		}

		return parent::afterSave();
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

	public static function slug2obj($slug)
	{
		return Persona::model()->find('t.slug=:slug', array(':slug' => $slug));
	}

	public static function getBySlug($slug)
	{
		return self::slug2obj($slug);
	}

	public static function getByTitle($title)
	{
		return Persona::model()->find('t.title=:title', array(':title' => $title));
	}

	public function id2title($id)
	{
		$model = self::model()->findByPk($id);
		return !empty($model) ? $model->title : false;
	}
}
