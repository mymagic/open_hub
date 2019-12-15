<?php


/**
 * This is the model class for table "organization_status".
 *
 * The followings are the available columns in table 'organization_status':
			 * @property integer $id
			 * @property integer $organization_id
			 * @property integer $date_reported
			 * @property string $status
			 * @property string $source
			 * @property string $text_note
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property integer $is_active
 *
 * The followings are the available model relations:
 * @property Organization $organization
 */
 class OrganizationStatusBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_reported, $edate_reported;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

		if($this->scenario == "search")
		{
			$this->is_active = null;
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
		return 'organization_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organization_id', 'required'),
			array('organization_id, date_reported, date_added, date_modified, is_active', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('source', 'length', 'max'=>100),
			array('text_note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, organization_id, date_reported, status, source, text_note, date_added, date_modified, is_active, sdate_reported, edate_reported, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'organization_id' => Yii::t('app', 'Organization'),
		'date_reported' => Yii::t('app', 'Date Reported'),
		'status' => Yii::t('app', 'Status'),
		'source' => Yii::t('app', 'Source'),
		'text_note' => Yii::t('app', 'Text Note'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'is_active' => Yii::t('app', 'Is Active'),
		);



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
		$criteria->compare('organization_id',$this->organization_id);
		if(!empty($this->sdate_reported) && !empty($this->edate_reported))
		{
			$sTimestamp = strtotime($this->sdate_reported);
			$eTimestamp = strtotime("{$this->edate_reported} +1 day");
			$criteria->addCondition(sprintf('date_reported >= %s AND date_reported < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('status',$this->status);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('text_note',$this->text_note,true);
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
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'organizationId' => $this->organization_id,
			'dateReported' => $this->date_reported,
			'fDateReported'=>$this->renderDateReported(),
			'status' => $this->status,
			'source' => $this->source,
			'textNote' => $this->text_note,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
			'isActive' => $this->is_active,
		
		);
			
		// many2many

		return $return;
	}
	
	//
	// image

	//
	// date
	public function getTimezone()
	{
		return date_default_timezone_get();
	}

	public function renderDateReported()
	{
		return Html::formatDateTimezone($this->date_reported, 'standard', 'standard', '-', $this->getTimezone());
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

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrganizationStatus the static model class
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
		}
		else
		{
		}

		// todo: for all language filed that is required but data is empty, copy the value from default language so when params.backendLanguages do not include those params.languages, validation error wont throw out

		return parent::beforeValidate();
	}

	protected function afterSave()
	{

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
			if(!empty($this->date_reported))
			{
				if(!is_numeric($this->date_reported))
				{
					$this->date_reported = strtotime($this->date_reported);
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
	


// save as null if empty
					if(empty($this->date_reported) && $this->date_reported !==0) $this->date_reported = null;
						if(empty($this->status)) $this->status = null;
						if(empty($this->source)) $this->source = null;
						if(empty($this->text_note)) $this->text_note = null;
	
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




		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array
		(
			
		);
	}
	
	/**
	 * These are function for enum usage
	 */
	public function getEnumStatus($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumStatus(''));
		
		$result[] = array('code'=>'active', 'title'=>$this->formatEnumStatus('active'));
		$result[] = array('code'=>'inactive', 'title'=>$this->formatEnumStatus('inactive'));
		$result[] = array('code'=>'exited', 'title'=>$this->formatEnumStatus('exited'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumStatus($code)
	{
		switch($code)
		{
			
			case 'active': {return Yii::t('app', 'Active'); break;}
			
			case 'inactive': {return Yii::t('app', 'Inactive'); break;}
			
			case 'exited': {return Yii::t('app', 'Exited'); break;}
			default: {return ''; break;}
		}
	}
	 


	/**
	 * These are function for foregin refer usage
	 */
	public function getForeignReferList($isNullable=false, $is4Filter=false)
	{
		$language = Yii::app()->language;		
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');
		$result = Yii::app()->db->createCommand()->select("id as key, status as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}


	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
