<?php


/**
 * This is the model class for table "sample_zone".
 *
 * The followings are the available columns in table 'sample_zone':
			 * @property integer $id
			 * @property string $code
			 * @property string $label
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Sample[] $samples
 */
 class SampleZoneBase extends ActiveRecordBase
{
	public $uploadPath;
	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'sample_zone';

		if($this->scenario == "search")
		{
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
		return 'sample_zone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, label', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>32),
			array('label', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, label, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'samples' => array(self::HAS_MANY, 'Sample', 'sample_zone_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		'id' => Yii::t('app', 'ID'),
		'code' => Yii::t('app', 'Code'),
		'label' => Yii::t('app', 'Label'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);
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
		$criteria->compare('label',$this->label,true);
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

		));
	}
	
	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SampleZone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		$result = Yii::app()->db->createCommand()->select("code as key, label as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}

	public function isCodeExists($code)
	{
		$exists = SampleZone::model()->find('code=:code', array(':code'=>$code));
		if($exists===null) return false;
		return true;
	}
}
