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

/**
 * This is the model class for table "milestone".
 *
 * The followings are the available columns in table 'milestone':
			 * @property integer $id
			 * @property string $username
			 * @property integer $organization_id
			 * @property string $preset_code
			 * @property string $title
			 * @property string $text_short_description
			 * @property string $json_target
			 * @property string $json_value
			 * @property string $json_extra
			 * @property integer $is_star
			 * @property integer $is_active
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property integer $is_disclosed
			 * @property string $source
 *
 * The followings are the available model relations:
 * @property Organization $organization
 * @property User $username0
 */
 class MilestoneBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;

	// json
	public $jsonArray_target;
	public $jsonArray_value;
	public $jsonArray_extra;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

		if($this->scenario == "search")
		{
			$this->is_star = null;
			$this->is_active = null;
			$this->is_disclosed = null;
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
		return 'milestone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
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
			'username0' => array(self::BELONGS_TO, 'User', 'username'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'username' => Yii::t('app', 'Username'),
		'organization_id' => Yii::t('app', 'Organization'),
		'preset_code' => Yii::t('app', 'Preset Code'),
		'title' => Yii::t('app', 'Title'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'json_target' => Yii::t('app', 'Json Target'),
		'json_value' => Yii::t('app', 'Json Value'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'is_star' => Yii::t('app', 'Is Star'),
		'is_active' => Yii::t('app', 'Is Active'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'is_disclosed' => Yii::t('app', 'Is Disclosed'),
		'source' => Yii::t('app', 'Source'),
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('organization_id',$this->organization_id);
		$criteria->compare('preset_code',$this->preset_code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text_short_description',$this->text_short_description,true);
		$criteria->compare('json_target',$this->json_target,true);
		$criteria->compare('json_value',$this->json_value,true);
		$criteria->compare('json_extra',$this->json_extra,true);
		$criteria->compare('is_star',$this->is_star);
		$criteria->compare('is_active',$this->is_active);
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
		$criteria->compare('is_disclosed',$this->is_disclosed);
		$criteria->compare('source',$this->source,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

		));
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
			'jsonExtra' => $this->json_extra,
			'isStar' => $this->is_star,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
			'isDisclosed' => $this->is_disclosed,
			'source' => $this->source,
		
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

			'isStar' => array('condition'=>'t.is_star = 1'),
			'isActive' => array('condition'=>'t.is_active = 1'),
			'isDisclosed' => array('condition'=>'t.is_disclosed = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Milestone the static model class
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
	

			// json
			$this->json_target = json_encode($this->jsonArray_target);
			if($this->json_target == 'null') $this->json_target = null;
			$this->json_value = json_encode($this->jsonArray_value);
			if($this->json_value == 'null') $this->json_value = null;
			$this->json_extra = json_encode($this->jsonArray_extra);
			if($this->json_extra == 'null') $this->json_extra = null;

// save as null if empty
					if(empty($this->organization_id) && $this->organization_id !=0) $this->organization_id = null;
						if(empty($this->text_short_description)) $this->text_short_description = null;
						if(empty($this->json_target)) $this->json_target = null;
						if(empty($this->json_value)) $this->json_value = null;
						if(empty($this->json_extra)) $this->json_extra = null;
						if(empty($this->source)) $this->source = null;
	
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
		if($this->is_star != '' || $this->is_star != null) $this->is_star = intval($this->is_star);
		if($this->is_active != '' || $this->is_active != null) $this->is_active = intval($this->is_active);
		if($this->is_disclosed != '' || $this->is_disclosed != null) $this->is_disclosed = intval($this->is_disclosed);

		$this->jsonArray_target = json_decode($this->json_target);
		$this->jsonArray_value = json_decode($this->json_value);
		$this->jsonArray_extra = json_decode($this->json_extra);



		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array
		(
			
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


	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
