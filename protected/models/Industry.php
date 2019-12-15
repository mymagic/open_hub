<?php

class Industry extends IndustryBase
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
		$this->title = $this->title_en;

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

	public function getForeignReferList($isNullable=false, $is4Filter=false, $htmlOptions='')
	{
		$language = Yii::app()->language;		
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');

		if(!empty($htmlOptions['params']) && !empty($htmlOptions['params']['key']) && $htmlOptions['params']['key']=='code')
		{
			$result = Yii::app()->db->createCommand()
			->select("code as key, title as title")
			->from(self::tableName())
			->order('title ASC')->queryAll();
		}
		else
		{
			$result = Yii::app()->db->createCommand()->select("id as key, title as title")->from(self::tableName())->order('title ASC')->queryAll();
		}
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}

	public function renderIndustryKeywords()
	{
		$buffer = null;
		if(!empty($this->industryKeywords))
		{
			foreach($this->industryKeywords as $industryKeyword)
			{
				$buffer[] = $industryKeyword->title;
			}
		}
		return implode(',', $buffer);
	}

	// find a matching industry record from industry and industry_keyword table
	// return the industry object or null if not found
	public function searchByKeyword($keyword)
	{
		$industry = Industry::model()->find("t.title=:title AND is_active=1", array(':title'=>trim($keyword)));
		if(empty($industry))
		{
			$industryKeyword = IndustryKeyword::model()->find("t.title=:title", array(':title'=>trim($keyword)));
			if(!empty($industryKeyword))
			{
				if($industryKeyword->industry->is_active == 1)
					return $industryKeyword->industry;
			}
		}
		return $industry;
		
	}
}

