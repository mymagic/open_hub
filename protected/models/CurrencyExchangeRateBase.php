<?php


/**
 * This is the model class for table "currency_exchange_rate".
 *
 * The followings are the available columns in table 'currency_exchange_rate':
			 * @property integer $id
			 * @property string $from_currency_code
			 * @property string $to_currency_code
			 * @property double $rate
			 * @property integer $year
			 * @property integer $month
			 * @property integer $day
			 * @property integer $date_record
			 * @property integer $date_added
			 * @property integer $date_modified
 */
 class CurrencyExchangeRateBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_record, $edate_record;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
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
		return 'currency_exchange_rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_currency_code, to_currency_code, rate, year, month, day, date_record', 'required'),
			array('year, month, day, date_record, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('from_currency_code, to_currency_code', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, from_currency_code, to_currency_code, rate, year, month, day, date_record, date_added, date_modified, sdate_record, edate_record, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'from_currency_code' => Yii::t('app', 'From Currency Code'),
		'to_currency_code' => Yii::t('app', 'To Currency Code'),
		'rate' => Yii::t('app', 'Rate'),
		'year' => Yii::t('app', 'Year'),
		'month' => Yii::t('app', 'Month'),
		'day' => Yii::t('app', 'Day'),
		'date_record' => Yii::t('app', 'Date Record'),
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
		$criteria->compare('from_currency_code',$this->from_currency_code,true);
		$criteria->compare('to_currency_code',$this->to_currency_code,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('year',$this->year);
		$criteria->compare('month',$this->month);
		$criteria->compare('day',$this->day);
		if(!empty($this->sdate_record) && !empty($this->edate_record))
		{
			$sTimestamp = strtotime($this->sdate_record);
			$eTimestamp = strtotime("{$this->edate_record} +1 day");
			$criteria->addCondition(sprintf('date_record >= %s AND date_record < %s', $sTimestamp, $eTimestamp));
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
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'fromCurrencyCode' => $this->from_currency_code,
			'toCurrencyCode' => $this->to_currency_code,
			'rate' => $this->rate,
			'year' => $this->year,
			'month' => $this->month,
			'day' => $this->day,
			'dateRecord' => $this->date_record,
			'fDateRecord'=>$this->renderDateRecord(),
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

	public function renderDateRecord()
	{
		return Html::formatDateTimezone($this->date_record, 'standard', 'standard', '-', $this->getTimezone());
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


		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CurrencyExchangeRate the static model class
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
			if(!empty($this->date_record))
			{
				if(!is_numeric($this->date_record))
				{
					$this->date_record = strtotime($this->date_record);
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
