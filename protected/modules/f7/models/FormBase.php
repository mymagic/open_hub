<?php


/**
 * This is the model class for table "form".
 *
 * The followings are the available columns in table 'form':
	* @property integer $id
	* @property string $code
	* @property string $slug
	* @property integer $date_open
	* @property integer $date_close
	* @property string $json_structure
	* @property string $json_stage
	* @property integer $is_multiple
	* @property integer $is_login_required
	* @property string $title
	* @property string $text_short_description
	* @property integer $is_active
	* @property string $timezone
	* @property integer $date_added
	* @property integer $date_modified
	* @property integer $type
	* @property string $text_note
	* @property string $json_event_mapping
	* @property string $json_extra
 *
 * The followings are the available model relations:
 * @property Form2intake[] $form2intakes
 * @property FormSubmission[] $formSubmissions
 */
 class FormBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_open;

 	public $edate_open;
 	public $sdate_close;
 	public $edate_close;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// json
 	public $jsonArray_structure;
 	public $jsonArray_stage;
 	public $jsonArray_event_mapping;
 	public $jsonArray_extra;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

 		if ($this->scenario == 'search') {
 			$this->is_multiple = null;
 			$this->is_login_required = null;
 			$this->is_active = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'form';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, date_open, date_close, title', 'required'),
			array('date_open, date_close, is_multiple, is_login_required, is_active, date_added, date_modified, type', 'numerical', 'integerOnly' => true),
			array('code, slug', 'length', 'max' => 64),
			array('title', 'length', 'max' => 255),
			array('timezone', 'length', 'max' => 128),
			array('text_short_description, text_note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, slug, date_open, date_close, json_structure, json_stage, is_multiple, is_login_required, title, text_short_description, is_active, timezone, date_added, date_modified, type, text_note, json_event_mapping, json_extra, sdate_open, edate_open, sdate_close, edate_close, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'form2intakes' => array(self::HAS_MANY, 'Form2intake', 'form_id'),
			'formSubmissions' => array(self::HAS_MANY, 'FormSubmission', 'form_code'),

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
		'slug' => Yii::t('app', 'Slug'),
		'date_open' => Yii::t('app', 'Date Open'),
		'date_close' => Yii::t('app', 'Date Close'),
		'json_structure' => Yii::t('app', 'Json Structure'),
		'json_stage' => Yii::t('app', 'Json Stage'),
		'is_multiple' => Yii::t('app', 'Is Multiple'),
		'is_login_required' => Yii::t('app', 'Is Login Required'),
		'title' => Yii::t('app', 'Title'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'is_active' => Yii::t('app', 'Is Active'),
		'timezone' => Yii::t('app', 'Timezone'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'type' => Yii::t('app', 'Type'),
		'text_note' => Yii::t('app', 'Text Note'),
		'json_event_mapping' => Yii::t('app', 'Json Event Mapping'),
		'json_extra' => Yii::t('app', 'Json Extra'),
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
 		$criteria->compare('slug', $this->slug, true);
 		if (!empty($this->sdate_open) && !empty($this->edate_open)) {
 			$sTimestamp = strtotime($this->sdate_open);
 			$eTimestamp = strtotime("{$this->edate_open} +1 day");
 			$criteria->addCondition(sprintf('date_open >= %s AND date_open < %s', $sTimestamp, $eTimestamp));
 		}
 		if (!empty($this->sdate_close) && !empty($this->edate_close)) {
 			$sTimestamp = strtotime($this->sdate_close);
 			$eTimestamp = strtotime("{$this->edate_close} +1 day");
 			$criteria->addCondition(sprintf('date_close >= %s AND date_close < %s', $sTimestamp, $eTimestamp));
 		}
 		$criteria->compare('json_structure', $this->json_structure, true);
 		$criteria->compare('json_stage', $this->json_stage, true);
 		$criteria->compare('is_multiple', $this->is_multiple);
 		$criteria->compare('is_login_required', $this->is_login_required);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('timezone', $this->timezone, true);
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
 		$criteria->compare('type', $this->type);
 		$criteria->compare('text_note', $this->text_note, true);
 		$criteria->compare('json_event_mapping', $this->json_event_mapping, true);
 		$criteria->compare('json_extra', $this->json_extra, true);

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
			'slug' => $this->slug,
			'dateOpen' => $this->date_open,
			'fDateOpen' => $this->renderDateOpen(),
			'dateClose' => $this->date_close,
			'fDateClose' => $this->renderDateClose(),
			'jsonStructure' => $this->json_structure,
			'jsonStage' => $this->json_stage,
			'isMultiple' => $this->is_multiple,
			'isLoginRequired' => $this->is_login_required,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'isActive' => $this->is_active,
			'timezone' => $this->timezone,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'type' => $this->type,
			'textNote' => $this->text_note,
			'jsonEventMapping' => $this->json_event_mapping,
			'jsonExtra' => $this->json_extra,
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

 	public function renderDateOpen()
 	{
 		return Html::formatDateTimezone($this->date_open, 'standard', 'standard', '-', $this->getTimezone());
 	}

 	public function renderDateClose()
 	{
 		return Html::formatDateTimezone($this->date_close, 'standard', 'standard', '-', $this->getTimezone());
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

			'isMultiple' => array('condition' => 't.is_multiple = 1'),
			'isLoginRequired' => array('condition' => 't.is_login_required = 1'),
			'isActive' => array('condition' => 't.is_active = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Form the static model class
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
 			if (!empty($this->date_open)) {
 				if (!is_numeric($this->date_open)) {
 					$this->date_open = strtotime($this->date_open);
 				}
 			}
 			if (!empty($this->date_close)) {
 				if (!is_numeric($this->date_close)) {
 					$this->date_close = strtotime($this->date_close);
 				}
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// json
 			$this->json_structure = json_encode($this->jsonArray_structure);
 			if ($this->json_structure == 'null') {
 				$this->json_structure = null;
 			}
 			$this->json_stage = json_encode($this->jsonArray_stage);
 			if ($this->json_stage == 'null') {
 				$this->json_stage = null;
 			}
 			$this->json_event_mapping = json_encode($this->jsonArray_event_mapping);
 			if ($this->json_event_mapping == 'null') {
 				$this->json_event_mapping = null;
 			}
 			$this->json_extra = json_encode($this->jsonArray_extra);
 			if ($this->json_extra == 'null') {
 				$this->json_extra = null;
 			}

 			// save as null if empty
 			if (empty($this->slug)) {
 				$this->slug = null;
 			}
 			if (empty($this->json_structure)) {
 				$this->json_structure = null;
 			}
 			if (empty($this->json_stage)) {
 				$this->json_stage = null;
 			}
 			if (empty($this->text_short_description)) {
 				$this->text_short_description = null;
 			}
 			if (empty($this->timezone)) {
 				$this->timezone = null;
 			}
 			if (empty($this->text_note)) {
 				$this->text_note = null;
 			}
 			if (empty($this->json_event_mapping)) {
 				$this->json_event_mapping = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
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
 		if ($this->is_multiple != '' || $this->is_multiple != null) {
 			$this->is_multiple = intval($this->is_multiple);
 		}
 		if ($this->is_login_required != '' || $this->is_login_required != null) {
 			$this->is_login_required = intval($this->is_login_required);
 		}
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}

 		$this->jsonArray_structure = json_decode($this->json_structure);
 		$this->jsonArray_stage = json_decode($this->json_stage);
 		$this->jsonArray_event_mapping = json_decode($this->json_event_mapping);
 		$this->jsonArray_extra = json_decode($this->json_extra);

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
		);
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
 		$result = Yii::app()->db->createCommand()->select('id as key, title as title')->from(self::tableName())->queryAll();
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
 		$exists = Form::model()->find('code=:code', array(':code' => $code));
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
