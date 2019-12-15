<?php


/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
			 * @property integer $id
			 * @property string $username
			 * @property string $social_provider
			 * @property string $social_identifier
			 * @property string $json_social_params
			 * @property string $password
			 * @property string $reset_password_key
			 * @property integer $stat_reset_password_count
			 * @property integer $stat_login_count
			 * @property integer $stat_login_success_count
			 * @property string $last_login_ip
			 * @property integer $date_last_login
			 * @property string $signup_type
			 * @property string $signup_ip
			 * @property integer $is_active
			 * @property integer $date_activated
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Admin $admin
 * @property Member $member
 * @property Member[] $members
 * @property Profile $profile
 * @property Role[] $roles
 * @property UserSession[] $userSessions
 */
 class UserBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_last_login, $edate_last_login;
	public $sdate_activated, $edate_activated;
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, date_activated', 'required'),
			array('stat_reset_password_count, stat_login_count, stat_login_success_count, date_last_login, is_active, date_activated, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>128),
			array('social_provider, reset_password_key', 'length', 'max'=>32),
			array('social_identifier', 'length', 'max'=>64),
			array('last_login_ip, signup_ip', 'length', 'max'=>24),
			array('signup_type', 'length', 'max'=>8),
			array('json_social_params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, social_provider, social_identifier, json_social_params, password, reset_password_key, stat_reset_password_count, stat_login_count, stat_login_success_count, last_login_ip, date_last_login, signup_type, signup_ip, is_active, date_activated, date_added, date_modified, sdate_last_login, edate_last_login, sdate_activated, edate_activated, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'admin' => array(self::HAS_ONE, 'Admin', 'user_id'),
			'member' => array(self::HAS_ONE, 'Member', 'user_id'),
			'members' => array(self::HAS_MANY, 'Member', 'username'),
			'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
			'roles' => array(self::MANY_MANY, 'Role', 'role2user(user_id, role_id)'),
			'userSessions' => array(self::HAS_MANY, 'UserSession', 'user_id'),

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
		'social_provider' => Yii::t('app', 'Social Provider'),
		'social_identifier' => Yii::t('app', 'Social Identifier'),
		'json_social_params' => Yii::t('app', 'Json Social Params'),
		'password' => Yii::t('app', 'Password'),
		'reset_password_key' => Yii::t('app', 'Reset Password Key'),
		'stat_reset_password_count' => Yii::t('app', 'Stat Reset Password Count'),
		'stat_login_count' => Yii::t('app', 'Stat Login Count'),
		'stat_login_success_count' => Yii::t('app', 'Stat Login Success Count'),
		'last_login_ip' => Yii::t('app', 'Last Login Ip'),
		'date_last_login' => Yii::t('app', 'Date Last Login'),
		'signup_type' => Yii::t('app', 'Signup Type'),
		'signup_ip' => Yii::t('app', 'Signup Ip'),
		'is_active' => Yii::t('app', 'Is Active'),
		'date_activated' => Yii::t('app', 'Date Activated'),
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('social_provider',$this->social_provider,true);
		$criteria->compare('social_identifier',$this->social_identifier,true);
		$criteria->compare('json_social_params',$this->json_social_params,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('reset_password_key',$this->reset_password_key,true);
		$criteria->compare('stat_reset_password_count',$this->stat_reset_password_count);
		$criteria->compare('stat_login_count',$this->stat_login_count);
		$criteria->compare('stat_login_success_count',$this->stat_login_success_count);
		$criteria->compare('last_login_ip',$this->last_login_ip,true);
		if(!empty($this->sdate_last_login) && !empty($this->edate_last_login))
		{
			$sTimestamp = strtotime($this->sdate_last_login);
			$eTimestamp = strtotime("{$this->edate_last_login} +1 day");
			$criteria->addCondition(sprintf('date_last_login >= %s AND date_last_login < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('signup_type',$this->signup_type);
		$criteria->compare('signup_ip',$this->signup_ip,true);
		$criteria->compare('is_active',$this->is_active);
		if(!empty($this->sdate_activated) && !empty($this->edate_activated))
		{
			$sTimestamp = strtotime($this->sdate_activated);
			$eTimestamp = strtotime("{$this->edate_activated} +1 day");
			$criteria->addCondition(sprintf('date_activated >= %s AND date_activated < %s', $sTimestamp, $eTimestamp));
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

	public function toApi($params='')
	{
		$return = array(
			'id' => $this->id,
			'username' => $this->username,
			'socialProvider' => $this->social_provider,
			'socialIdentifier' => $this->social_identifier,
			'jsonSocialParams' => $this->json_social_params,
			'password' => $this->password,
			'resetPasswordKey' => $this->reset_password_key,
			'statResetPasswordCount' => $this->stat_reset_password_count,
			'statLoginCount' => $this->stat_login_count,
			'statLoginSuccessCount' => $this->stat_login_success_count,
			'lastLoginIp' => $this->last_login_ip,
			'dateLastLogin' => $this->date_last_login,
			'fDateLastLogin'=>$this->renderDateLastLogin(),
			'signupType' => $this->signup_type,
			'signupIp' => $this->signup_ip,
			'isActive' => $this->is_active,
			'dateActivated' => $this->date_activated,
			'fDateActivated'=>$this->renderDateActivated(),
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

	public function renderDateLastLogin()
	{
		return Html::formatDateTimezone($this->date_last_login, 'standard', 'standard', '-', $this->getTimezone());
	}
	public function renderDateActivated()
	{
		return Html::formatDateTimezone($this->date_activated, 'standard', 'standard', '-', $this->getTimezone());
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
	 * @return User the static model class
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
			if(!empty($this->date_last_login))
			{
				if(!is_numeric($this->date_last_login))
				{
					$this->date_last_login = strtotime($this->date_last_login);
				}
			}
			if(!empty($this->date_activated))
			{
				if(!is_numeric($this->date_activated))
				{
					$this->date_activated = strtotime($this->date_activated);
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
	 * These are function for enum usage
	 */
	public function getEnumSignupType($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumSignupType(''));
		
		$result[] = array('code'=>'default', 'title'=>$this->formatEnumSignupType('default'));
		$result[] = array('code'=>'facebook', 'title'=>$this->formatEnumSignupType('facebook'));
		$result[] = array('code'=>'google', 'title'=>$this->formatEnumSignupType('google'));
		$result[] = array('code'=>'admin', 'title'=>$this->formatEnumSignupType('admin'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumSignupType($code)
	{
		switch($code)
		{
			
			case 'default': {return Yii::t('app', 'Default'); break;}
			
			case 'facebook': {return Yii::t('app', 'Facebook'); break;}
			
			case 'google': {return Yii::t('app', 'Google'); break;}
			
			case 'admin': {return Yii::t('app', 'Admin'); break;}
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
		$result = Yii::app()->db->createCommand()->select("id as key, username as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}



}
