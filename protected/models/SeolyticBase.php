<?php


/**
 * This is the model class for table "seolytic".
 *
 * The followings are the available columns in table 'seolytic':
			 * @property integer $id
			 * @property string $path_pattern
			 * @property string $title_en
			 * @property string $title_ms
			 * @property string $title_zh
			 * @property string $description_en
			 * @property string $description_ms
			 * @property string $description_zh
			 * @property string $js_header
			 * @property string $js_footer
			 * @property string $css_header
			 * @property string $json_meta
			 * @property string $json_extra
			 * @property integer $is_active
			 * @property double $ordering
			 * @property integer $date_added
			 * @property integer $date_modified
 */
 class SeolyticBase extends ActiveRecordBase
{
	public $uploadPath;

	
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
		$this->ordering = $this->count()+1;		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seolytic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('path_pattern', 'required'),
			array('is_active, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('ordering', 'numerical'),
			array('path_pattern, title_en, title_ms, title_zh, description_en, description_ms, description_zh', 'length', 'max'=>255),
			array('js_header, js_footer, css_header, json_meta, json_extra', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, path_pattern, title_en, title_ms, title_zh, description_en, description_ms, description_zh, js_header, js_footer, css_header, json_meta, json_extra, is_active, ordering, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'path_pattern' => Yii::t('app', 'Path Pattern'),
		'title_en' => Yii::t('app', 'Title [English]'),
		'title_ms' => Yii::t('app', 'Title [Bahasa]'),
		'title_zh' => Yii::t('app', 'Title [中文]'),
		'description_en' => Yii::t('app', 'Description [English]'),
		'description_ms' => Yii::t('app', 'Description [Bahasa]'),
		'description_zh' => Yii::t('app', 'Description [中文]'),
		'js_header' => Yii::t('app', 'Js Header'),
		'js_footer' => Yii::t('app', 'Js Footer'),
		'css_header' => Yii::t('app', 'Css Header'),
		'json_meta' => Yii::t('app', 'Json Meta'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'is_active' => Yii::t('app', 'Is Active'),
		'ordering' => Yii::t('app', 'Ordering'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
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
		$criteria->compare('path_pattern',$this->path_pattern,true);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('title_ms',$this->title_ms,true);
		$criteria->compare('title_zh',$this->title_zh,true);
		$criteria->compare('description_en',$this->description_en,true);
		$criteria->compare('description_ms',$this->description_ms,true);
		$criteria->compare('description_zh',$this->description_zh,true);
		$criteria->compare('js_header',$this->js_header,true);
		$criteria->compare('js_footer',$this->js_footer,true);
		$criteria->compare('css_header',$this->css_header,true);
		$criteria->compare('json_meta',$this->json_meta,true);
		$criteria->compare('json_extra',$this->json_extra,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('ordering',$this->ordering);
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
			'sort' => array('defaultOrder' => 't.ordering ASC'),
		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'pathPattern' => $this->path_pattern,
			'titleEn' => $this->title_en,
			'titleMs' => $this->title_ms,
			'titleZh' => $this->title_zh,
			'descriptionEn' => $this->description_en,
			'descriptionMs' => $this->description_ms,
			'descriptionZh' => $this->description_zh,
			'jsHeader' => $this->js_header,
			'jsFooter' => $this->js_footer,
			'cssHeader' => $this->css_header,
			'jsonMeta' => $this->json_meta,
			'jsonExtra' => $this->json_extra,
			'isActive' => $this->is_active,
			'ordering' => $this->ordering,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
		
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
	 * @return Seolytic the static model class
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
					if(empty($this->title_en)) $this->title_en = null;
						if(empty($this->title_ms)) $this->title_ms = null;
						if(empty($this->title_zh)) $this->title_zh = null;
						if(empty($this->description_en)) $this->description_en = null;
						if(empty($this->description_ms)) $this->description_ms = null;
						if(empty($this->description_zh)) $this->description_zh = null;
						if(empty($this->js_header)) $this->js_header = null;
						if(empty($this->js_footer)) $this->js_footer = null;
						if(empty($this->css_header)) $this->css_header = null;
						if(empty($this->json_meta)) $this->json_meta = null;
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




		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array
		(
			
		);
	}
	




	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
