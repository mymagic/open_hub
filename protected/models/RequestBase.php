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
 * This is the model class for table "request".
 *
 * The followings are the available columns in table 'request':
			 * @property integer $id
			 * @property integer $user_id
			 * @property string $type_code
			 * @property string $title
			 * @property string $status
			 * @property string $json_data
			 * @property string $json_extra
			 * @property integer $is_active
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $user
 */
 class RequestBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;

	// json
	public $jsonArray_extra;
	public $jsonArray_data;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();
		// meta
		$this->initMetaStructure($this->tableName());

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
		return 'request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_code, title', 'required'),
			array('user_id, is_active, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('type_code', 'length', 'max'=>64),
			array('title', 'length', 'max'=>255),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type_code, title, status, json_data, json_extra, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),

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
		'user_id' => Yii::t('app', 'User'),
		'type_code' => Yii::t('app', 'Type Code'),
		'title' => Yii::t('app', 'Title'),
		'status' => Yii::t('app', 'Status'),
		'json_data' => Yii::t('app', 'Json Data'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'is_active' => Yii::t('app', 'Is Active'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);


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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type_code',$this->type_code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('json_data',$this->json_data,true);
		$criteria->compare('json_extra',$this->json_extra,true);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'userId' => $this->user_id,
			'typeCode' => $this->type_code,
			'title' => $this->title,
			'status' => $this->status,
			'jsonData' => $this->json_data,
			'jsonExtra' => $this->json_extra,
			'isActive' => $this->is_active,
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
	 * @return Request the static model class
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
			$this->json_extra = json_encode($this->jsonArray_extra);
			if($this->json_extra == 'null') $this->json_extra = null;
			$this->json_data = json_encode($this->jsonArray_data);
			if($this->json_data == 'null') $this->json_data = null;

// save as null if empty
					if(empty($this->user_id) && $this->user_id !=0) $this->user_id = null;
						if(empty($this->status)) $this->status = null;
						if(empty($this->json_data)) $this->json_data = null;
						if(empty($this->json_extra)) $this->json_extra = null;
	
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

		$this->jsonArray_extra = json_decode($this->json_extra);
		$this->jsonArray_data = json_decode($this->json_data);



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
		
		$result[] = array('code'=>'new', 'title'=>$this->formatEnumStatus('new'));
		$result[] = array('code'=>'pending', 'title'=>$this->formatEnumStatus('pending'));
		$result[] = array('code'=>'processing', 'title'=>$this->formatEnumStatus('processing'));
		$result[] = array('code'=>'success', 'title'=>$this->formatEnumStatus('success'));
		$result[] = array('code'=>'cancel', 'title'=>$this->formatEnumStatus('cancel'));
		$result[] = array('code'=>'fail', 'title'=>$this->formatEnumStatus('fail'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumStatus($code)
	{
		switch($code)
		{
			
			case 'new': {return Yii::t('app', 'New'); break;}
			
			case 'pending': {return Yii::t('app', 'Pending'); break;}
			
			case 'processing': {return Yii::t('app', 'Processing'); break;}
			
			case 'success': {return Yii::t('app', 'Success'); break;}
			
			case 'cancel': {return Yii::t('app', 'Cancel'); break;}
			
			case 'fail': {return Yii::t('app', 'Fail'); break;}
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
