<?php

class Resource2Industry extends Resource2IndustryBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

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

	function behaviors() 
	{
		// do not include this or else findByAttributes will give error
		/*return array
		(
			'spatial'=>array(
				'class'=>'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields'=>array(
					// all spatial fields here
				
				),
			),
		);*/
	}
}
