<?php

class Intake extends IntakeBase
{
	// tag
	public $tag_backend;
	public $inputBackendTags;
	public $searchBackendTags;

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
		$return['text_oneliner'] = Yii::t('app', 'One Liner');
		$return['text_short_description'] = Yii::t('app', 'Short Description');
		$return['image_logo'] = Yii::t('app', 'Logo Image');

		$return['searchBackendTags'] = Yii::t('app', 'Backend Tags');
		$return['inputBackendTags'] = Yii::t('app', 'Backend Tags');

		return $return;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form2intakes' => array(self::HAS_MANY, 'Form2Intake', 'intake_id'),
			'forms' => array(self::HAS_MANY, 'Form',array('form_id'=>'id'),'through'=>'form2intakes'),
			'activeForms' => array(self::HAS_MANY, 'Form',array('form_id'=>'id'),'through'=>'form2intakes', 'condition'=>'activeForms.is_active=1'),

			'impacts' => array(self::MANY_MANY, 'Impact', 'impact2intake(intake_id, impact_id)'),
			'sdgs' => array(self::MANY_MANY, 'Sdg', 'sdg2intake(intake_id, sdg_id)'),
			'industries' => array(self::MANY_MANY, 'Industry', 'industry2intake(intake_id, industry_id)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'persona2intake(intake_id, persona_id)'),
			'startupStages' => array(self::MANY_MANY, 'StartupStage', 'startup_stage2intake(intake_id, startup_stage_id)'),
			
			// tags
			'tag2Intakes' => array(self::HAS_MANY, 'Tag2Intake', 'intake_id'),
			'tags' => array(self::HAS_MANY, 'Tag', array('tag_id'=>'id'),'through'=>'tag2Intakes'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on'=>sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on'=>'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through'=>'metaStructures'),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title', 'required'),
			array('date_started, date_ended, is_active, is_highlight, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('code, slug', 'length', 'max'=>64),
			array('title, text_oneliner, image_logo', 'length', 'max'=>255),
			array('text_short_description, tag_backend, inputIndustries, inputPersonas, inputStartupStages, inputImpacts, inputSdgs', 'safe'),
			array('imageFile_logo', 'file', 'types'=>'jpg, jpeg, png, gif', 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, slug, title, text_oneliner, text_short_description, image_logo, date_started, date_ended, is_active, is_highlight, json_extra, date_added, date_modified, sdate_started, edate_started, sdate_ended, edate_ended, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend, inputBackendTags, searchBackendTags', 'safe', 'on'=>'search'),
			// meta
			array('_dynamicData', 'safe'),
		);

	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes(); 

		$this->title = $keyword;
		$this->slug = $keyword;
		$this->searchBackendTags = array($keyword);
		
		return $this->search(array('compareOperator'=>'OR'));
	}

	public function search($params=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if(empty($params['compareOperator'])) $params['compareOperator']= 'AND';

		$criteria=new CDbCriteria;
		$criteria->together = true; 

		$criteria->compare('id',$this->id, false, $params['compareOperator']);
		$criteria->compare('code',$this->code,true, $params['compareOperator']);
		$criteria->compare('slug',$this->slug,true, $params['compareOperator']);
		$criteria->compare('title',$this->title,true, $params['compareOperator']);
		$criteria->compare('text_oneliner',$this->text_oneliner,true, $params['compareOperator']);
		$criteria->compare('text_short_description',$this->text_short_description,true, $params['compareOperator']);
		$criteria->compare('image_logo',$this->image_logo,true, $params['compareOperator']);
		if(!empty($this->sdate_started) && !empty($this->edate_started))
		{
			$sTimestamp = strtotime($this->sdate_started);
			$eTimestamp = strtotime("{$this->edate_started} +1 day");
			$criteria->addCondition(sprintf('date_started >= %s AND date_started < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if(!empty($this->sdate_ended) && !empty($this->edate_ended))
		{
			$sTimestamp = strtotime($this->sdate_ended);
			$eTimestamp = strtotime("{$this->edate_ended} +1 day");
			$criteria->addCondition(sprintf('date_ended >= %s AND date_ended < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		$criteria->compare('is_active',$this->is_active, false, $params['compareOperator']);
		$criteria->compare('is_highlight',$this->is_highlight, false, $params['compareOperator']);
		//$criteria->compare('json_extra',$this->json_extra,true);
		if(!empty($this->sdate_added) && !empty($this->edate_added))
		{
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified))
		{
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}

		// tag
		if ($this->searchBackendTags !==null)
		{
			$criteriaBackendTag = new CDbCriteria;
			$criteriaBackendTag->together = true; 
			$criteriaBackendTag->with = array('tags');
			foreach($this->searchBackendTags as $backendTag)
			{
				$criteriaBackendTag->addSearchCondition('name', trim($backendTag), true, 'OR');
			}
			$criteria->mergeWith($criteriaBackendTag, $params['compareOperator']);
		}
		if ($this->inputBackendTags !==null)
		{
			$criteriaInputBackendTag = new CDbCriteria;
			$criteriaInputBackendTag->together = true; 
			$criteriaInputBackendTag->with = array('tag2Intakes');
			foreach($this->inputBackendTags as $backendTag)
			{
				$criteriaInputBackendTag->addCondition(sprintf('tag2Intakes.tag_id=%s', trim($backendTag)), 'OR');
			}
			$criteria->mergeWith($criteriaInputBackendTag, $params['compareOperator']);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=>30),
			'sort' => array('defaultOrder' => 't.date_started DESC'),
		));
	}

	public function title2obj($title)
    {
        // exiang: spent 3 hrs on the single quote around title. it's important if you passing data from different collation db table columns and do compare with = (equal). Changed to LIKE for safer comparison
        return Intake::model()->find('t.title=:title', array(':title' => trim($title)));
    }
}
