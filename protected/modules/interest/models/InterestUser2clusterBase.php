<?php


/**
 * This is the model class for table "interest_user2cluster".
 *
 * The followings are the available columns in table 'interest_user2cluster':
			 * @property integer $cluster_id
			 * @property integer $interest_id
 *
 * The followings are the available model relations:
 * @property Cluster $cluster
 * @property Interest $interest
 */
 class InterestUser2clusterBase extends ActiveRecordBase
{
	public $uploadPath;

	
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

		if($this->scenario == "search") {
		} else {
		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'interest_user2cluster';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cluster_id, interest_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cluster_id, interest_id', 'safe', 'on'=>'search'),
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
			'cluster' => array(self::BELONGS_TO, 'Cluster', 'cluster_id'),
			'interest' => array(self::BELONGS_TO, 'Interest', 'interest_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'cluster_id' => Yii::t('app', 'Cluster'),
		'interest_id' => Yii::t('app', 'Interest'),
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

		$criteria->compare('cluster_id',$this->cluster_id);
		$criteria->compare('interest_id',$this->interest_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'clusterId' => $this->cluster_id,
			'interestId' => $this->interest_id,
		
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
	 * @return InterestUser2cluster the static model class
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

	


			// save as null if empty
					if(empty($this->cluster_id) && $this->cluster_id !==0) $this->cluster_id = null;
						if(empty($this->interest_id) && $this->interest_id !==0) $this->interest_id = null;
	
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




		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array(
			
		);
	}
	




	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
