<?php


/**
 * This is the model class for table "intake".
 *
 * The followings are the available columns in table 'intake':
			 * @property integer $id
			 * @property string $code
			 * @property string $slug
			 * @property string $title
			 * @property string $text_oneliner
			 * @property string $text_short_description
			 * @property string $image_logo
			 * @property integer $date_started
			 * @property integer $date_ended
			 * @property integer $is_active
			 * @property integer $is_highlight
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Form2intake[] $form2intakes
 * @property Impact[] $impacts
 * @property Industry[] $industries
 * @property Persona[] $personas
 * @property Sdg[] $sdgs
 * @property StartupStage[] $startupStages
 * @property Tag2intake[] $tag2intakes
 */
 class IntakeBase extends ActiveRecordBase
{
	public $uploadPath;

	// m2m
	public $inputIndustries;
	public $inputPersonas;
	public $inputStartupStages;
	public $inputImpacts;
	public $inputSdgs;
	
	public $imageFile_logo;
	public $sdate_started, $edate_started;
	public $sdate_ended, $edate_ended;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;

	// json
	public $jsonArray_extra;

	// tag
	public $tag_backend;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();
		// meta
		$this->initMetaStructure($this->tableName());

		if($this->scenario == "search")
		{
			$this->is_active = null;
			$this->is_highlight = null;
		}
		else
		{
		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'intake';
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
			array('id, code, slug, title, text_oneliner, text_short_description, image_logo, date_started, date_ended, is_active, is_highlight, json_extra, date_added, date_modified, sdate_started, edate_started, sdate_ended, edate_ended, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend', 'safe', 'on'=>'search'),
			// meta
			array('_dynamicData', 'safe'),
		);

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'form2intakes' => array(self::HAS_MANY, 'Form2intake', 'intake_id'),
			'impacts' => array(self::MANY_MANY, 'Impact', 'impact2intake(intake_id, impact_id)'),
			'industries' => array(self::MANY_MANY, 'Industry', 'industry2intake(intake_id, industry_id)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'persona2intake(intake_id, persona_id)'),
			'sdgs' => array(self::MANY_MANY, 'Sdg', 'sdg2intake(intake_id, sdg_id)'),
			'startupStages' => array(self::MANY_MANY, 'StartupStage', 'startup_stage2intake(intake_id, startup_stage_id)'),
			'tag2intakes' => array(self::HAS_MANY, 'Tag2intake', 'intake_id'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on'=>sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on'=>'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through'=>'metaStructures'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'code' => Yii::t('app', 'Code'),
		'slug' => Yii::t('app', 'Slug'),
		'title' => Yii::t('app', 'Title'),
		'text_oneliner' => Yii::t('app', 'Text Oneliner'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'image_logo' => Yii::t('app', 'Image Logo'),
		'date_started' => Yii::t('app', 'Date Started'),
		'date_ended' => Yii::t('app', 'Date Ended'),
		'is_active' => Yii::t('app', 'Is Active'),
		'is_highlight' => Yii::t('app', 'Is Highlight'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);

		$return['inputIndustries'] = Yii::t('app', 'Industries');
		$return['inputPersonas'] = Yii::t('app', 'Personas');
		$return['inputStartupStages'] = Yii::t('app', 'Startup Stages');
		$return['inputImpacts'] = Yii::t('app', 'Impacts');
		$return['inputSdgs'] = Yii::t('app', 'Sdgs');

		// meta
		$return = array_merge((array)$return, array_keys($this->_dynamicFields));
		foreach($this->_metaStructures as $metaStruct)
		{
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}

		return $return;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text_oneliner',$this->text_oneliner,true);
		$criteria->compare('text_short_description',$this->text_short_description,true);
		$criteria->compare('image_logo',$this->image_logo,true);
		if(!empty($this->sdate_started) && !empty($this->edate_started))
		{
			$sTimestamp = strtotime($this->sdate_started);
			$eTimestamp = strtotime("{$this->edate_started} +1 day");
			$criteria->addCondition(sprintf('date_started >= %s AND date_started < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_ended) && !empty($this->edate_ended))
		{
			$sTimestamp = strtotime($this->sdate_ended);
			$eTimestamp = strtotime("{$this->edate_ended} +1 day");
			$criteria->addCondition(sprintf('date_ended >= %s AND date_ended < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_highlight',$this->is_highlight);
		$criteria->compare('json_extra',$this->json_extra,true);
		if(!empty($this->sdate_added) && !empty($this->edate_added))
		{
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified))
		{
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.date_started DESC'),
		));
	}

	public function toApi($params=array())
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'slug' => $this->slug,
			'title' => $this->title,
			'textOneliner' => $this->text_oneliner,
			'textShortDescription' => $this->text_short_description,
			'imageLogo' => $this->image_logo,
			'imageLogoThumbUrl'=>$this->getImageLogoThumbUrl(),
			'imageLogoUrl'=>$this->getImageLogoUrl(),
			'dateStarted' => $this->date_started,
			'fDateStarted'=>$this->renderDateStarted(),
			'dateEnded' => $this->date_ended,
			'fDateEnded'=>$this->renderDateEnded(),
			'isActive' => $this->is_active,
			'isHighlight' => $this->is_highlight,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
		
		);
			
		// many2many
		if(!in_array('-industries', $params) && !empty($this->industries)) 
		{
			foreach($this->industries as $industry)
			{
				$return['industries'][] = $industry->toApi(array('-intake'));
			}
		}
		if(!in_array('-personas', $params) && !empty($this->personas)) 
		{
			foreach($this->personas as $persona)
			{
				$return['personas'][] = $persona->toApi(array('-intake'));
			}
		}
		if(!in_array('-startupStages', $params) && !empty($this->startupStages)) 
		{
			foreach($this->startupStages as $startupStage)
			{
				$return['startupStages'][] = $startupStage->toApi(array('-intake'));
			}
		}
		if(!in_array('-impacts', $params) && !empty($this->impacts)) 
		{
			foreach($this->impacts as $impact)
			{
				$return['impacts'][] = $impact->toApi(array('-intake'));
			}
		}
		if(!in_array('-sdgs', $params) && !empty($this->sdgs)) 
		{
			foreach($this->sdgs as $sdg)
			{
				$return['sdgs'][] = $sdg->toApi(array('-intake'));
			}
		}

		return $return;
	}
	
	//
	// image
	public function getImageLogoUrl()
	{
		if(!empty($this->image_logo))
			return StorageHelper::getUrl($this->image_logo);
	}
	public function getImageLogoThumbUrl($width=100, $height=100)
	{
		if(!empty($this->image_logo))
			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_logo));
	}


	//
	// date
	public function getTimezone()
	{
		return date_default_timezone_get();
	}

	public function renderDateStarted()
	{
		return Html::formatDateTimezone($this->date_started, 'standard', 'standard', '-', $this->getTimezone());
	}
	public function renderDateEnded()
	{
		return Html::formatDateTimezone($this->date_ended, 'standard', 'standard', '-', $this->getTimezone());
	}
	public function renderDateAdded()
	{
		return Html::formatDateTimezone($this->date_added, 'standard', 'standard', '-', $this->getTimezone());
	}
	public function renderDateModified()
	{
		return Html::formatDateTimezone($this->date_modified, 'standard', 'standard', '-', $this->getTimezone());
	}

	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),

			'isActive' => array('condition'=>'t.is_active = 1'),
			'isHighlight' => array('condition'=>'t.is_highlight = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Intake the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * This is invoked before the record is validated.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeValidate() 
	{
		if($this->isNewRecord)
		{
 
			// UUID
			$this->code = ysUtil::generateUUID();	
		}
		else
		{
 
			// UUID
			if(empty($this->code)) $this->code = ysUtil::generateUUID();	
		}

		// todo: for all language filed that is required but data is empty, copy the value from default language so when params.backendLanguages do not include those params.languages, validation error wont throw out

		return parent::beforeValidate();
	}

	protected function afterSave()
	{
	$this->saveInputIndustry();
	$this->saveInputPersona();
	$this->saveInputStartupStage();
	$this->saveInputImpact();
	$this->saveInputSdg();

	$this->setTags($this->tag_backend);
		return parent::afterSave();
	}

	
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if(!empty($this->date_started))
			{
				if(!is_numeric($this->date_started))
				{
					$this->date_started = strtotime($this->date_started);
				}
			}
			if(!empty($this->date_ended))
			{
				if(!is_numeric($this->date_ended))
				{
					$this->date_ended = strtotime($this->date_ended);
				}
			}

			// auto deal with date added and date modified
			if($this->isNewRecord)
			{
				$this->date_added=$this->date_modified=time();
			}
			else
			{
				$this->date_modified=time();
			}
	

			// json
			$this->json_extra = json_encode($this->jsonArray_extra);
			if($this->json_extra == 'null') $this->json_extra = null;

// save as null if empty
					if(empty($this->slug)) $this->slug = null;
						if(empty($this->text_oneliner)) $this->text_oneliner = null;
						if(empty($this->text_short_description)) $this->text_short_description = null;
						if(empty($this->image_logo)) $this->image_logo = null;
						if(empty($this->date_started) && $this->date_started !==0) $this->date_started = null;
						if(empty($this->date_ended) && $this->date_ended !==0) $this->date_ended = null;
						if(empty($this->json_extra)) $this->json_extra = null;
						if(empty($this->date_added) && $this->date_added !==0) $this->date_added = null;
						if(empty($this->date_modified) && $this->date_modified !==0) $this->date_modified = null;
	
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * This is invoked after the record is found.
	 */
	protected function afterFind()
	{
		// boolean
		if($this->is_active != '' || $this->is_active != null) $this->is_active = intval($this->is_active);
		if($this->is_highlight != '' || $this->is_highlight != null) $this->is_highlight = intval($this->is_highlight);

		$this->jsonArray_extra = json_decode($this->json_extra);

		$this->tag_backend = $this->backend->toString();

		foreach($this->industries as $industry) $this->inputIndustries[] = $industry->id;
		foreach($this->personas as $persona) $this->inputPersonas[] = $persona->id;
		foreach($this->startupStages as $startup_stage) $this->inputStartupStages[] = $startup_stage->id;
		foreach($this->impacts as $impact) $this->inputImpacts[] = $impact->id;
		foreach($this->sdgs as $sdg) $this->inputSdgs[] = $sdg->id;

		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array
		(
			

			'backend' => array
			(
				'class' => 'application.yeebase.extensions.taggable-behavior.ETaggableBehavior',
				'tagTable' => 'tag',
				'tagBindingTable' => 'tag2intake',
				'modelTableFk' => 'intake_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Intake',
				'createTagsAutomatically' => true,
			)

		);
	}
	


	/**
	 * These are function for foregin refer usage
	 */
	public function getForeignReferList($isNullable=false, $is4Filter=false)
	{
		$language = Yii::app()->language;		
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');
		$result = Yii::app()->db->createCommand()->select("id as key, title as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}

	public function isCodeExists($code)
	{
		$exists = Intake::model()->find('code=:code', array(':code'=>$code));
		if($exists===null) return false;
		return true;
	}

	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


		
	//
	// industry
	public function getAllIndustriesKey()
	{
		$return = array();
		if(!empty($this->industries))
		{
			foreach($this->industries as $r)
			{
				$return[] = $r->id;
			}
		}
		return $return;
	}

	public function hasIndustry($key)
	{
		if(in_array($key, $this->getAllIndustriesKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function hasNoIndustry($key)
	{
		if(!in_array($key, $this->getAllIndustriesKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function removeIndustry($key)
	{
		if($this->hasIndustry($key))
		{
			$many2many = Industry2Intake::model()->findByAttributes (array('intake_id'=>$this->id, 'industry_id'=>$key));
			if(!empty($many2many)) return $many2many->delete();
		}
		return false;
	}
	
	public function addIndustry($key)
	{
		if($this->hasNoIndustry($key))
		{
			$many2many = new Industry2Intake;
			$many2many->intake_id = $this->id;
			$many2many->industry_id = $key;
			return $many2many->save();
		}
		return false;
	}

	protected function saveInputIndustry()
	{
		// loop thru existing
		foreach($this->industries as $r)
		{
			// remove extra
			if(!in_array($r->id, $this->inputIndustries))
			{
				$this->removeIndustry($r->id);	
			}
		}

		// loop thru each input
		foreach($this->inputIndustries as $input)
		{
			// if currently dont have
			if($this->hasNoIndustry($input))
			{
				$this->addIndustry($input);
			}		
		}
	}

		
	//
	// persona
	public function getAllPersonasKey()
	{
		$return = array();
		if(!empty($this->personas))
		{
			foreach($this->personas as $r)
			{
				$return[] = $r->id;
			}
		}
		return $return;
	}

	public function hasPersona($key)
	{
		if(in_array($key, $this->getAllPersonasKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function hasNoPersona($key)
	{
		if(!in_array($key, $this->getAllPersonasKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function removePersona($key)
	{
		if($this->hasPersona($key))
		{
			$many2many = Persona2Intake::model()->findByAttributes (array('intake_id'=>$this->id, 'persona_id'=>$key));
			if(!empty($many2many)) return $many2many->delete();
		}
		return false;
	}
	
	public function addPersona($key)
	{
		if($this->hasNoPersona($key))
		{
			$many2many = new Persona2Intake;
			$many2many->intake_id = $this->id;
			$many2many->persona_id = $key;
			return $many2many->save();
		}
		return false;
	}

	protected function saveInputPersona()
	{
		// loop thru existing
		foreach($this->personas as $r)
		{
			// remove extra
			if(!in_array($r->id, $this->inputPersonas))
			{
				$this->removePersona($r->id);	
			}
		}

		// loop thru each input
		foreach($this->inputPersonas as $input)
		{
			// if currently dont have
			if($this->hasNoPersona($input))
			{
				$this->addPersona($input);
			}		
		}
	}

		
	//
	// startup_stage
	public function getAllStartupStagesKey()
	{
		$return = array();
		if(!empty($this->startupStages))
		{
			foreach($this->startupStages as $r)
			{
				$return[] = $r->id;
			}
		}
		return $return;
	}

	public function hasStartupStage($key)
	{
		if(in_array($key, $this->getAllStartupStagesKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function hasNoStartupStage($key)
	{
		if(!in_array($key, $this->getAllStartupStagesKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function removeStartupStage($key)
	{
		if($this->hasStartupStage($key))
		{
			$many2many = StartupStage2Intake::model()->findByAttributes (array('intake_id'=>$this->id, 'startup_stage_id'=>$key));
			if(!empty($many2many)) return $many2many->delete();
		}
		return false;
	}
	
	public function addStartupStage($key)
	{
		if($this->hasNoStartupStage($key))
		{
			$many2many = new StartupStage2Intake;
			$many2many->intake_id = $this->id;
			$many2many->startup_stage_id = $key;
			return $many2many->save();
		}
		return false;
	}

	protected function saveInputStartupStage()
	{
		// loop thru existing
		foreach($this->startupStages as $r)
		{
			// remove extra
			if(!in_array($r->id, $this->inputStartupStages))
			{
				$this->removeStartupStage($r->id);	
			}
		}

		// loop thru each input
		foreach($this->inputStartupStages as $input)
		{
			// if currently dont have
			if($this->hasNoStartupStage($input))
			{
				$this->addStartupStage($input);
			}		
		}
	}

		
	//
	// impact
	public function getAllImpactsKey()
	{
		$return = array();
		if(!empty($this->impacts))
		{
			foreach($this->impacts as $r)
			{
				$return[] = $r->id;
			}
		}
		return $return;
	}

	public function hasImpact($key)
	{
		if(in_array($key, $this->getAllImpactsKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function hasNoImpact($key)
	{
		if(!in_array($key, $this->getAllImpactsKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function removeImpact($key)
	{
		if($this->hasImpact($key))
		{
			$many2many = Impact2Intake::model()->findByAttributes (array('intake_id'=>$this->id, 'impact_id'=>$key));
			if(!empty($many2many)) return $many2many->delete();
		}
		return false;
	}
	
	public function addImpact($key)
	{
		if($this->hasNoImpact($key))
		{
			$many2many = new Impact2Intake;
			$many2many->intake_id = $this->id;
			$many2many->impact_id = $key;
			return $many2many->save();
		}
		return false;
	}

	protected function saveInputImpact()
	{
		// loop thru existing
		foreach($this->impacts as $r)
		{
			// remove extra
			if(!in_array($r->id, $this->inputImpacts))
			{
				$this->removeImpact($r->id);	
			}
		}

		// loop thru each input
		foreach($this->inputImpacts as $input)
		{
			// if currently dont have
			if($this->hasNoImpact($input))
			{
				$this->addImpact($input);
			}		
		}
	}

		
	//
	// sdg
	public function getAllSdgsKey()
	{
		$return = array();
		if(!empty($this->sdgs))
		{
			foreach($this->sdgs as $r)
			{
				$return[] = $r->id;
			}
		}
		return $return;
	}

	public function hasSdg($key)
	{
		if(in_array($key, $this->getAllSdgsKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function hasNoSdg($key)
	{
		if(!in_array($key, $this->getAllSdgsKey()))
		{
			return true;
		}
		
		return false;
	}
	
	public function removeSdg($key)
	{
		if($this->hasSdg($key))
		{
			$many2many = Sdg2Intake::model()->findByAttributes (array('intake_id'=>$this->id, 'sdg_id'=>$key));
			if(!empty($many2many)) return $many2many->delete();
		}
		return false;
	}
	
	public function addSdg($key)
	{
		if($this->hasNoSdg($key))
		{
			$many2many = new Sdg2Intake;
			$many2many->intake_id = $this->id;
			$many2many->sdg_id = $key;
			return $many2many->save();
		}
		return false;
	}

	protected function saveInputSdg()
	{
		// loop thru existing
		foreach($this->sdgs as $r)
		{
			// remove extra
			if(!in_array($r->id, $this->inputSdgs))
			{
				$this->removeSdg($r->id);	
			}
		}

		// loop thru each input
		foreach($this->inputSdgs as $input)
		{
			// if currently dont have
			if($this->hasNoSdg($input))
			{
				$this->addSdg($input);
			}		
		}
	}

}
