<?php

class Service extends ServiceBase
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

	public static function isSlugExists($slug)
	{
		$service = Service::model()->find('slug=:slug', array(':slug' => $slug));
		if ($service === null) {
			return false;
		}

		return true;
	}

	public static function setService($slug, $title, $oneliner, $attributes = array())
	{
		// new record
		if (!self::isSlugExists($slug)) {
			$service = new Service();
			$service->slug = $slug;
		} else {
			$service = self::model()->find('slug=:slug', array(':slug' => $slug));
		}

		$service->title = $title;
		$service->text_oneliner = $oneliner;
		$service->attributes = $attributes;
		$service->save();

		return $service;
	}
}
