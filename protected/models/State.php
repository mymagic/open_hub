<?php

class State extends StateBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function getForeignReferList($isNullable=false, $is4Filter=false, $htmlOptions='')
	{
		$language = Yii::app()->language;
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');
		
		if(!empty($htmlOptions['params']) && !empty($htmlOptions['params']['country_code']))
		{
			$result = Yii::app()->db->createCommand()
			->select("code as key, title as title")
			->from(self::tableName())
			->where(sprintf("country_code='%s'", $htmlOptions['params']['country_code']))
			->order('title ASC')->queryAll();
		}
		else
		{
			$result = Yii::app()->db->createCommand()->select("code as key, title as title")->from(self::tableName())->order('title ASC')->queryAll();
		}
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function toApi()
	{
		return array(
			'code' => $this->code,
			'countryCode' => $this->country_code,
			'title' => $this->title,
		);
	}
}
