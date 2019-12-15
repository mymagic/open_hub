<?php


/**
 * This is the model class for table "idea_rfp".
 *
 * The followings are the available columns in table 'idea_rfp':
			 * @property integer $id
			 * @property string $partner_organization_code
			 * @property string $title
			 * @property string $html_content
			 * @property string $text_background
			 * @property string $text_scope
			 * @property string $text_schedule
			 * @property string $text_staff
			 * @property string $text_cost
			 * @property string $text_supporting
			 * @property string $status
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property integer $date_transacted
			 * @property double $amount
			 * @property double $amount_local
			 * @property string $currency
			 * @property double $amount_convert_rate
 *
 * The followings are the available model relations:
 * @property Organization $partnerOrganization
 * @property Organization[] $organizations
 */
 class IdeaRfpBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	public $sdate_transacted, $edate_transacted;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

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
		return 'idea_rfp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('partner_organization_code, title, html_content', 'required'),
			array('date_added, date_modified, date_transacted', 'numerical', 'integerOnly'=>true),
			array('amount, amount_local, amount_convert_rate', 'numerical'),
			array('partner_organization_code', 'length', 'max'=>64),
			array('title', 'length', 'max'=>255),
			array('status', 'length', 'max'=>8),
			array('currency', 'length', 'max'=>3),
			array('text_background, text_scope, text_schedule, text_staff, text_cost, text_supporting', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, partner_organization_code, title, html_content, text_background, text_scope, text_schedule, text_staff, text_cost, text_supporting, status, date_added, date_modified, date_transacted, amount, amount_local, currency, amount_convert_rate, sdate_added, edate_added, sdate_modified, edate_modified, sdate_transacted, edate_transacted', 'safe', 'on'=>'search'),
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
			'partnerOrganization' => array(self::BELONGS_TO, 'Organization', 'partner_organization_code'),
			'organizations' => array(self::MANY_MANY, 'Organization', 'idea_rfp2enterprise(idea_rfp_id, enterprise_organization_code)'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'partner_organization_code' => Yii::t('app', 'Partner Organization Code'),
		'title' => Yii::t('app', 'Title'),
		'html_content' => Yii::t('app', 'Html Content'),
		'text_background' => Yii::t('app', 'Text Background'),
		'text_scope' => Yii::t('app', 'Text Scope'),
		'text_schedule' => Yii::t('app', 'Text Schedule'),
		'text_staff' => Yii::t('app', 'Text Staff'),
		'text_cost' => Yii::t('app', 'Text Cost'),
		'text_supporting' => Yii::t('app', 'Text Supporting'),
		'status' => Yii::t('app', 'Status'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'date_transacted' => Yii::t('app', 'Date Transacted'),
		'amount' => Yii::t('app', 'Amount'),
		'amount_local' => Yii::t('app', 'Amount Local'),
		'currency' => Yii::t('app', 'Currency'),
		'amount_convert_rate' => Yii::t('app', 'Amount Convert Rate'),
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
		$criteria->compare('partner_organization_code',$this->partner_organization_code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('html_content',$this->html_content,true);
		$criteria->compare('text_background',$this->text_background,true);
		$criteria->compare('text_scope',$this->text_scope,true);
		$criteria->compare('text_schedule',$this->text_schedule,true);
		$criteria->compare('text_staff',$this->text_staff,true);
		$criteria->compare('text_cost',$this->text_cost,true);
		$criteria->compare('text_supporting',$this->text_supporting,true);
		$criteria->compare('status',$this->status);
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
		if(!empty($this->sdate_transacted) && !empty($this->edate_transacted))
		{
			$sTimestamp = strtotime($this->sdate_transacted);
			$eTimestamp = strtotime("{$this->edate_transacted} +1 day");
			$criteria->addCondition(sprintf('date_transacted >= %s AND date_transacted < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('amount',$this->amount);
		$criteria->compare('amount_local',$this->amount_local);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('amount_convert_rate',$this->amount_convert_rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'partnerOrganizationCode' => $this->partner_organization_code,
			'title' => $this->title,
			'htmlContent' => $this->html_content,
			'textBackground' => $this->text_background,
			'textScope' => $this->text_scope,
			'textSchedule' => $this->text_schedule,
			'textStaff' => $this->text_staff,
			'textCost' => $this->text_cost,
			'textSupporting' => $this->text_supporting,
			'status' => $this->status,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
			'dateTransacted' => $this->date_transacted,
			'fDateTransacted'=>$this->renderDateTransacted(),
			'amount' => $this->amount,
			'amountLocal' => $this->amount_local,
			'currency' => $this->currency,
			'amountConvertRate' => $this->amount_convert_rate,
		
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
	public function renderDateTransacted()
	{
		return Html::formatDateTimezone($this->date_transacted, 'standard', 'standard', '-', $this->getTimezone());
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
	 * @return IdeaRfp the static model class
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
			if(!empty($this->date_transacted))
			{
				if(!is_numeric($this->date_transacted))
				{
					$this->date_transacted = strtotime($this->date_transacted);
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
	


// save as null if empty
					if(empty($this->text_background)) $this->text_background = null;
						if(empty($this->text_scope)) $this->text_scope = null;
						if(empty($this->text_schedule)) $this->text_schedule = null;
						if(empty($this->text_staff)) $this->text_staff = null;
						if(empty($this->text_cost)) $this->text_cost = null;
						if(empty($this->text_supporting)) $this->text_supporting = null;
						if(empty($this->date_transacted) && $this->date_transacted !=0) $this->date_transacted = null;
						if(empty($this->amount) && $this->amount !=0) $this->amount = null;
						if(empty($this->amount_local) && $this->amount_local !=0) $this->amount_local = null;
						if(empty($this->currency)) $this->currency = null;
						if(empty($this->amount_convert_rate) && $this->amount_convert_rate !=0) $this->amount_convert_rate = null;
	
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
		$result[] = array('code'=>'engaging', 'title'=>$this->formatEnumStatus('engaging'));
		$result[] = array('code'=>'engaged', 'title'=>$this->formatEnumStatus('engaged'));
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
			
			case 'engaging': {return Yii::t('app', 'Engaging'); break;}
			
			case 'engaged': {return Yii::t('app', 'Engaged'); break;}
			
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
		$result = Yii::app()->db->createCommand()->select("id as key, id as title")->from(self::tableName())->queryAll();
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
