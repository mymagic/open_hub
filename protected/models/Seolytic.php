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

class Seolytic extends SeolyticBase
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

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		$return['js_header'] = Yii::t('app', 'Javascript at header');
		$return['js_footer'] = Yii::t('app', 'Javascript at footer');
		$return['css_header'] = Yii::t('app', 'CSS');

		return $return;
	}
}
