<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/

/**
 * This is the model class for table "resource".
 *
 * The followings are the available columns in table 'resource':
			 * @property integer $id
			 * @property string $orid
			 * @property string $title
			 * @property string $slug
			 * @property string $html_content
			 * @property string $image_logo
			 * @property string $url_website
			 * @property string $latlong_address
			 * @property string $full_address
			 * @property string $typefor
			 * @property string $owner
			 * @property integer $is_featured
			 * @property integer $is_active
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property string $title_en
			 * @property string $title_ms
			 * @property string $html_content_en
			 * @property string $html_content_ms
			 * @property integer $is_blocked
 *
 * The followings are the available model relations:
 * @property Industry[] $industries
 * @property Organization[] $organizations
 * @property Resource2organizationFunding[] $resource2organizationFundings
 * @property Persona[] $personas
 * @property ResourceCategory[] $resourceCategories
 * @property ResourceGeofocus[] $resourceGeofocuses
 * @property StartupStage[] $startupStages
 * @property Tag2resource[] $tag2resources
 */
 class ResourceBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	// m2m
 	public $inputOrganizations;
 	public $inputIndustries;
 	public $inputPersonas;
 	public $inputStartupStages;
 	public $inputResourceCategories;
 	public $inputResourceGeofocuses;

 	public $imageFile_logo;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// json
 	public $jsonArray_extra;

 	// tag
 	public $tag_backend;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

 		if ($this->scenario == 'search') {
 			$this->is_featured = null;
 			$this->is_active = null;
 			$this->is_blocked = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'resource';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('title, slug, html_content, html_content_en, title_en', 'required'),
			array('is_featured, is_active, date_added, date_modified, is_blocked', 'numerical', 'integerOnly' => true),
			array('orid', 'length', 'max' => 32),
			array('title, title_en, title_ms', 'length', 'max' => 200),
			array('slug', 'length', 'max' => 64),
			array('image_logo, url_website, full_address, owner', 'length', 'max' => 255),
			array('typefor', 'length', 'max' => 11),
			array('latlong_address, html_content_en, html_content_ms, tag_backend, inputOrganizations, inputIndustries, inputPersonas, inputStartupStages, inputResourceCategories, inputResourceGeofocuses', 'safe'),
			array('imageFile_logo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orid, title, slug, html_content, image_logo, url_website, latlong_address, full_address, typefor, owner, is_featured, is_active, json_extra, date_added, date_modified, title_en, title_ms, html_content_en, html_content_ms, is_blocked, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend', 'safe', 'on' => 'search'),
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
			'industries' => array(self::MANY_MANY, 'Industry', 'resource2industry(resource_id, industry_id)'),
			'organizations' => array(self::MANY_MANY, 'Organization', 'resource2organization(resource_id, organization_id)'),
			'resource2organizationFundings' => array(self::HAS_MANY, 'Resource2organizationFunding', 'resource_id'),
			'personas' => array(self::MANY_MANY, 'Persona', 'resource2persona(resource_id, persona_id)'),
			'resourceCategories' => array(self::MANY_MANY, 'ResourceCategory', 'resource2resource_category(resource_id, resource_category_id)'),
			'resourceGeofocuses' => array(self::MANY_MANY, 'ResourceGeofocus', 'resource2resource_geofocus(resource_id, resource_geofocus_id)'),
			'startupStages' => array(self::MANY_MANY, 'StartupStage', 'resource2startup_stage(resource_id, startup_stage_id)'),
			'tag2resources' => array(self::HAS_MANY, 'Tag2resource', 'resource_id'),

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
		'orid' => Yii::t('app', 'Orid'),
		'title' => Yii::t('app', 'Title'),
		'slug' => Yii::t('app', 'Slug'),
		'html_content' => Yii::t('app', 'Html Content'),
		'image_logo' => Yii::t('app', 'Image Logo'),
		'url_website' => Yii::t('app', 'Url Website'),
		'latlong_address' => Yii::t('app', 'Latlong Address'),
		'full_address' => Yii::t('app', 'Full Address'),
		'typefor' => Yii::t('app', 'Typefor'),
		'owner' => Yii::t('app', 'Owner'),
		'is_featured' => Yii::t('app', 'Is Featured'),
		'is_active' => Yii::t('app', 'Is Active'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'title_en' => Yii::t('app', 'Title [English]'),
		'title_ms' => Yii::t('app', 'Title [Bahasa]'),
		'html_content_en' => Yii::t('app', 'Html Content [English]'),
		'html_content_ms' => Yii::t('app', 'Html Content [Bahasa]'),
		'is_blocked' => Yii::t('app', 'Is Blocked'),
		);

 		$return['inputOrganizations'] = Yii::t('app', 'Organizations');
 		$return['inputIndustries'] = Yii::t('app', 'Industries');
 		$return['inputPersonas'] = Yii::t('app', 'Personas');
 		$return['inputStartupStages'] = Yii::t('app', 'Startup Stages');
 		$return['inputResourceCategories'] = Yii::t('app', 'Resource Categories');
 		$return['inputResourceGeofocuses'] = Yii::t('app', 'Geo Focus');

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
 		$criteria->compare('orid', $this->orid, true);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('slug', $this->slug, true);
 		$criteria->compare('html_content', $this->html_content, true);
 		$criteria->compare('image_logo', $this->image_logo, true);
 		$criteria->compare('url_website', $this->url_website, true);
 		$criteria->compare('latlong_address', $this->latlong_address, true);
 		$criteria->compare('full_address', $this->full_address, true);
 		$criteria->compare('typefor', $this->typefor);
 		$criteria->compare('owner', $this->owner, true);
 		$criteria->compare('is_featured', $this->is_featured);
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
 		$criteria->compare('title_en', $this->title_en, true);
 		$criteria->compare('title_ms', $this->title_ms, true);
 		$criteria->compare('html_content_en', $this->html_content_en, true);
 		$criteria->compare('html_content_ms', $this->html_content_ms, true);
 		$criteria->compare('is_blocked', $this->is_blocked);

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
 	}

 	public function toApi($params = array())
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'orid' => $this->orid,
			'title' => $this->title,
			'slug' => $this->slug,
			'htmlContent' => $this->html_content,
			'imageLogo' => $this->image_logo,
			'imageLogoThumbUrl' => $this->getImageLogoThumbUrl(),
			'imageLogoUrl' => $this->getImageLogoUrl(),
			'urlWebsite' => $this->url_website,
			'latlongAddress' => $this->latlong_address,
			'fullAddress' => $this->full_address,
			'typefor' => $this->typefor,
			'owner' => $this->owner,
			'isFeatured' => $this->is_featured,
			'isActive' => $this->is_active,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'titleEn' => $this->title_en,
			'titleMs' => $this->title_ms,
			'htmlContentEn' => $this->html_content_en,
			'htmlContentMs' => $this->html_content_ms,
			'isBlocked' => $this->is_blocked,
		);

 		// many2many
 		if (!in_array('-organizations', $params) && !empty($this->organizations)) {
 			foreach ($this->organizations as $organization) {
 				$return['organizations'][] = $organization->toApi(array('-resource'));
 			}
 		}
 		if (!in_array('-industries', $params) && !empty($this->industries)) {
 			foreach ($this->industries as $industry) {
 				$return['industries'][] = $industry->toApi(array('-resource'));
 			}
 		}
 		if (!in_array('-personas', $params) && !empty($this->personas)) {
 			foreach ($this->personas as $persona) {
 				$return['personas'][] = $persona->toApi(array('-resource'));
 			}
 		}
 		if (!in_array('-startupStages', $params) && !empty($this->startupStages)) {
 			foreach ($this->startupStages as $startupStage) {
 				$return['startupStages'][] = $startupStage->toApi(array('-resource'));
 			}
 		}
 		if (!in_array('-resourceCategories', $params) && !empty($this->resourceCategories)) {
 			foreach ($this->resourceCategories as $resourceCategory) {
 				$return['resourceCategories'][] = $resourceCategory->toApi(array('-resource'));
 			}
 		}
 		if (!in_array('-resourceGeofocuses', $params) && !empty($this->resourceGeofocuses)) {
 			foreach ($this->resourceGeofocuses as $resourceGeofocus) {
 				$return['resourceGeofocuses'][] = $resourceGeofocus->toApi(array('-resource'));
 			}
 		}

 		return $return;
 	}

 	//
 	// image
 	public function getImageLogoUrl()
 	{
 		if (!empty($this->image_logo)) {
 			return StorageHelper::getUrl($this->image_logo);
 		}
 	}

 	public function getImageLogoThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_logo)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_logo));
 		}
 	}

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

			'isFeatured' => array('condition' => 't.is_featured = 1'),
			'isActive' => array('condition' => 't.is_active = 1'),
			'isBlocked' => array('condition' => 't.is_blocked = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Resource the static model class
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
 		$this->saveInputOrganization();
 		$this->saveInputIndustry();
 		$this->saveInputPersona();
 		$this->saveInputStartupStage();
 		$this->saveInputResourceCategory();
 		$this->saveInputResourceGeofocus();

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

 			// save as null if empty
 			if (empty($this->orid)) {
 				$this->orid = null;
 			}
 			if (empty($this->image_logo)) {
 				$this->image_logo = null;
 			}
 			if (empty($this->url_website)) {
 				$this->url_website = null;
 			}
 			if (empty($this->latlong_address) && $this->latlong_address !== 0) {
 				$this->latlong_address = null;
 			}
 			if (empty($this->full_address)) {
 				$this->full_address = null;
 			}
 			if (empty($this->typefor)) {
 				$this->typefor = null;
 			}
 			if (empty($this->owner)) {
 				$this->owner = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->html_content_en)) {
 				$this->html_content_en = null;
 			}
 			if (empty($this->html_content_ms)) {
 				$this->html_content_ms = null;
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
 		if ($this->is_featured != '' || $this->is_featured != null) {
 			$this->is_featured = intval($this->is_featured);
 		}
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}
 		if ($this->is_blocked != '' || $this->is_blocked != null) {
 			$this->is_blocked = intval($this->is_blocked);
 		}

 		$this->jsonArray_extra = json_decode($this->json_extra);

 		$this->tag_backend = $this->backend->toString();

 		foreach ($this->organizations as $organization) {
 			$this->inputOrganizations[] = $organization->id;
 		}
 		foreach ($this->industries as $industry) {
 			$this->inputIndustries[] = $industry->id;
 		}
 		foreach ($this->personas as $persona) {
 			$this->inputPersonas[] = $persona->id;
 		}
 		foreach ($this->startupStages as $startup_stage) {
 			$this->inputStartupStages[] = $startup_stage->id;
 		}
 		foreach ($this->resourceCategories as $resource_category) {
 			$this->inputResourceCategories[] = $resource_category->id;
 		}
 		foreach ($this->resourceGeofocuses as $resource_geofocus) {
 			$this->inputResourceGeofocuses[] = $resource_geofocus->id;
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
				'tagBindingTable' => 'tag2resource',
				'modelTableFk' => 'resource_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Resource',
				'createTagsAutomatically' => true,
			)
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumTypefor($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumTypefor(''));
 		}

 		$result[] = array('code' => 'award', 'title' => $this->formatEnumTypefor('award'));
 		$result[] = array('code' => 'fund', 'title' => $this->formatEnumTypefor('fund'));
 		$result[] = array('code' => 'legislation', 'title' => $this->formatEnumTypefor('legislation'));
 		$result[] = array('code' => 'media', 'title' => $this->formatEnumTypefor('media'));
 		$result[] = array('code' => 'program', 'title' => $this->formatEnumTypefor('program'));
 		$result[] = array('code' => 'space', 'title' => $this->formatEnumTypefor('space'));
 		$result[] = array('code' => 'other', 'title' => $this->formatEnumTypefor('other'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumTypefor($code)
 	{
 		switch ($code) {
			case 'award': {return Yii::t('app', 'Award'); break;}

			case 'fund': {return Yii::t('app', 'Fund'); break;}

			case 'legislation': {return Yii::t('app', 'Legislation'); break;}

			case 'media': {return Yii::t('app', 'Media'); break;}

			case 'program': {return Yii::t('app', 'Program'); break;}

			case 'space': {return Yii::t('app', 'Space'); break;}

			case 'other': {return Yii::t('app', 'Others'); break;}
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
 	// organization
 	public function getAllOrganizationsKey()
 	{
 		$return = array();
 		if (!empty($this->organizations)) {
 			foreach ($this->organizations as $r) {
 				$return[] = $r->id;
 			}
 		}

 		return $return;
 	}

 	public function hasOrganization($key)
 	{
 		if (in_array($key, $this->getAllOrganizationsKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function hasNoOrganization($key)
 	{
 		if (!in_array($key, $this->getAllOrganizationsKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function removeOrganization($key)
 	{
 		if ($this->hasOrganization($key)) {
 			$many2many = Resource2Organization::model()->findByAttributes(array('resource_id' => $this->id, 'organization_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addOrganization($key)
 	{
 		if ($this->hasNoOrganization($key)) {
 			$many2many = new Resource2Organization;
 			$many2many->resource_id = $this->id;
 			$many2many->organization_id = $key;

 			return $many2many->save();
 		}

 		return false;
 	}

 	protected function saveInputOrganization()
 	{
 		// loop thru existing
 		foreach ($this->organizations as $r) {
 			// remove extra
 			if (!in_array($r->id, $this->inputOrganizations)) {
 				$this->removeOrganization($r->id);
 			}
 		}

 		// loop thru each input
 		foreach ($this->inputOrganizations as $input) {
 			// if currently dont have
 			if ($this->hasNoOrganization($input)) {
 				$this->addOrganization($input);
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
 			$many2many = Resource2Industry::model()->findByAttributes(array('resource_id' => $this->id, 'industry_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addIndustry($key)
 	{
 		if ($this->hasNoIndustry($key)) {
 			$many2many = new Resource2Industry;
 			$many2many->resource_id = $this->id;
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
 			$many2many = Resource2Persona::model()->findByAttributes(array('resource_id' => $this->id, 'persona_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addPersona($key)
 	{
 		if ($this->hasNoPersona($key)) {
 			$many2many = new Resource2Persona;
 			$many2many->resource_id = $this->id;
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
 			$many2many = Resource2StartupStage::model()->findByAttributes(array('resource_id' => $this->id, 'startup_stage_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addStartupStage($key)
 	{
 		if ($this->hasNoStartupStage($key)) {
 			$many2many = new Resource2StartupStage;
 			$many2many->resource_id = $this->id;
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

 	//
 	// resource_category
 	public function getAllResourceCategoriesKey()
 	{
 		$return = array();
 		if (!empty($this->resourceCategories)) {
 			foreach ($this->resourceCategories as $r) {
 				$return[] = $r->id;
 			}
 		}

 		return $return;
 	}

 	public function hasResourceCategory($key)
 	{
 		if (in_array($key, $this->getAllResourceCategoriesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function hasNoResourceCategory($key)
 	{
 		if (!in_array($key, $this->getAllResourceCategoriesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function removeResourceCategory($key)
 	{
 		if ($this->hasResourceCategory($key)) {
 			$many2many = ResourceCategory2Resource::model()->findByAttributes(array('resource_id' => $this->id, 'resource_category_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addResourceCategory($key)
 	{
 		if ($this->hasNoResourceCategory($key)) {
 			$many2many = new ResourceCategory2Resource;
 			$many2many->resource_id = $this->id;
 			$many2many->resource_category_id = $key;

 			return $many2many->save();
 		}

 		return false;
 	}

 	protected function saveInputResourceCategory()
 	{
 		// loop thru existing
 		foreach ($this->resourceCategories as $r) {
 			// remove extra
 			if (!in_array($r->id, $this->inputResourceCategories)) {
 				$this->removeResourceCategory($r->id);
 			}
 		}

 		// loop thru each input
 		foreach ($this->inputResourceCategories as $input) {
 			// if currently dont have
 			if ($this->hasNoResourceCategory($input)) {
 				$this->addResourceCategory($input);
 			}
 		}
 	}

 	//
 	// resource_geofocus
 	public function getAllResourceGeofocusesKey()
 	{
 		$return = array();
 		if (!empty($this->resourceGeofocuses)) {
 			foreach ($this->resourceGeofocuses as $r) {
 				$return[] = $r->id;
 			}
 		}

 		return $return;
 	}

 	public function hasResourceGeofocus($key)
 	{
 		if (in_array($key, $this->getAllResourceGeofocusesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function hasNoResourceGeofocus($key)
 	{
 		if (!in_array($key, $this->getAllResourceGeofocusesKey())) {
 			return true;
 		}

 		return false;
 	}

 	public function removeResourceGeofocus($key)
 	{
 		if ($this->hasResourceGeofocus($key)) {
 			$many2many = ResourceGeofocus2Resource::model()->findByAttributes(array('resource_id' => $this->id, 'resource_geofocus_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addResourceGeofocus($key)
 	{
 		if ($this->hasNoResourceGeofocus($key)) {
 			$many2many = new ResourceGeofocus2Resource;
 			$many2many->resource_id = $this->id;
 			$many2many->resource_geofocus_id = $key;

 			return $many2many->save();
 		}

 		return false;
 	}

 	protected function saveInputResourceGeofocus()
 	{
 		// loop thru existing
 		foreach ($this->resourceGeofocuses as $r) {
 			// remove extra
 			if (!in_array($r->id, $this->inputResourceGeofocuses)) {
 				$this->removeResourceGeofocus($r->id);
 			}
 		}

 		// loop thru each input
 		foreach ($this->inputResourceGeofocuses as $input) {
 			// if currently dont have
 			if ($this->hasNoResourceGeofocus($input)) {
 				$this->addResourceGeofocus($input);
 			}
 		}
 	}
 }
