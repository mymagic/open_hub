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

class Embed extends EmbedBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function getByCode($code, $attribute='')
	{
		$cacheId = sprintf("setting.getByCode%s", $code);
		$model = Yii::app()->cache->get($cacheId);
		if($model===false)
		{
			$model = Embed::model()->find('t.code=:code', array(':code'=>$code));
			Yii::app()->cache->set($cacheId, $model, 30);
		}
		
		if($model===null)
			throw new CHttpException(404,'The requested embed content does not exist.');
			
		if($attribute == '')
		{
			return $model;
		}
		else
		{
			return $model->getAttributeDataByLanguage($model, $attribute);
		}
	}
}
