<?php


/**
 * This is the model class for table "event_registration".
 *
 * The followings are the available columns in table 'event_registration':
			 * @property string $id
			 * @property string $event_code
			 * @property integer $event_id
			 * @property string $event_vendor_code
			 * @property string $registration_code
			 * @property string $full_name
			 * @property string $first_name
			 * @property string $last_name
			 * @property string $email
			 * @property string $phone
			 * @property string $organization
			 * @property string $gender
			 * @property string $age_group
			 * @property string $where_found
			 * @property string $persona
			 * @property string $paid_fee
			 * @property integer $is_attended
			 * @property string $nationality
			 * @property integer $is_bumi
			 * @property integer $date_registered
			 * @property integer $date_payment
			 * @property string $json_original
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Event $event
 */
 class EventRegistrationBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_registered, $edate_registered;
	public $sdate_payment, $edate_payment;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;

	// json
	public $jsonArray_original;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();
		// meta
		$this->initMetaStructure($this->tableName());

		if($this->scenario == "search")
		{
			$this->is_attended = null;
			$this->is_bumi = null;
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
		return 'event_registration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_registered', 'required'),
			array('event_id, is_attended, is_bumi, date_registered, date_payment, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('event_code, event_vendor_code, registration_code', 'length', 'max'=>64),
			array('full_name, first_name, last_name, email, organization, persona, nationality', 'length', 'max'=>255),
			array('phone, age_group, where_found', 'length', 'max'=>128),
			array('gender', 'length', 'max'=>7),
			array('paid_fee', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_code, event_id, event_vendor_code, registration_code, full_name, first_name, last_name, email, phone, organization, gender, age_group, where_found, persona, paid_fee, is_attended, nationality, is_bumi, date_registered, date_payment, json_original, date_added, date_modified, sdate_registered, edate_registered, sdate_payment, edate_payment, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),

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
		'event_code' => Yii::t('app', 'Event Code'),
		'event_id' => Yii::t('app', 'Event'),
		'event_vendor_code' => Yii::t('app', 'Event Vendor Code'),
		'registration_code' => Yii::t('app', 'Registration Code'),
		'full_name' => Yii::t('app', 'Full Name'),
		'first_name' => Yii::t('app', 'First Name'),
		'last_name' => Yii::t('app', 'Last Name'),
		'email' => Yii::t('app', 'Email'),
		'phone' => Yii::t('app', 'Phone'),
		'organization' => Yii::t('app', 'Organization'),
		'gender' => Yii::t('app', 'Gender'),
		'age_group' => Yii::t('app', 'Age Group'),
		'where_found' => Yii::t('app', 'Where Found'),
		'persona' => Yii::t('app', 'Persona'),
		'paid_fee' => Yii::t('app', 'Paid Fee'),
		'is_attended' => Yii::t('app', 'Is Attended'),
		'nationality' => Yii::t('app', 'Nationality'),
		'is_bumi' => Yii::t('app', 'Is Bumi'),
		'date_registered' => Yii::t('app', 'Date Registered'),
		'date_payment' => Yii::t('app', 'Date Payment'),
		'json_original' => Yii::t('app', 'Json Original'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('event_code',$this->event_code,true);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('event_vendor_code',$this->event_vendor_code,true);
		$criteria->compare('registration_code',$this->registration_code,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('age_group',$this->age_group,true);
		$criteria->compare('where_found',$this->where_found,true);
		$criteria->compare('persona',$this->persona,true);
		$criteria->compare('paid_fee',$this->paid_fee,true);
		$criteria->compare('is_attended',$this->is_attended);
		$criteria->compare('nationality',$this->nationality,true);
		$criteria->compare('is_bumi',$this->is_bumi);
		if(!empty($this->sdate_registered) && !empty($this->edate_registered))
		{
			$sTimestamp = strtotime($this->sdate_registered);
			$eTimestamp = strtotime("{$this->edate_registered} +1 day");
			$criteria->addCondition(sprintf('date_registered >= %s AND date_registered < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_payment) && !empty($this->edate_payment))
		{
			$sTimestamp = strtotime($this->sdate_payment);
			$eTimestamp = strtotime("{$this->edate_payment} +1 day");
			$criteria->addCondition(sprintf('date_payment >= %s AND date_payment < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('json_original',$this->json_original,true);
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
			'eventCode' => $this->event_code,
			'eventId' => $this->event_id,
			'eventVendorCode' => $this->event_vendor_code,
			'registrationCode' => $this->registration_code,
			'fullName' => $this->full_name,
			'firstName' => $this->first_name,
			'lastName' => $this->last_name,
			'email' => $this->email,
			'phone' => $this->phone,
			'organization' => $this->organization,
			'gender' => $this->gender,
			'ageGroup' => $this->age_group,
			'whereFound' => $this->where_found,
			'persona' => $this->persona,
			'paidFee' => $this->paid_fee,
			'isAttended' => $this->is_attended,
			'nationality' => $this->nationality,
			'isBumi' => $this->is_bumi,
			'dateRegistered' => $this->date_registered,
			'fDateRegistered'=>$this->renderDateRegistered(),
			'datePayment' => $this->date_payment,
			'fDatePayment'=>$this->renderDatePayment(),
			'jsonOriginal' => $this->json_original,
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

	public function renderDateRegistered()
	{
		return Html::formatDateTimezone($this->date_registered, 'standard', 'standard', '-', $this->getTimezone());
	}
	public function renderDatePayment()
	{
		return Html::formatDateTimezone($this->date_payment, 'standard', 'standard', '-', $this->getTimezone());
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

			'isAttended' => array('condition'=>'t.is_attended = 1'),
			'isBumi' => array('condition'=>'t.is_bumi = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventRegistration the static model class
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
			if($this->event_code == '') $this->event_code = NULL;
			if($this->event_vendor_code == '') $this->event_vendor_code = NULL;
			if($this->registration_code == '') $this->registration_code = NULL;
			if($this->is_bumi == '') $this->is_bumi = NULL;
			if(!empty($this->date_registered))
			{
				if(!is_numeric($this->date_registered))
				{
					$this->date_registered = strtotime($this->date_registered);
				}
			}
			if(!empty($this->date_payment))
			{
				if(!is_numeric($this->date_payment))
				{
					$this->date_payment = strtotime($this->date_payment);
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
			$this->json_original = json_encode($this->jsonArray_original);
			if($this->json_original == 'null') $this->json_original = null;

// save as null if empty
			if(empty($this->event_code) && $this->event_code !=0) $this->event_code = null;
			if(empty($this->event_id) && $this->event_id !=0) $this->event_id = null;
			if(empty($this->event_vendor_code) && $this->event_vendor_code !=0) $this->event_vendor_code = null;
			if(empty($this->registration_code) && $this->registration_code !=0) $this->registration_code = null;
			if(empty($this->full_name) && $this->full_name !=0) $this->full_name = null;
			if(empty($this->first_name) && $this->first_name !=0) $this->first_name = null;
			if(empty($this->last_name) && $this->last_name !=0) $this->last_name = null;
			if(empty($this->email) && $this->email !=0) $this->email = null;
			if(empty($this->phone) && $this->phone !=0) $this->phone = null;
			if(empty($this->organization) && $this->organization !=0) $this->organization = null;
			if(empty($this->age_group) && $this->age_group !=0) $this->age_group = null;
			if(empty($this->where_found) && $this->where_found !=0) $this->where_found = null;
			if(empty($this->persona) && $this->persona !=0) $this->persona = null;
			if(empty($this->paid_fee) && $this->paid_fee !=0) $this->paid_fee = null;
			if(empty($this->nationality) && $this->nationality !=0) $this->nationality = null;
			if(empty($this->is_bumi) && $this->is_bumi !=0) $this->is_bumi = null;
			if(empty($this->date_payment) && $this->date_payment !=0) $this->date_payment = null;
			if(empty($this->json_original) && $this->json_original !=0) $this->json_original = null;

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
		if($this->is_attended != '' || $this->is_attended != null) $this->is_attended = intval($this->is_attended);
		if($this->is_bumi != '' || $this->is_bumi != null) $this->is_bumi = intval($this->is_bumi);

		$this->jsonArray_original = json_decode($this->json_original);



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
	public function getEnumGender($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code'=>'', 'title'=>$this->formatEnumGender(''));
		
		$result[] = array('code'=>'male', 'title'=>$this->formatEnumGender('male'));
		$result[] = array('code'=>'female', 'title'=>$this->formatEnumGender('female'));
		$result[] = array('code'=>'unknown', 'title'=>$this->formatEnumGender('unknown'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumGender($code)
	{
		switch($code)
		{
			
			case 'male': {return Yii::t('app', 'Male'); break;}
			
			case 'female': {return Yii::t('app', 'Female'); break;}
			
			case 'unknown': {return Yii::t('app', 'Unknown'); break;}
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
		$result = Yii::app()->db->createCommand()->select("id as key, email as title")->from(self::tableName())->queryAll();
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
