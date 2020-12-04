<?php


/**
 * This is the model class for table "cv_jobpos".
 *
 * The followings are the available columns in table 'cv_jobpos':
			 * @property integer $id
			 * @property integer $cv_jobpos_group_id
			 * @property string $title
			 * @property integer $is_active
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property CvJobposGroup $cvJobposGroup
 */
 class CvJobposBase extends ActiveRecord
 {
 	public $uploadPath;

 	public $sdate_added;

 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();

 		if ($this->scenario == 'search') {
 			$this->is_active = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'cv_jobpos';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('cv_jobpos_group_id, title', 'required'),
			array('cv_jobpos_group_id, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 255),
			array('json_extra', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cv_jobpos_group_id, title, is_active, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'cvJobposGroup' => array(self::BELONGS_TO, 'CvJobposGroup', 'cv_jobpos_group_id'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		$return = array(
		'id' => Yii::t('app', 'ID'),
		'cv_jobpos_group_id' => Yii::t('app', 'Cv Jobpos Group'),
		'title' => Yii::t('app', 'Title'),
		'is_active' => Yii::t('app', 'Is Active'),
		'json_extra' => Yii::t('app', 'Json Extra'),
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

 		$criteria = new CDbCriteria;

 		$criteria->compare('id', $this->id);
 		$criteria->compare('cv_jobpos_group_id', $this->cv_jobpos_group_id);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('json_extra', $this->json_extra, true);
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

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'cvJobposGroupId' => $this->cv_jobpos_group_id,
			'title' => $this->title,
			'isActive' => $this->is_active,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
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

 	public function scopes()
 	{
 		return array(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),

			'isActive' => array('condition' => 't.is_active = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return CvJobpos the static model class
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
 		if ($this->isNewRecord) {
 		} else {
 		}

 		// todo: for all language filed that is required but data is empty, copy the value from default language so when params.backendLanguages do not include those params.languages, validation error wont throw out

 		return parent::beforeValidate();
 	}

 	protected function afterSave()
 	{
 		if (Yii::app()->neo4j->getStatus()) {
 			Neo4jCvJobpos::model($this)->sync();
 		}

 		return parent::afterSave();
 	}

 	protected function afterDelete()
 	{
 		// custom code here
 		// ...
 		if (Yii::app()->neo4j->getStatus()) {
 			Neo4jCvJobpos::model()->deleteOneByPk($this->id);
 		}

 		return parent::afterDelete();
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

 			// save as null if empty
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->date_added) && $this->date_added !== 0) {
 				$this->date_added = null;
 			}
 			if (empty($this->date_modified) && $this->date_modified !== 0) {
 				$this->date_modified = null;
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
 		// boolean
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}

 		parent::afterFind();
 	}

 	public function behaviors()
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
