<?php

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
