<?php


/**
 * This is the model class for table "organization_funding".
 *
 * The followings are the available columns in table 'organization_funding':
			 * @property integer $id
			 * @property integer $organization_id
			 * @property integer $date_raised
			 * @property integer $vc_organization_id
			 * @property string $vc_name
			 * @property integer $is_amount_undisclosed
			 * @property string $amount
			 * @property string $round_type_code
			 * @property string $source
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property integer $is_active
			 * @property integer $is_publicized
 *
 * The followings are the available model relations:
 * @property Organization $organization
 * @property Organization $vcOrganization
 * @property Resource2organizationFunding[] $resource2organizationFundings
 */
 class OrganizationFundingBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_raised, $edate_raised;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

		if($this->scenario == "search") {
			$this->is_amount_undisclosed = null;
			$this->is_active = null;
			$this->is_publicized = null;
		} else {
		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'organization_funding';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organization_id', 'required'),
			array('organization_id, date_raised, vc_organization_id, is_amount_undisclosed, date_added, date_modified, is_active, is_publicized', 'numerical', 'integerOnly'=>true),
			array('vc_name', 'length', 'max'=>128),
			array('amount', 'length', 'max'=>20),
			array('round_type_code', 'length', 'max'=>18),
			array('source', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, organization_id, date_raised, vc_organization_id, vc_name, is_amount_undisclosed, amount, round_type_code, source, date_added, date_modified, is_active, is_publicized, sdate_raised, edate_raised, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'vcOrganization' => array(self::BELONGS_TO, 'Organization', 'vc_organization_id'),
			'resource2organizationFundings' => array(self::HAS_MANY, 'Resource2organizationFunding', 'organization_funding_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'organization_id' => Yii::t('app', 'Organization'),
		'date_raised' => Yii::t('app', 'Date Raised'),
		'vc_organization_id' => Yii::t('app', 'Vc Organization'),
		'vc_name' => Yii::t('app', 'Vc Name'),
		'is_amount_undisclosed' => Yii::t('app', 'Is Amount Undisclosed'),
		'amount' => Yii::t('app', 'Amount'),
		'round_type_code' => Yii::t('app', 'Round Type Code'),
		'source' => Yii::t('app', 'Source'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'is_active' => Yii::t('app', 'Is Active'),
		'is_publicized' => Yii::t('app', 'Is Publicized'),
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
		$criteria->compare('organization_id',$this->organization_id);
		if(!empty($this->sdate_raised) && !empty($this->edate_raised)) {
			$sTimestamp = strtotime($this->sdate_raised);
			$eTimestamp = strtotime("{$this->edate_raised} +1 day");
			$criteria->addCondition(sprintf('date_raised >= %s AND date_raised < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('vc_organization_id',$this->vc_organization_id);
		$criteria->compare('vc_name',$this->vc_name,true);
		$criteria->compare('is_amount_undisclosed',$this->is_amount_undisclosed);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('round_type_code',$this->round_type_code);
		$criteria->compare('source',$this->source,true);
		if(!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_publicized',$this->is_publicized);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'organizationId' => $this->organization_id,
			'dateRaised' => $this->date_raised,
			'fDateRaised' => $this->renderDateRaised(),
			'vcOrganizationId' => $this->vc_organization_id,
			'vcName' => $this->vc_name,
			'isAmountUndisclosed' => $this->is_amount_undisclosed,
			'amount' => $this->amount,
			'roundTypeCode' => $this->round_type_code,
			'source' => $this->source,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'isActive' => $this->is_active,
			'isPublicized' => $this->is_publicized,
		
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

	public function renderDateRaised()
	{
		return Html::formatDateTimezone($this->date_raised, 'standard', 'standard', '-', $this->getTimezone());
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

			'isAmountUndisclosed' => array('condition' => 't.is_amount_undisclosed = 1'),
			'isActive' => array('condition' => 't.is_active = 1'),
			'isPublicized' => array('condition' => 't.is_publicized = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrganizationFunding the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * This is invoked before the record is validated.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeValidate() 
	{
		if($this->isNewRecord) {
		} else {
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
		if(parent::beforeSave()) {
			if($this->round_type_code == '') $this->round_type_code = NULL;
			if($this->is_amount_undisclosed == '') $this->is_amount_undisclosed = NULL;
			if($this->is_publicized == '') $this->is_publicized = NULL;
			if(!empty($this->date_raised)) {
				if(!is_numeric($this->date_raised)) {
					$this->date_raised = strtotime($this->date_raised);
				}
			}

			// auto deal with date added and date modified
			if($this->isNewRecord) {
				$this->date_added=$this->date_modified = time();
			} else {
				$this->date_modified = time();
			}
	


			// save as null if empty
					if(empty($this->date_raised) && $this->date_raised !==0) $this->date_raised = null;
						if(empty($this->vc_organization_id) && $this->vc_organization_id !==0) $this->vc_organization_id = null;
						if(empty($this->vc_name)) $this->vc_name = null;
						if(empty($this->is_amount_undisclosed) && $this->is_amount_undisclosed !==0) $this->is_amount_undisclosed = null;
						if(empty($this->amount)) $this->amount = null;
						if(empty($this->round_type_code)) $this->round_type_code = null;
						if(empty($this->source)) $this->source = null;
						if(empty($this->is_publicized) && $this->is_publicized !==0) $this->is_publicized = null;
	
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * This is invoked after the record is found.
	 */
	protected function afterFind()
	{
		// boolean
		if($this->is_amount_undisclosed != '' || $this->is_amount_undisclosed != null) $this->is_amount_undisclosed = intval($this->is_amount_undisclosed);
		if($this->is_active != '' || $this->is_active != null) $this->is_active = intval($this->is_active);
		if($this->is_publicized != '' || $this->is_publicized != null) $this->is_publicized = intval($this->is_publicized);




		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array(
			
		);
	}
	
	/**
	 * These are function for enum usage
	 */
	public function getEnumRoundTypeCode($isNullable=false, $is4Filter=false)
	{
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('code' => '', 'title' => $this->formatEnumRoundTypeCode(''));
		
		$result[] = array('code' => 'seed', 'title' => $this->formatEnumRoundTypeCode('seed'));
		$result[] = array('code' => 'preSeriesA', 'title' => $this->formatEnumRoundTypeCode('preSeriesA'));
		$result[] = array('code' => 'seriesA', 'title' => $this->formatEnumRoundTypeCode('seriesA'));
		$result[] = array('code' => 'seriesB', 'title' => $this->formatEnumRoundTypeCode('seriesB'));
		$result[] = array('code' => 'seriesC', 'title' => $this->formatEnumRoundTypeCode('seriesC'));
		$result[] = array('code' => 'seriesD', 'title' => $this->formatEnumRoundTypeCode('seriesD'));
		$result[] = array('code' => 'seriesE', 'title' => $this->formatEnumRoundTypeCode('seriesE'));
		$result[] = array('code' => 'seriesF', 'title' => $this->formatEnumRoundTypeCode('seriesF'));
		$result[] = array('code' => 'debt', 'title' => $this->formatEnumRoundTypeCode('debt'));
		$result[] = array('code' => 'grant', 'title' => $this->formatEnumRoundTypeCode('grant'));
		$result[] = array('code' => 'equityCrowdfunding', 'title' => $this->formatEnumRoundTypeCode('equityCrowdfunding'));
		$result[] = array('code' => 'crowdfuning', 'title' => $this->formatEnumRoundTypeCode('crowdfuning'));
		
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['code']] = $r['title']; } return $newResult; }
		return $result;
	}
	
	public function formatEnumRoundTypeCode($code)
	{
		switch($code)
		{
			
			case 'seed': {return Yii::t('app', 'Seed'); break;}
			
			case 'preSeriesA': {return Yii::t('app', 'Pre Series A'); break;}
			
			case 'seriesA': {return Yii::t('app', 'Series A'); break;}
			
			case 'seriesB': {return Yii::t('app', 'Series B'); break;}
			
			case 'seriesC': {return Yii::t('app', 'Series C'); break;}
			
			case 'seriesD': {return Yii::t('app', 'Series D'); break;}
			
			case 'seriesE': {return Yii::t('app', 'Series E'); break;}
			
			case 'seriesF': {return Yii::t('app', 'Series F'); break;}
			
			case 'debt': {return Yii::t('app', 'Debt'); break;}
			
			case 'grant': {return Yii::t('app', 'Grant'); break;}
			
			case 'equityCrowdfunding': {return Yii::t('app', 'Equity Crowdfunding'); break;}
			
			case 'crowdfuning': {return Yii::t('app', 'Crowdfuning'); break;}
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
		if($isNullable) $result[] = array('key' => '', 'title' => '');
		$result = Yii::app()->db->createCommand()->select("id as key, amount as title")->from(self::tableName())->queryAll();
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
