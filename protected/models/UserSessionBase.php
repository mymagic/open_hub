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
 * This is the model class for table "user_session".
 *
 * The followings are the available columns in table 'user_session':
		 * @property string $id
		 * @property string $session_code
		 * @property integer $user_id
		 * @property integer $date_login
		 * @property integer $date_last_heartbeat
		 * @property integer $date_added
		 * @property integer $date_modified
 */
 class UserSessionBase extends ActiveRecordBase
{
	public $uploadPath;
	
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'user_session';
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_code, user_id, date_login, date_last_heartbeat', 'required'),
			array('user_id, date_login, date_last_heartbeat, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('session_code', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, session_code, user_id, date_login, date_last_heartbeat, date_added, date_modified', 'safe', 'on'=>'search'),
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
		return array(
		'id' => Yii::t('app', 'ID'),
		'session_code' => Yii::t('app', 'Session Code'),
		'user_id' => Yii::t('app', 'User'),
		'date_login' => Yii::t('app', 'Date Login'),
		'date_last_heartbeat' => Yii::t('app', 'Date Last Heartbeat'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('session_code',$this->session_code,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('date_login',$this->date_login);
		$criteria->compare('date_last_heartbeat',$this->date_last_heartbeat);
		$criteria->compare('date_added',$this->date_added);
		$criteria->compare('date_modified',$this->date_modified);

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
	 * @return UserSession the static model class
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
			if(!empty($this->date_login))
			{
				if(!is_numeric($this->date_login))
				{
					$this->date_login = strtotime($this->date_login);
				}
			}
			if(!empty($this->date_last_heartbeat))
			{
				if(!is_numeric($this->date_last_heartbeat))
				{
					$this->date_last_heartbeat = strtotime($this->date_last_heartbeat);
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
