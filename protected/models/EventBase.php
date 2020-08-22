<?php


/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
			 * @property integer $id
			 * @property string $code
			 * @property string $event_group_code
			 * @property string $title
			 * @property string $text_short_desc
			 * @property string $url_website
			 * @property integer $date_started
			 * @property integer $date_ended
			 * @property integer $is_paid_event
			 * @property string $genre
			 * @property string $funnel
			 * @property string $vendor
			 * @property string $vendor_code
			 * @property string $at
			 * @property string $address_country_code
			 * @property string $address_state_code
			 * @property string $full_address
			 * @property string $latlong_address
			 * @property string $email_contact
			 * @property integer $is_cancelled
			 * @property integer $is_active
			 * @property string $json_original
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property integer $is_survey_enabled
 *
 * The followings are the available model relations:
 * @property EventGroup $eventGroup
 * @property Country $addressCountry
 * @property State $addressState
 * @property Industry[] $industries
 * @property Persona[] $personas
 * @property StartupStage[] $startupStages
 * @property EventFeedback[] $eventFeedbacks
 * @property EventOrganization[] $eventOrganizations
 * @property EventOwner[] $eventOwners
 * @property EventRegistration[] $eventRegistrations
 * @property Tag2event[] $tag2events
 */
 class EventBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	// m2m
 	public $inputIndustries;
 	public $inputPersonas;
 	public $inputStartupStages;

 	public $sdate_started;

 	public $edate_started;
 	public $sdate_ended;
 	public $edate_ended;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// json
 	public $jsonArray_extra;
 	public $jsonArray_original;

 	// tag
 	public $tag_backend;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

 		if ($this->scenario == 'search') {
 			$this->is_paid_event = null;
 			$this->is_cancelled = null;
 			$this->is_active = null;
 			$this->is_survey_enabled = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'event';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, title, date_started, vendor', 'required'),
			array('date_started, date_ended, is_paid_event, is_cancelled, is_active, date_added, date_modified, is_survey_enabled', 'numerical', 'integerOnly' => true),
			array('code, event_group_code, vendor_code', 'length', 'max' => 64),
			array('title, genre, funnel', 'length', 'max' => 128),
			array('url_website, at, full_address, email_contact', 'length', 'max' => 255),
			array('vendor', 'length', 'max' => 32),
			array('address_country_code', 'length', 'max' => 2),
			array('address_state_code', 'length', 'max' => 6),
			array('text_short_desc, latlong_address, tag_backend, inputIndustries, inputPersonas, inputStartupStages', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, event_group_code, title, text_short_desc, url_website, date_started, date_ended, is_paid_event, genre, funnel, vendor, vendor_code, at, address_country_code, address_state_code, full_address, latlong_address, email_contact, is_cancelled, is_active, json_original, json_extra, date_added, date_modified, is_survey_enabled, sdate_started, edate_started, sdate_ended, edate_ended, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend', 'safe', 'on' => 'search'),
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
			'eventGroup' => array(self::BELONGS_TO, 'EventGroup', 'event_group_code'),
			'addressCountry' => array(self::BELONGS_TO, 'Country', 'address_country_code'),
			'addressState' => array(self::BELONGS_TO, 'State', 'address_state_code'),
			'industries' => array(self::MANY_MANY, 'Industry', 'event2industry(event_id, industry_id)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'event2persona(event_id, persona_id)'),
			'startupStages' => array(self::MANY_MANY, 'StartupStage', 'event2startup_stage(event_id, startup_stage_id)'),
			'eventFeedbacks' => array(self::HAS_MANY, 'EventFeedback', 'event_code'),
			'eventOrganizations' => array(self::HAS_MANY, 'EventOrganization', 'event_id'),
			'eventOwners' => array(self::HAS_MANY, 'EventOwner', 'event_code'),
			'eventRegistrations' => array(self::HAS_MANY, 'EventRegistration', 'event_id'),
			'tag2events' => array(self::HAS_MANY, 'Tag2event', 'event_id'),

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
		'event_group_code' => Yii::t('app', 'Event Group Code'),
		'title' => Yii::t('app', 'Title'),
		'text_short_desc' => Yii::t('app', 'Text Short Desc'),
		'url_website' => Yii::t('app', 'Url Website'),
		'date_started' => Yii::t('app', 'Date Started'),
		'date_ended' => Yii::t('app', 'Date Ended'),
		'is_paid_event' => Yii::t('app', 'Is Paid Event'),
		'genre' => Yii::t('app', 'Genre'),
		'funnel' => Yii::t('app', 'Funnel'),
		'vendor' => Yii::t('app', 'Vendor'),
		'vendor_code' => Yii::t('app', 'Vendor Code'),
		'at' => Yii::t('app', 'At'),
		'address_country_code' => Yii::t('app', 'Address Country Code'),
		'address_state_code' => Yii::t('app', 'Address State Code'),
		'full_address' => Yii::t('app', 'Full Address'),
		'latlong_address' => Yii::t('app', 'Latlong Address'),
		'email_contact' => Yii::t('app', 'Email Contact'),
		'is_cancelled' => Yii::t('app', 'Is Cancelled'),
		'is_active' => Yii::t('app', 'Is Active'),
		'json_original' => Yii::t('app', 'Json Original'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'is_survey_enabled' => Yii::t('app', 'Is Survey Enabled'),
		);

 		$return['inputIndustries'] = Yii::t('app', 'Industries');
 		$return['inputPersonas'] = Yii::t('app', 'Personas');
 		$return['inputStartupStages'] = Yii::t('app', 'Startup Stages');

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
 		$criteria->compare('event_group_code', $this->event_group_code, true);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('text_short_desc', $this->text_short_desc, true);
 		$criteria->compare('url_website', $this->url_website, true);
 		if (!empty($this->sdate_started) && !empty($this->edate_started)) {
 			$sTimestamp = strtotime($this->sdate_started);
 			$eTimestamp = strtotime("{$this->edate_started} +1 day");
 			$criteria->addCondition(sprintf('date_started >= %s AND date_started < %s', $sTimestamp, $eTimestamp));
 		}
 		if (!empty($this->sdate_ended) && !empty($this->edate_ended)) {
 			$sTimestamp = strtotime($this->sdate_ended);
 			$eTimestamp = strtotime("{$this->edate_ended} +1 day");
 			$criteria->addCondition(sprintf('date_ended >= %s AND date_ended < %s', $sTimestamp, $eTimestamp));
 		}
 		$criteria->compare('is_paid_event', $this->is_paid_event);
 		$criteria->compare('genre', $this->genre, true);
 		$criteria->compare('funnel', $this->funnel, true);
 		$criteria->compare('vendor', $this->vendor, true);
 		$criteria->compare('vendor_code', $this->vendor_code, true);
 		$criteria->compare('at', $this->at, true);
 		$criteria->compare('address_country_code', $this->address_country_code, true);
 		$criteria->compare('address_state_code', $this->address_state_code, true);
 		$criteria->compare('full_address', $this->full_address, true);
 		$criteria->compare('latlong_address', $this->latlong_address, true);
 		$criteria->compare('email_contact', $this->email_contact, true);
 		$criteria->compare('is_cancelled', $this->is_cancelled);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('json_original', $this->json_original, true);
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
 		$criteria->compare('is_survey_enabled', $this->is_survey_enabled);

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.date_started DESC'),
		));
 	}

 	public function toApi($params = array())
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'eventGroupCode' => $this->event_group_code,
			'title' => $this->title,
			'textShortDesc' => $this->text_short_desc,
			'urlWebsite' => $this->url_website,
			'dateStarted' => $this->date_started,
			'fDateStarted' => $this->renderDateStarted(),
			'dateEnded' => $this->date_ended,
			'fDateEnded' => $this->renderDateEnded(),
			'isPaidEvent' => $this->is_paid_event,
			'genre' => $this->genre,
			'funnel' => $this->funnel,
			'vendor' => $this->vendor,
			'vendorCode' => $this->vendor_code,
			'at' => $this->at,
			'addressCountryCode' => $this->address_country_code,
			'addressStateCode' => $this->address_state_code,
			'fullAddress' => $this->full_address,
			'latlongAddress' => $this->latlong_address,
			'emailContact' => $this->email_contact,
			'isCancelled' => $this->is_cancelled,
			'isActive' => $this->is_active,
			'jsonOriginal' => $this->json_original,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'isSurveyEnabled' => $this->is_survey_enabled,
		);

 		// many2many
 		if (!in_array('-industries', $params) && !empty($this->industries)) {
 			foreach ($this->industries as $industry) {
 				$return['industries'][] = $industry->toApi(array('-event'));
 			}
 		}
 		if (!in_array('-personas', $params) && !empty($this->personas)) {
 			foreach ($this->personas as $persona) {
 				$return['personas'][] = $persona->toApi(array('-event'));
 			}
 		}
 		if (!in_array('-startupStages', $params) && !empty($this->startupStages)) {
 			foreach ($this->startupStages as $startupStage) {
 				$return['startupStages'][] = $startupStage->toApi(array('-event'));
 			}
 		}

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

 	public function renderDateStarted()
 	{
 		return Html::formatDateTimezone($this->date_started, 'standard', 'standard', '-', $this->getTimezone());
 	}

 	public function renderDateEnded()
 	{
 		return Html::formatDateTimezone($this->date_ended, 'standard', 'standard', '-', $this->getTimezone());
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

			'isPaidEvent' => array('condition' => 't.is_paid_event = 1'),
			'isCancelled' => array('condition' => 't.is_cancelled = 1'),
			'isActive' => array('condition' => 't.is_active = 1'),
			'isSurveyEnabled' => array('condition' => 't.is_survey_enabled = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Event the static model class
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
 		$this->saveInputIndustry();
 		$this->saveInputPersona();
 		$this->saveInputStartupStage();

 		$this->setTags($this->tag_backend);

 		return parent::afterSave();
 	}

 	/**
 	 * This is invoked before the record is saved.
 	 * @return boolean whether the record should be saved.
 	 */
 	protected function beforeSave()
 	{
 		if (parent::beforeSave()) {
 			if ($this->event_group_code == '') {
 				$this->event_group_code = null;
 			}
 			if ($this->vendor_code == '') {
 				$this->vendor_code = null;
 			}
 			if ($this->address_country_code == '') {
 				$this->address_country_code = null;
 			}
 			if ($this->address_state_code == '') {
 				$this->address_state_code = null;
 			}
 			if ($this->is_paid_event == '') {
 				$this->is_paid_event = null;
 			}
 			if ($this->is_survey_enabled == '') {
 				$this->is_survey_enabled = null;
 			}
 			if (!empty($this->date_started)) {
 				if (!is_numeric($this->date_started)) {
 					$this->date_started = strtotime($this->date_started);
 				}
 			}
 			if (!empty($this->date_ended)) {
 				if (!is_numeric($this->date_ended)) {
 					$this->date_ended = strtotime($this->date_ended);
 				}
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// json
 			$this->json_extra = json_encode($this->jsonArray_extra);
 			if ($this->json_extra == 'null') {
 				$this->json_extra = null;
 			}
 			$this->json_original = json_encode($this->jsonArray_original);
 			if ($this->json_original == 'null') {
 				$this->json_original = null;
 			}

 			// save as null if empty
 			if (empty($this->event_group_code)) {
 				$this->event_group_code = null;
 			}
 			if (empty($this->text_short_desc)) {
 				$this->text_short_desc = null;
 			}
 			if (empty($this->url_website)) {
 				$this->url_website = null;
 			}
 			if (empty($this->date_ended) && $this->date_ended !== 0) {
 				$this->date_ended = null;
 			}
 			if (empty($this->is_paid_event) && $this->is_paid_event !== 0) {
 				$this->is_paid_event = null;
 			}
 			if (empty($this->genre)) {
 				$this->genre = null;
 			}
 			if (empty($this->funnel)) {
 				$this->funnel = null;
 			}
 			if (empty($this->vendor_code)) {
 				$this->vendor_code = null;
 			}
 			if (empty($this->at)) {
 				$this->at = null;
 			}
 			if (empty($this->address_country_code)) {
 				$this->address_country_code = null;
 			}
 			if (empty($this->address_state_code)) {
 				$this->address_state_code = null;
 			}
 			if (empty($this->full_address)) {
 				$this->full_address = null;
 			}
 			if (empty($this->latlong_address) && $this->latlong_address !== 0) {
 				$this->latlong_address = null;
 			}
 			if (empty($this->email_contact)) {
 				$this->email_contact = null;
 			}
 			if (empty($this->json_original)) {
 				$this->json_original = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->is_survey_enabled) && $this->is_survey_enabled !== 0) {
 				$this->is_survey_enabled = null;
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
 		if ($this->is_paid_event != '' || $this->is_paid_event != null) {
 			$this->is_paid_event = intval($this->is_paid_event);
 		}
 		if ($this->is_cancelled != '' || $this->is_cancelled != null) {
 			$this->is_cancelled = intval($this->is_cancelled);
 		}
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}
 		if ($this->is_survey_enabled != '' || $this->is_survey_enabled != null) {
 			$this->is_survey_enabled = intval($this->is_survey_enabled);
 		}

 		$this->jsonArray_extra = json_decode($this->json_extra);
 		$this->jsonArray_original = json_decode($this->json_original);

 		$this->tag_backend = $this->backend->toString();

 		foreach ($this->industries as $industry) {
 			$this->inputIndustries[] = $industry->id;
 		}
 		foreach ($this->personas as $persona) {
 			$this->inputPersonas[] = $persona->id;
 		}
 		foreach ($this->startupStages as $startup_stage) {
 			$this->inputStartupStages[] = $startup_stage->id;
 		}

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
			'spatial' => array(
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => array(
					// all spatial fields here
					'latlong_address'
				),
			),

			'backend' => array(
				'class' => 'application.yeebase.extensions.taggable-behavior.ETaggableBehavior',
				'tagTable' => 'tag',
				'tagBindingTable' => 'tag2event',
				'modelTableFk' => 'event_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Event',
				'createTagsAutomatically' => true,
			)
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
 		$exists = Event::model()->find('code=:code', array(':code' => $code));
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
 		$record = $this;
 		$criteria = new CDbCriteria();
 		$lineString = '';

 		$alias = $record->getTableAlias();

 		foreach ($this->spatialFields as $field) {
 			$asField = (($alias && $alias != 't') ? $alias . '_' . $field : $field);
 			$field = ($alias ? ('`' . $alias . '`.') : '') . '`' . $field . '`';
 			$lineString .= 'AsText(' . $field . ') AS ' . $asField . ',';
 		}
 		$lineString = substr($lineString, 0, -1);
 		$criteria->select = (($record->DBCriteria->select == '*') ? '*, ' : '') . $lineString;
 		$criteria->addSearchCondition('id', $record->id);
 		$record->dbCriteria->mergeWith($criteria);

 		$obj = $record->find($criteria);
 		foreach ($this->spatialFields as $field) {
 			$this->$field = $obj->$field;
 		}
 	}

 	public function setLatLongAddress($pos)
 	{
 		if (!empty($pos)) {
 			if (is_array($pos)) {
 				$this->latlong_address = $pos;
 			} else {
 				$this->latlong_address = self::latLngString2Flat($pos);
 			}
 		}
 	}

 	//
 	// industry
 	public function getAllIndustriesKey()
 	{
 		$return = array();
 		if (!empty($this->industries)) {
 			foreach ($this->industries as $r) {
 				$return[] = $r->id;
 			}
 		}

 		return $return;
 	}

 	public function hasIndustry($key)
 	{
 		if (in_array($key, $this->getAllIndustriesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function hasNoIndustry($key)
 	{
 		if (!in_array($key, $this->getAllIndustriesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function removeIndustry($key)
 	{
 		if ($this->hasIndustry($key)) {
 			$many2many = Event2Industry::model()->findByAttributes(array('event_id' => $this->id, 'industry_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addIndustry($key)
 	{
 		if ($this->hasNoIndustry($key)) {
 			$many2many = new Event2Industry;
 			$many2many->event_id = $this->id;
 			$many2many->industry_id = $key;

 			return $many2many->save();
 		}

 		return false;
 	}

 	protected function saveInputIndustry()
 	{
 		// loop thru existing
 		foreach ($this->industries as $r) {
 			// remove extra
 			if (!in_array($r->id, $this->inputIndustries)) {
 				$this->removeIndustry($r->id);
 			}
 		}

 		// loop thru each input
 		foreach ($this->inputIndustries as $input) {
 			// if currently dont have
 			if ($this->hasNoIndustry($input)) {
 				$this->addIndustry($input);
 			}
 		}
 	}

 	//
 	// persona
 	public function getAllPersonasKey()
 	{
 		$return = array();
 		if (!empty($this->personas)) {
 			foreach ($this->personas as $r) {
 				$return[] = $r->id;
 			}
 		}

 		return $return;
 	}

 	public function hasPersona($key)
 	{
 		if (in_array($key, $this->getAllPersonasKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function hasNoPersona($key)
 	{
 		if (!in_array($key, $this->getAllPersonasKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function removePersona($key)
 	{
 		if ($this->hasPersona($key)) {
 			$many2many = Event2Persona::model()->findByAttributes(array('event_id' => $this->id, 'persona_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addPersona($key)
 	{
 		if ($this->hasNoPersona($key)) {
 			$many2many = new Event2Persona;
 			$many2many->event_id = $this->id;
 			$many2many->persona_id = $key;

 			return $many2many->save();
 		}

 		return false;
 	}

 	protected function saveInputPersona()
 	{
 		// loop thru existing
 		foreach ($this->personas as $r) {
 			// remove extra
 			if (!in_array($r->id, $this->inputPersonas)) {
 				$this->removePersona($r->id);
 			}
 		}

 		// loop thru each input
 		foreach ($this->inputPersonas as $input) {
 			// if currently dont have
 			if ($this->hasNoPersona($input)) {
 				$this->addPersona($input);
 			}
 		}
 	}

 	//
 	// startup_stage
 	public function getAllStartupStagesKey()
 	{
 		$return = array();
 		if (!empty($this->startupStages)) {
 			foreach ($this->startupStages as $r) {
 				$return[] = $r->id;
 			}
 		}

 		return $return;
 	}

 	public function hasStartupStage($key)
 	{
 		if (in_array($key, $this->getAllStartupStagesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function hasNoStartupStage($key)
 	{
 		if (!in_array($key, $this->getAllStartupStagesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function removeStartupStage($key)
 	{
 		if ($this->hasStartupStage($key)) {
 			$many2many = Event2StartupStage::model()->findByAttributes(array('event_id' => $this->id, 'startup_stage_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addStartupStage($key)
 	{
 		if ($this->hasNoStartupStage($key)) {
 			$many2many = new Event2StartupStage;
 			$many2many->event_id = $this->id;
 			$many2many->startup_stage_id = $key;

 			return $many2many->save();
 		}

 		return false;
 	}

 	protected function saveInputStartupStage()
 	{
 		// loop thru existing
 		foreach ($this->startupStages as $r) {
 			// remove extra
 			if (!in_array($r->id, $this->inputStartupStages)) {
 				$this->removeStartupStage($r->id);
 			}
 		}

 		// loop thru each input
 		foreach ($this->inputStartupStages as $input) {
 			// if currently dont have
 			if ($this->hasNoStartupStage($input)) {
 				$this->addStartupStage($input);
 			}
 		}
 	}
 }
