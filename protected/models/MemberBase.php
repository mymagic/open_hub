<?php


/**
 * This is the model class for table "member".
 *
 * The followings are the available columns in table 'member':
		 * @property integer $user_id
		 * @property string $username
		 * @property string $emergency_contact_name
		 * @property string $emergency_contact_no
		 * @property string $emergency_contact_relationship
		 * @property integer $date_joined
		 * @property integer $date_added
		 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $username0
 */
 class MemberBase extends ActiveRecord
{
	public $uploadPath;
	
	public $sdate_joined, $edate_joined;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'member';

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
		return 'member';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, username, date_joined', 'required'),
			array('user_id, date_joined, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('username, emergency_contact_name, emergency_contact_relationship', 'length', 'max'=>128),
			array('emergency_contact_no', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, username, emergency_contact_name, emergency_contact_no, emergency_contact_relationship, date_joined, date_added, date_modified, sdate_joined, edate_joined, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'username0' => array(self::BELONGS_TO, 'User', 'username'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		'user_id' => Yii::t('app', 'User'),
		'username' => Yii::t('app', 'Username'),
		'emergency_contact_name' => Yii::t('app', 'Emergency Contact Name'),
		'emergency_contact_no' => Yii::t('app', 'Emergency Contact No'),
		'emergency_contact_relationship' => Yii::t('app', 'Emergency Contact Relationship'),
		'date_joined' => Yii::t('app', 'Date Joined'),
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('emergency_contact_name',$this->emergency_contact_name,true);
		$criteria->compare('emergency_contact_no',$this->emergency_contact_no,true);
		$criteria->compare('emergency_contact_relationship',$this->emergency_contact_relationship,true);
		if(!empty($this->sdate_joined) && !empty($this->edate_joined))
		{
			$sTimestamp = strtotime($this->sdate_joined);
			$eTimestamp = strtotime("{$this->edate_joined} +1 day");
			$criteria->addCondition(sprintf('date_joined >= %s AND date_joined < %s', $sTimestamp, $eTimestamp));
		}
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
	 * @return Member the static model class
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
			if(!empty($this->date_joined))
			{
				if(!is_numeric($this->date_joined))
				{
					$this->date_joined = strtotime($this->date_joined);
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
			
			return true;
		}
		else
		{
			return false;
		}
	}




}
