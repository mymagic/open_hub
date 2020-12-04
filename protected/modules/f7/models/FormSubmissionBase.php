<?php


/**
 * This is the model class for table "form_submission".
 *
 * The followings are the available columns in table 'form_submission':
			 * @property integer $id
			 * @property string $code
			 * @property string $form_code
			 * @property integer $form_id
			 * @property integer $user_id
			 * @property string $json_data
			 * @property string $status
			 * @property string $stage
			 * @property integer $date_submitted
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property string $json_extra
			 * @property string $process_by
			 * @property integer $date_processed
 */
 class FormSubmissionBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_submitted;

 	public $edate_submitted;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;
 	public $sdate_processed;
 	public $edate_processed;

 	// json
 	public $jsonArray_data;
 	public $jsonArray_extra;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

 		if ($this->scenario == 'search') {
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'form_submission';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, form_code, stage', 'required'),
			array('form_id, user_id, date_submitted, date_added, date_modified, date_processed', 'numerical', 'integerOnly' => true),
			array('code, form_code', 'length', 'max' => 64),
			array('status', 'length', 'max' => 6),
			array('stage', 'length', 'max' => 255),
			array('process_by', 'length', 'max' => 128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, form_code, form_id, user_id, json_data, status, stage, date_submitted, date_added, date_modified, json_extra, process_by, date_processed, sdate_submitted, edate_submitted, sdate_added, edate_added, sdate_modified, edate_modified, sdate_processed, edate_processed', 'safe', 'on' => 'search'),
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
			'form' => array(self::BELONGS_TO, 'Form', 'form_code'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		$return = array(
		'id' => Yii::t('app', 'ID'),
		'code' => Yii::t('app', 'Code'),
		'form_code' => Yii::t('app', 'Form Code'),
		'form_id' => Yii::t('app', 'Form'),
		'user_id' => Yii::t('app', 'User'),
		'json_data' => Yii::t('app', 'Json Data'),
		'status' => Yii::t('app', 'Status'),
		'stage' => Yii::t('app', 'Stage'),
		'date_submitted' => Yii::t('app', 'Date Submitted'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'process_by' => Yii::t('app', 'Process By'),
		'date_processed' => Yii::t('app', 'Date Processed'),
		);

 		// meta
 		$return = array_merge((array)$return, array_keys($this->_dynamicFields));
 		foreach ($this->_metaStructures as $metaStruct) {
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

 		$criteria = new CDbCriteria;

 		$criteria->compare('id', $this->id);
 		$criteria->compare('code', $this->code, true);
 		$criteria->compare('form_code', $this->form_code, true);
 		$criteria->compare('form_id', $this->form_id);
 		$criteria->compare('user_id', $this->user_id);
 		$criteria->compare('json_data', $this->json_data, true);
 		$criteria->compare('status', $this->status);
 		$criteria->compare('stage', $this->stage, true);
 		if (!empty($this->sdate_submitted) && !empty($this->edate_submitted)) {
 			$sTimestamp = strtotime($this->sdate_submitted);
 			$eTimestamp = strtotime("{$this->edate_submitted} +1 day");
 			$criteria->addCondition(sprintf('date_submitted >= %s AND date_submitted < %s', $sTimestamp, $eTimestamp));
 		}
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
 		$criteria->compare('json_extra', $this->json_extra, true);
 		$criteria->compare('process_by', $this->process_by, true);
 		if (!empty($this->sdate_processed) && !empty($this->edate_processed)) {
 			$sTimestamp = strtotime($this->sdate_processed);
 			$eTimestamp = strtotime("{$this->edate_processed} +1 day");
 			$criteria->addCondition(sprintf('date_processed >= %s AND date_processed < %s', $sTimestamp, $eTimestamp));
 		}

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
 	}

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'formCode' => $this->form_code,
			'formId' => $this->form_id,
			'userId' => $this->user_id,
			'jsonData' => $this->json_data,
			'status' => $this->status,
			'stage' => $this->stage,
			'dateSubmitted' => $this->date_submitted,
			'fDateSubmitted' => $this->renderDateSubmitted(),
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'jsonExtra' => $this->json_extra,
			'processBy' => $this->process_by,
			'dateProcessed' => $this->date_processed,
			'fDateProcessed' => $this->renderDateProcessed(),
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

 	public function renderDateSubmitted()
 	{
 		return Html::formatDateTimezone($this->date_submitted, 'standard', 'standard', '-', $this->getTimezone());
 	}

 	public function renderDateAdded()
 	{
 		return Html::formatDateTimezone($this->date_added, 'standard', 'standard', '-', $this->getTimezone());
 	}

 	public function renderDateModified()
 	{
 		return Html::formatDateTimezone($this->date_modified, 'standard', 'standard', '-', $this->getTimezone());
 	}

 	public function renderDateProcessed()
 	{
 		return Html::formatDateTimezone($this->date_processed, 'standard', 'standard', '-', $this->getTimezone());
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
 	 * @return FormSubmission the static model class
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
 			// UUID
 			$this->code = ysUtil::generateUUID();
 		} else {
 			// UUID
 			if (empty($this->code)) {
 				$this->code = ysUtil::generateUUID();
 			}
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
 		if (parent::beforeSave()) {
 			if (!empty($this->date_submitted)) {
 				if (!is_numeric($this->date_submitted)) {
 					$this->date_submitted = strtotime($this->date_submitted);
 				}
 			}
 			if (!empty($this->date_processed)) {
 				if (!is_numeric($this->date_processed)) {
 					$this->date_processed = strtotime($this->date_processed);
 				}
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// json
 			$this->json_data = json_encode($this->jsonArray_data);
 			if ($this->json_data == 'null') {
 				$this->json_data = null;
 			}
 			$this->json_extra = json_encode($this->jsonArray_extra);
 			if ($this->json_extra == 'null') {
 				$this->json_extra = null;
 			}

 			// save as null if empty
 			if (empty($this->form_id) && $this->form_id !== 0) {
 				$this->form_id = null;
 			}
 			if (empty($this->user_id) && $this->user_id !== 0) {
 				$this->user_id = null;
 			}
 			if (empty($this->json_data)) {
 				$this->json_data = null;
 			}
 			if (empty($this->date_submitted) && $this->date_submitted !== 0) {
 				$this->date_submitted = null;
 			}
 			if (empty($this->date_added) && $this->date_added !== 0) {
 				$this->date_added = null;
 			}
 			if (empty($this->date_modified) && $this->date_modified !== 0) {
 				$this->date_modified = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->process_by)) {
 				$this->process_by = null;
 			}
 			if (empty($this->date_processed) && $this->date_processed !== 0) {
 				$this->date_processed = null;
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

 		$this->jsonArray_data = json_decode($this->json_data);
 		$this->jsonArray_extra = json_decode($this->json_extra);

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumStatus($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumStatus(''));
 		}

 		$result[] = array('code' => 'draft', 'title' => $this->formatEnumStatus('draft'));
 		$result[] = array('code' => 'submit', 'title' => $this->formatEnumStatus('submit'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumStatus($code)
 	{
 		switch ($code) {
			case 'draft': {return Yii::t('app', 'Draft'); break;}

			case 'submit': {return Yii::t('app', 'Submit'); break;}
			default: {return ''; break;}
		}
 	}

 	/**
 	 * These are function for foregin refer usage
 	 */
 	public function getForeignReferList($isNullable = false, $is4Filter = false)
 	{
 		$language = Yii::app()->language;

 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('key' => '', 'title' => '');
 		}
 		$result = Yii::app()->db->createCommand()->select('id as key, code as title')->from(self::tableName())->queryAll();
 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['key']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function isCodeExists($code)
 	{
 		$exists = FormSubmission::model()->find('code=:code', array(':code' => $code));
 		if ($exists === null) {
 			return false;
 		}

 		return true;
 	}

 	/**
 	* These are function for spatial usage
 	*/
 	public function fixSpatial()
 	{
 	}
 }
