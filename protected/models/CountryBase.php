<?php


/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
		 * @property integer $id
		 * @property string $code
		 * @property string $name
		 * @property string $printable_name
		 * @property string $iso3
		 * @property integer $numcode
		 * @property integer $is_default
		 * @property integer $is_highlight
		 * @property integer $is_active
		 * @property integer $date_added
		 * @property integer $date_modified
 */
 
class CountryBase extends ActiveRecordBase
{
	public $uploadPath;
	
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'country';
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, printable_name', 'required'),
			array('numcode, is_default, is_highlight, is_active, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>2),
			array('name, printable_name', 'length', 'max'=>80),
			array('iso3', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, printable_name, iso3, numcode, is_default, is_highlight, is_active, date_added, date_modified', 'safe', 'on'=>'search'),
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
		'code' => Yii::t('app', 'Code'),
		'name' => Yii::t('app', 'Name'),
		'printable_name' => Yii::t('app', 'Printable Name'),
		'iso3' => Yii::t('app', 'Iso3'),
		'numcode' => Yii::t('app', 'Numcode'),
		'is_default' => Yii::t('app', 'Is Default'),
		'is_highlight' => Yii::t('app', 'Is Highlight'),
		'is_active' => Yii::t('app', 'Is Active'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('printable_name',$this->printable_name,true);
		$criteria->compare('iso3',$this->iso3,true);
		$criteria->compare('numcode',$this->numcode);
		$criteria->compare('is_default',$this->is_default);
		$criteria->compare('is_highlight',$this->is_highlight);
		$criteria->compare('is_active',$this->is_active);
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
	 * @return Country the static model class
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
	 * These are function for foregin refer usage
	 */
	public function getForeignReferList()
	{
		return Yii::app()->db->createCommand()->select('code as key, printable_name as title')->from(self::tableName())->queryAll();
	}
}
