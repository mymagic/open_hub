<?php

class Milestone extends MilestoneBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	// default or null is weekly
	// options are: weekly, monthly, quaterly, semiyearly, yearly
	public $viewMode = 'weekly';

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, title', 'required'),
			array('organization_id, is_star, is_active, date_added, date_modified, is_disclosed', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>128),
			array('preset_code', 'length', 'max'=>64),
			array('title, source', 'length', 'max'=>255),
			array('text_short_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, organization_id, preset_code, title, text_short_description, json_target, json_value, json_extra, is_star, is_active, date_added, date_modified, is_disclosed, source, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),

			array('viewMode', 'safe'),
		);

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
		$this->jsonArray_extra->viewMode = $this->viewMode;

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
		parent::afterFind();

		// boolean
		if($this->is_star != '' || $this->is_star != null) $this->is_star = intval($this->is_star);
		if($this->is_active != '' || $this->is_active != null) $this->is_active = intval($this->is_active);

		$this->jsonArray_target = json_decode($this->json_target);
		
		// exiang: unstructured json, always return array
		$this->jsonArray_value = json_decode($this->json_value, true);

		$this->jsonArray_extra = json_decode($this->json_extra);
		$this->viewMode = $this->jsonArray_extra->viewMode;
		
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'username' => $this->username,
			'organizationId' => $this->organization_id,
			'presetCode' => $this->preset_code,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'jsonTarget' => $this->json_target,
			'jsonValue' => $this->json_value,
			'jsonArrayValue' => json_decode($this->json_value, true),
			'jsonExtra' => $this->json_extra,
			'isStar' => $this->is_star,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
			'isDisclosed' => $this->is_disclosed,
			'source' => $this->source,
			'viewMode' => $this->viewMode,
		);
			
		// fix boolean issue
		
		foreach($return['jsonArrayValue'] as $year=>$months)
		{
			foreach($months as $month=>$weeks)
			{
				foreach($weeks as $week=>$values)
				{
					$return['jsonArrayValue'][$year][$month][$week]['realized'] = ($return['jsonArrayValue'][$year][$month][$week]['realized']=='true')?true:false;
				}
			}
		}
		// many2many

		return $return;
	}

	public function getEnumPresetCode($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumPresetCode(''));
		
		$result[] = array('code'=>'revenue', 'title'=>$this->formatEnumPresetCode('revenue'));
		//$result[] = array('code'=>'funding', 'title'=>$this->formatEnumPresetCode('funding'));
		$result[] = array('code'=>'noOfUsers', 'title'=>$this->formatEnumPresetCode('noOfUsers'));
		$result[] = array('code'=>'noOfClients', 'title'=>$this->formatEnumPresetCode('noOfClients'));
		$result[] = array('code'=>'hits', 'title'=>$this->formatEnumPresetCode('hits'));
		$result[] = array('code'=>'custom', 'title'=>$this->formatEnumPresetCode('custom'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumPresetCode($code)
	{
		switch($code)
		{
			case 'revenue': {return Yii::t('app', 'Revenue'); break;}
			//case 'funding': {return Yii::t('app', 'Funding'); break;}
			case 'noOfUsers': {return Yii::t('app', 'No of Users'); break;}
			case 'noOfClients': {return Yii::t('app', 'No of Enterprise Clients'); break;}
			case 'hits': {return Yii::t('app', 'No of Hits'); break;}
			
			
			case 'custom': {return Yii::t('app', 'Custom'); break;}
			default: {return ''; break;}
		}
	}

	public function getEnumViewMode($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumPresetCode(''));
		
		$result[] = array('code'=>'weekly', 'title'=>$this->formatEnumViewMode('weekly'));
		$result[] = array('code'=>'monthly', 'title'=>$this->formatEnumViewMode('monthly'));
		$result[] = array('code'=>'quaterly', 'title'=>$this->formatEnumViewMode('quaterly'));
		$result[] = array('code'=>'semiyearly', 'title'=>$this->formatEnumViewMode('semiyearly'));
		$result[] = array('code'=>'yearly', 'title'=>$this->formatEnumViewMode('yearly'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}

	public function formatEnumViewMode($code)
	{
		switch($code)
		{
			case 'monthly': {return Yii::t('app', 'Monthly'); break;}
			case 'quaterly': {return Yii::t('app', 'Quaterly'); break;}
			case 'semiyearly': {return Yii::t('app', 'Semi Yearly'); break;}
			case 'yearly': {return Yii::t('app', 'Yearly'); break;}
			default: {return Yii::t('app', 'Weekly'); break;}
		}
	}
	
	
}
