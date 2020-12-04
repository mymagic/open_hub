<?php


/**
 * This is the model class for table "user_social".
 *
 * The followings are the available columns in table 'user_social':
			 * @property integer $id
			 * @property string $username
			 * @property string $social_provider
			 * @property string $social_identifier
			 * @property string $json_social_params
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $username0
 */
 class UserSocialBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_added;

 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'user_social';

 		if ($this->scenario == 'search') {
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'user_social';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('username, social_provider, social_identifier, json_social_params', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('username', 'length', 'max' => 128),
			array('social_provider', 'length', 'max' => 32),
			array('social_identifier', 'length', 'max' => 64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, social_provider, social_identifier, json_social_params, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'username0' => array(self::BELONGS_TO, 'User', 'username'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		return array(
		'id' => Yii::t('app', 'ID'),
		'username' => Yii::t('app', 'Username'),
		'social_provider' => Yii::t('app', 'Social Provider'),
		'social_identifier' => Yii::t('app', 'Social Identifier'),
		'json_social_params' => Yii::t('app', 'Json Social Params'),
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

 		$criteria = new CDbCriteria;

 		$criteria->compare('id', $this->id);
 		$criteria->compare('username', $this->username, true);
 		$criteria->compare('social_provider', $this->social_provider, true);
 		$criteria->compare('social_identifier', $this->social_identifier, true);
 		$criteria->compare('json_social_params', $this->json_social_params, true);
 		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
 			$sTimestamp = strtotime($this->sdate_added);
 			$eTimestamp = strtotime("{$this->edate_added} +1 day");
 			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
 		}
 		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
 			$sTimestamp = strtotime($this->sdate_modified);
 			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
 			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
 		}

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
 	}

 	public function scopes()
 	{
 		return array(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return UserSocial the static model class
 	 */
 	public static function model($className = __CLASS__)
 	{
 		return parent::model($className);
 	}

 	/**
 	 * This is invoked before the record is saved.
 	 * @return boolean whether the record should be saved.
 	 */
 	protected function beforeSave()
 	{
 		if (parent::beforeSave()) {
 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

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
 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
		);
 	}
 }
