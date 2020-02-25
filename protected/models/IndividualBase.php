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
 * This is the model class for table "individual".
 *
 * The followings are the available columns in table 'individual':
			 * @property integer $id
			 * @property string $full_name
			 * @property string $gender
			 * @property string $image_photo
			 * @property string $country_code
			 * @property string $state_code
			 * @property string $ic_number
			 * @property string $text_address_residential
			 * @property string $mobile_number
			 * @property integer $can_code
			 * @property integer $is_bumi
			 * @property integer $is_active
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property State $state
 * @property Individual2email[] $individual2emails
 * @property IndividualOrganization[] $individualOrganizations
 * @property Persona[] $personas
 * @property Tag2Individual[] $tag2Individuals
 */
 class IndividualBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	// m2m
 	public $inputPersonas;

 	public $imageFile_photo;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// tag
 	public $tag_backend;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();

 		if ($this->scenario == 'search') {
 			$this->is_bumi = null;
 			$this->is_active = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'individual';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('full_name', 'required'),
			array('can_code, is_bumi, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('full_name, mobile_number', 'length', 'max' => 128),
			array('gender, state_code', 'length', 'max' => 6),
			array('image_photo', 'length', 'max' => 255),
			array('country_code', 'length', 'max' => 2),
			array('ic_number', 'length', 'max' => 64),
			array('text_address_residential, tag_backend, inputPersonas', 'safe'),
			array('imageFile_photo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, full_name, gender, image_photo, country_code, state_code, ic_number, text_address_residential, mobile_number, can_code, is_bumi, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend', 'safe', 'on' => 'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_code'),
			'state' => array(self::BELONGS_TO, 'State', 'state_code'),
			'individual2emails' => array(self::HAS_MANY, 'Individual2email', 'individual_id'),
			'individualOrganizations' => array(self::HAS_MANY, 'IndividualOrganization', 'individual_id'),
			'personas' => array(self::MANY_MANY, 'Persona', 'persona2individual(individual_id, persona_id)'),
			'tag2Individuals' => array(self::HAS_MANY, 'Tag2individual', 'individual_id'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		$return = array(
		'id' => Yii::t('app', 'ID'),
		'full_name' => Yii::t('app', 'Full Name'),
		'gender' => Yii::t('app', 'Gender'),
		'image_photo' => Yii::t('app', 'Image Photo'),
		'country_code' => Yii::t('app', 'Country Code'),
		'state_code' => Yii::t('app', 'State Code'),
		'ic_number' => Yii::t('app', 'Ic Number'),
		'text_address_residential' => Yii::t('app', 'Text Address Residential'),
		'mobile_number' => Yii::t('app', 'Mobile Number'),
		'can_code' => Yii::t('app', 'Can Code'),
		'is_bumi' => Yii::t('app', 'Is Bumi'),
		'is_active' => Yii::t('app', 'Is Active'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);

 		$return['inputPersonas'] = Yii::t('app', 'Personas');

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
 		$criteria->compare('full_name', $this->full_name, true);
 		$criteria->compare('gender', $this->gender);
 		$criteria->compare('image_photo', $this->image_photo, true);
 		$criteria->compare('country_code', $this->country_code, true);
 		$criteria->compare('state_code', $this->state_code, true);
 		$criteria->compare('ic_number', $this->ic_number, true);
 		$criteria->compare('text_address_residential', $this->text_address_residential, true);
 		$criteria->compare('mobile_number', $this->mobile_number, true);
 		$criteria->compare('can_code', $this->can_code);
 		$criteria->compare('is_bumi', $this->is_bumi);
 		$criteria->compare('is_active', $this->is_active);
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
			'fullName' => $this->full_name,
			'gender' => $this->gender,
			'imagePhoto' => $this->image_photo,
			'imagePhotoThumbUrl' => $this->getImagePhotoThumbUrl(),
			'imagePhotoUrl' => $this->getImagePhotoUrl(),
			'countryCode' => $this->country_code,
			'stateCode' => $this->state_code,
			'icNumber' => $this->ic_number,
			'textAddressResidential' => $this->text_address_residential,
			'mobileNumber' => $this->mobile_number,
			'canCode' => $this->can_code,
			'isBumi' => $this->is_bumi,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

 		// many2many
 		if (!in_array('-personas', $params) && !empty($this->personas)) {
 			foreach ($this->personas as $persona) {
 				$return['personas'][] = $persona->toApi(array('-individual'));
 			}
 		}

 		return $return;
 	}

 	//
 	// image
 	public function getImagePhotoUrl()
 	{
 		if (!empty($this->image_photo)) {
 			return StorageHelper::getUrl($this->image_photo);
 		}
 	}

 	public function getImagePhotoThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_photo)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_photo));
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

			'isBumi' => array('condition' => 't.is_bumi = 1'),
			'isActive' => array('condition' => 't.is_active = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Individual the static model class
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
 		$this->saveInputPersona();

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
 			if ($this->country_code == '') {
 				$this->country_code = null;
 			}
 			if ($this->state_code == '') {
 				$this->state_code = null;
 			}
 			if ($this->can_code == '') {
 				$this->can_code = null;
 			}
 			if ($this->is_bumi == '') {
 				$this->is_bumi = null;
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// save as null if empty
 			if (empty($this->gender)) {
 				$this->gender = null;
 			}
 			if (empty($this->image_photo)) {
 				$this->image_photo = null;
 			}
 			if (empty($this->country_code)) {
 				$this->country_code = null;
 			}
 			if (empty($this->state_code)) {
 				$this->state_code = null;
 			}
 			if (empty($this->ic_number)) {
 				$this->ic_number = null;
 			}
 			if (empty($this->text_address_residential)) {
 				$this->text_address_residential = null;
 			}
 			if (empty($this->mobile_number)) {
 				$this->mobile_number = null;
 			}
 			if (empty($this->can_code) && $this->can_code !== 0) {
 				$this->can_code = null;
 			}
 			if (empty($this->is_bumi) && $this->is_bumi !== 0) {
 				$this->is_bumi = null;
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
 		if ($this->is_bumi != '' || $this->is_bumi != null) {
 			$this->is_bumi = intval($this->is_bumi);
 		}
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}

 		$this->tag_backend = $this->backend->toString();

 		foreach ($this->personas as $persona) {
 			$this->inputPersonas[] = $persona->id;
 		}

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
			'backend' => array(
				'class' => 'application.yeebase.extensions.taggable-behavior.ETaggableBehavior',
				'tagTable' => 'tag',
				'tagBindingTable' => 'tag2individual',
				'modelTableFk' => 'individual_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Individual',
				'createTagsAutomatically' => true,
			)
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumGender($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumGender(''));
 		}

 		$result[] = array('code' => 'male', 'title' => $this->formatEnumGender('male'));
 		$result[] = array('code' => 'female', 'title' => $this->formatEnumGender('female'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumGender($code)
 	{
 		switch ($code) {
			case 'male': {return Yii::t('app', 'Male'); break;}

			case 'female': {return Yii::t('app', 'Female'); break;}
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
 		$result = Yii::app()->db->createCommand()->select('id as key, full_name as title')->from(self::tableName())->queryAll();
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
 			$many2many = Persona2Individual::model()->findByAttributes(array('individual_id' => $this->id, 'persona_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addPersona($key)
 	{
 		if ($this->hasNoPersona($key)) {
 			$many2many = new Persona2Individual;
 			$many2many->individual_id = $this->id;
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
 }
