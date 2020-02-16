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

class Member extends MemberBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public $username, $full_name, $is_active;
	public $gender, $mobile_no;
	public $text_admin_remark;
	public $signup_ip, $last_login_ip;
	
	// magic connect
	public $first_name, $last_name;
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'portfolio' => array(self::HAS_ONE, 'Portfolio', array('user_id'=>'user_id')),
		);
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required', 'except'=>array('create', 'createConnect')),
			array('user_id, date_joined, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('text_admin_remark, log_admin_remark', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('username, full_name, is_active, mobile_no, user_id, log_admin_remark, date_joined, date_added, date_modified, sdate_joined, edate_joined, sdate_added, edate_added, sdate_modified, edate_modified, signup_ip, last_login_ip', 'safe', 'on'=>'search'),
			
			// create
			array('username, full_name', 'required', 'on'=>'create'),
			array('username', 'unique', 'allowEmpty'=>false, 'className'=>'User', 'attributeName'=>'username', 'caseSensitive'=>false, 'on'=>array('create')),
			array('username', 'email', 'allowEmpty'=>false, 'checkMX'=>true, 'on'=>array('create')),
			
			// magic connect
			// createConnect
			array('username, first_name, last_name', 'required', 'on'=>'createConnect'),
			array('username', 'unique', 'allowEmpty'=>false, 'className'=>'User', 'attributeName'=>'username', 'caseSensitive'=>false, 'on'=>array('createConnect')),
			array('username', 'email', 'allowEmpty'=>false, 'checkMX'=>true, 'on'=>array('createConnect')),
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'user_id' => Yii::t('app', 'User'),
		'username' => Yii::t('app', 'Email'),
		'log_admin_remark' => Yii::t('app', 'Admin Remark'),
		'date_joined' => Yii::t('app', 'Date Joined'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);
	}
	
	public function search($mode='')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('user', 'user.profile');
		$criteria->together = true;
		
		$criteria->compare('user.username', $this->username, true);
		$criteria->compare('user.is_active', $this->is_active, true);
		$criteria->compare('profile.full_name', $this->full_name, true);
		$criteria->compare('user.signup_ip', $this->signup_ip, true);
		$criteria->compare('user.last_login_ip', $this->last_login_ip, true);
		
		$criteria->compare('t.user_id',$this->user_id);
		
		$criteria->compare('t.log_admin_remark',$this->log_admin_remark,true);
		if(!empty($this->sdate_joined) && !empty($this->edate_joined))
		{
			$sTimestamp = strtotime($this->sdate_joined);
			$eTimestamp = strtotime("{$this->edate_joined} +1 day");
			$criteria->addCondition(sprintf('t.date_joined >= %s AND t.date_joined < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_added) && !empty($this->edate_added))
		{
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('t.date_added >= %s AND t.date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified))
		{
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('t.date_modified >= %s AND t.date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'user.date_last_login DESC, t.username ASC',
			),
		));
	}

	public function getEmail()
	{
		return $this->user->username;
	}
	
	public function getMobileNo()
	{
		return $this->user->profile->mobile_no;
	}
	
	public function canReceiveSms()
	{
		// todo: check if user flag accept sms notification on
		return false;
		if($this->user->profile->isMobileNumberVerified() && !empty($this->getMobileNo())) return true;
		return false;
	}
	
	public function canReceiveEmail()
	{
		return true;
	}
	
	public function canReceivePush()
	{
		if(!empty($this->getPrimaryDevice())) return true;
		return false;
	}
	
	public function getPrimaryDevice()
	{
		return false;
		$tmps = $this->user->devices(array('scopes'=>array('isPrimary')));
		if(!empty($tmps) && !empty($tmps[0])) return $tmps[0];
	}
	
	public function username2obj($username)
	{
		$member = Member::model()->find('t.username=:username', array(':username'=>$username));
		if(!empty($member))
		{
			return $member;
		}
	}
	
	public function toApi($params='')
	{
		$return = array(
			'userId'=>$this->user_id,
			'username'=>$this->username,
			'fGetPubNubChannelId'=>$this->getPubNubChannelId(),
		);
		
		if(!in_array('-user', $params)) $return['user'] = $this->user->toApi();
		return $return;
	}

}
