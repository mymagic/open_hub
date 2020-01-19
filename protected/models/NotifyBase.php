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
 * This is the model class for table "notify".
 *
 * The followings are the available columns in table 'notify':
			 * @property string $id
			 * @property string $message
			 * @property string $json_payload
			 * @property string $priority
			 * @property string $sender_type
			 * @property integer $sender_id
			 * @property string $receiver_type
			 * @property integer $receiver_id
			 * @property integer $is_sent
			 * @property integer $is_read
			 * @property integer $date_sent
			 * @property integer $date_read
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
 */
 class NotifyBase extends ActiveRecordBase
{
	public $uploadPath;
	
	public $sdate_sent, $edate_sent;
	public $sdate_read, $edate_read;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;

	// json
	public $jsonArray_extra, $title, $content, $hasEmail, $hasPush, $hasSms, $sentEmail, $sentPush, $sentSms, $receiverFullName, $receiverEmail, $receiverMobileNo, $receiverDeviceId, $receiverDeviceToken, $receiverDeviceType;
	public $jsonArray_payload;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'notify';

		if($this->scenario == "search")
		{
			$this->is_sent = null;
			$this->is_read = null;
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
		return 'notify';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'required'),
			array('sender_id, receiver_id, is_sent, is_read, date_sent, date_read, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'max'=>500),
			array('priority', 'length', 'max'=>1),
			array('sender_type, receiver_type', 'length', 'max'=>24),
			array('json_payload', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, message, json_payload, priority, sender_type, sender_id, receiver_type, receiver_id, is_sent, is_read, date_sent, date_read, json_extra, date_added, date_modified, sdate_sent, edate_sent, sdate_read, edate_read, sdate_added, edate_added, sdate_modified, edate_modified, title, content, hasEmail, hasPush, hasSms, sentEmail, sentPush, sentSms, receiverFullName, receiverEmail, receiverMobileNo, receiverDeviceId, receiverDeviceToken, receiverDeviceType', 'safe', 'on'=>'search'),
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
		'message' => Yii::t('app', 'Message'),
		'json_payload' => Yii::t('app', 'Json Payload'),
		'priority' => Yii::t('app', 'Priority'),
		'sender_type' => Yii::t('app', 'Sender Type'),
		'sender_id' => Yii::t('app', 'Sender'),
		'receiver_type' => Yii::t('app', 'Receiver Type'),
		'receiver_id' => Yii::t('app', 'Receiver'),
		'is_sent' => Yii::t('app', 'Is Sent'),
		'is_read' => Yii::t('app', 'Is Read'),
		'date_sent' => Yii::t('app', 'Date Sent'),
		'date_read' => Yii::t('app', 'Date Read'),
		'json_extra' => Yii::t('app', 'Json Extra'),
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
		$criteria->compare('message',$this->message,true);
		$criteria->compare('json_payload',$this->json_payload,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('sender_type',$this->sender_type);
		$criteria->compare('sender_id',$this->sender_id);
		$criteria->compare('receiver_type',$this->receiver_type);
		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('is_sent',$this->is_sent);
		$criteria->compare('is_read',$this->is_read);
		if(!empty($this->sdate_sent) && !empty($this->edate_sent))
		{
			$sTimestamp = strtotime($this->sdate_sent);
			$eTimestamp = strtotime("{$this->edate_sent} +1 day");
			$criteria->addCondition(sprintf('date_sent >= %s AND date_sent < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_read) && !empty($this->edate_read))
		{
			$sTimestamp = strtotime($this->sdate_read);
			$eTimestamp = strtotime("{$this->edate_read} +1 day");
			$criteria->addCondition(sprintf('date_read >= %s AND date_read < %s', $sTimestamp, $eTimestamp));
		}
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

		));
	}
	
	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),
			'isSent' => array('condition'=>'t.is_sent = 1'),
			'isRead' => array('condition'=>'t.is_read = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notify the static model class
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
			if(!empty($this->date_sent))
			{
				if(!is_numeric($this->date_sent))
				{
					$this->date_sent = strtotime($this->date_sent);
				}
			}
			if(!empty($this->date_read))
			{
				if(!is_numeric($this->date_read))
				{
					$this->date_read = strtotime($this->date_read);
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
			$this->jsonArray_extra->title = $this->title;
			$this->jsonArray_extra->content = $this->content;
			$this->jsonArray_extra->hasEmail = $this->hasEmail;
			$this->jsonArray_extra->hasPush = $this->hasPush;
			$this->jsonArray_extra->hasSms = $this->hasSms;
			$this->jsonArray_extra->sentEmail = $this->sentEmail;
			$this->jsonArray_extra->sentPush = $this->sentPush;
			$this->jsonArray_extra->sentSms = $this->sentSms;
			$this->jsonArray_extra->receiverFullName = $this->receiverFullName;
			$this->jsonArray_extra->receiverEmail = $this->receiverEmail;
			$this->jsonArray_extra->receiverMobileNo = $this->receiverMobileNo;
			$this->jsonArray_extra->receiverDeviceId = $this->receiverDeviceId;
			$this->jsonArray_extra->receiverDeviceToken = $this->receiverDeviceToken;
			$this->jsonArray_extra->receiverDeviceType = $this->receiverDeviceType;
			$this->json_extra = json_encode($this->jsonArray_extra);
			if($this->json_extra == 'null') $this->json_extra = null;

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
	
		$this->jsonArray_extra = json_decode($this->json_extra);
		$this->title = $this->jsonArray_extra->title;
		$this->content = $this->jsonArray_extra->content;
		$this->hasEmail = $this->jsonArray_extra->hasEmail;
		$this->hasPush = $this->jsonArray_extra->hasPush;
		$this->hasSms = $this->jsonArray_extra->hasSms;
		$this->sentEmail = $this->jsonArray_extra->sentEmail;
		$this->sentPush = $this->jsonArray_extra->sentPush;
		$this->sentSms = $this->jsonArray_extra->sentSms;
		$this->receiverFullName = $this->jsonArray_extra->receiverFullName;
		$this->receiverEmail = $this->jsonArray_extra->receiverEmail;
		$this->receiverMobileNo = $this->jsonArray_extra->receiverMobileNo;
		$this->receiverDeviceId = $this->jsonArray_extra->receiverDeviceId;
		$this->receiverDeviceToken = $this->jsonArray_extra->receiverDeviceToken;
		$this->receiverDeviceType = $this->jsonArray_extra->receiverDeviceType;


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
	public function getEnumSenderType($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumSenderType(''));
		
		$result[] = array('code'=>'system', 'title'=>$this->formatEnumSenderType('system'));
		$result[] = array('code'=>'member', 'title'=>$this->formatEnumSenderType('member'));
		$result[] = array('code'=>'owner', 'title'=>$this->formatEnumSenderType('owner'));
		$result[] = array('code'=>'rider', 'title'=>$this->formatEnumSenderType('rider'));
		$result[] = array('code'=>'admin', 'title'=>$this->formatEnumSenderType('admin'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumSenderType($code)
	{
		switch($code)
		{
			
			case 'system': {return Yii::t('app', 'System'); break;}
			
			case 'member': {return Yii::t('app', 'Member'); break;}
			
			case 'organization': {return Yii::t('app', 'Organization'); break;}
			
			case 'admin': {return Yii::t('app', 'Admin'); break;}
			default: {return ''; break;}
		}
	}
	public function getEnumReceiverType($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumReceiverType(''));
		
		$result[] = array('code'=>'system', 'title'=>$this->formatEnumReceiverType('system'));
		$result[] = array('code'=>'member', 'title'=>$this->formatEnumReceiverType('member'));
		$result[] = array('code'=>'organization', 'title'=>$this->formatEnumReceiverType('organization'));
		$result[] = array('code'=>'admin', 'title'=>$this->formatEnumReceiverType('admin'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumReceiverType($code)
	{
		switch($code)
		{
			
			case 'system': {return Yii::t('app', 'System'); break;}
			
			case 'member': {return Yii::t('app', 'Member'); break;}
			
			case 'organization': {return Yii::t('app', 'Organization'); break;}
			
			case 'admin': {return Yii::t('app', 'Admin'); break;}
			default: {return ''; break;}
		}
	}
	 


	/**
	 * These are function for foregin refer usage
	 */
	public function getForeignReferList($isNullable=false, $is4Filter=false, $htmlOptions=array())
	{
		$language = Yii::app()->language;		
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');
		$result = Yii::app()->db->createCommand()->select("id as key, id as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}

}
