<?php

class Tag extends TagBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function getForeignReferList($isNullable=false, $is4Filter=false)
	{
		$language = Yii::app()->language;		
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');
		$result = Yii::app()->db->createCommand()->select("id as key, name as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes(); 

		$this->name = $keyword;
		
		$tmp = $this->search(array('compareOperator'=>'OR'));
		$tmp->sort->defaultOrder = 't.name ASC'; 
		
		return $tmp;
	}
}
