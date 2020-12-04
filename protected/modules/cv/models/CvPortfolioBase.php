<?php


/**
 * This is the model class for table "cv_portfolio".
 *
 * The followings are the available columns in table 'cv_portfolio':
			 * @property integer $id
			 * @property integer $user_id
			 * @property string $slug
			 * @property integer $cv_jobpos_id
			 * @property string $organization_name
			 * @property string $location
			 * @property string $text_address_residential
			 * @property string $latlong_address_residential
			 * @property string $state_code
			 * @property string $country_code
			 * @property string $display_name
			 * @property string $image_avatar
			 * @property integer $high_academy_experience_id
			 * @property integer $current_job_experience_id
			 * @property string $text_oneliner
			 * @property string $text_short_description
			 * @property integer $is_looking_fulltime
			 * @property integer $is_looking_contract
			 * @property integer $is_looking_freelance
			 * @property integer $is_looking_cofounder
			 * @property integer $is_looking_internship
			 * @property integer $is_looking_apprenticeship
			 * @property string $visibility
			 * @property integer $is_active
			 * @property string $json_social
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property CvExperience[] $cvExperiences
 * @property Country $country
 * @property CvExperience $highAcademyExperience
 * @property CvExperience $currentJobExperience
 * @property CvJobposGroup $jobpos
 * @property State $state
 * @property User $user
 */
 class CvPortfolioBase extends ActiveRecord
 {
 	public $uploadPath;

 	public $imageFile_avatar;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// json
 	public $jsonArray_extra;
 	public $jsonArray_social;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

 		if ($this->scenario == 'search') {
 			$this->is_looking_fulltime = null;
 			$this->is_looking_contract = null;
 			$this->is_looking_freelance = null;
 			$this->is_looking_cofounder = null;
 			$this->is_looking_internship = null;
 			$this->is_looking_apprenticeship = null;
 			$this->is_active = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'cv_portfolio';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('user_id, display_name', 'required'),
			array('user_id, cv_jobpos_id, high_academy_experience_id, current_job_experience_id, is_looking_fulltime, is_looking_contract, is_looking_freelance, is_looking_cofounder, is_looking_internship, is_looking_apprenticeship, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('slug', 'length', 'max' => 100),
			array('organization_name, location, display_name, image_avatar', 'length', 'max' => 255),
			array('state_code', 'length', 'max' => 12),
			array('country_code', 'length', 'max' => 2),
			array('text_oneliner', 'length', 'max' => 200),
			array('visibility', 'length', 'max' => 9),
			array('text_address_residential, latlong_address_residential, text_short_description', 'safe'),
			array('imageFile_avatar', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, slug, cv_jobpos_id, organization_name, location, text_address_residential, latlong_address_residential, state_code, country_code, display_name, image_avatar, high_academy_experience_id, current_job_experience_id, text_oneliner, text_short_description, is_looking_fulltime, is_looking_contract, is_looking_freelance, is_looking_cofounder, is_looking_internship, is_looking_apprenticeship, visibility, is_active, json_social, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'cvExperiences' => array(self::HAS_MANY, 'CvExperience', 'cv_portfolio_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_code'),
			'highAcademyExperience' => array(self::BELONGS_TO, 'CvExperience', 'high_academy_experience_id'),
			'currentJobExperience' => array(self::BELONGS_TO, 'CvExperience', 'current_job_experience_id'),
			'jobpos' => array(self::BELONGS_TO, 'CvJobposGroup', 'cv_jobpos_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_code'),
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
		'user_id' => Yii::t('app', 'User'),
		'slug' => Yii::t('app', 'Slug'),
		'cv_jobpos_id' => Yii::t('app', 'Jobpos'),
		'organization_name' => Yii::t('app', 'Organization Name'),
		'location' => Yii::t('app', 'Location'),
		'text_address_residential' => Yii::t('app', 'Text Address Residential'),
		'latlong_address_residential' => Yii::t('app', 'Latlong Address Residential'),
		'state_code' => Yii::t('app', 'State Code'),
		'country_code' => Yii::t('app', 'Country Code'),
		'display_name' => Yii::t('app', 'Display Name'),
		'image_avatar' => Yii::t('app', 'Image Avatar'),
		'high_academy_experience_id' => Yii::t('app', 'High Academy Experience'),
		'current_job_experience_id' => Yii::t('app', 'Current Job Experience'),
		'text_oneliner' => Yii::t('app', 'Text Oneliner'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'is_looking_fulltime' => Yii::t('app', 'Is Looking Fulltime'),
		'is_looking_contract' => Yii::t('app', 'Is Looking Contract'),
		'is_looking_freelance' => Yii::t('app', 'Is Looking Freelance'),
		'is_looking_cofounder' => Yii::t('app', 'Is Looking Cofounder'),
		'is_looking_internship' => Yii::t('app', 'Is Looking Internship'),
		'is_looking_apprenticeship' => Yii::t('app', 'Is Looking Apprenticeship'),
		'visibility' => Yii::t('app', 'Visibility'),
		'is_active' => Yii::t('app', 'Is Active'),
		'json_social' => Yii::t('app', 'Json Social'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
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
 		$criteria->compare('user_id', $this->user_id);
 		$criteria->compare('slug', $this->slug, true);
 		$criteria->compare('cv_jobpos_id', $this->cv_jobpos_id);
 		$criteria->compare('organization_name', $this->organization_name, true);
 		$criteria->compare('location', $this->location, true);
 		$criteria->compare('text_address_residential', $this->text_address_residential, true);
 		$criteria->compare('latlong_address_residential', $this->latlong_address_residential, true);
 		$criteria->compare('state_code', $this->state_code, true);
 		$criteria->compare('country_code', $this->country_code, true);
 		$criteria->compare('display_name', $this->display_name, true);
 		$criteria->compare('image_avatar', $this->image_avatar, true);
 		$criteria->compare('high_academy_experience_id', $this->high_academy_experience_id);
 		$criteria->compare('current_job_experience_id', $this->current_job_experience_id);
 		$criteria->compare('text_oneliner', $this->text_oneliner, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('is_looking_fulltime', $this->is_looking_fulltime);
 		$criteria->compare('is_looking_contract', $this->is_looking_contract);
 		$criteria->compare('is_looking_freelance', $this->is_looking_freelance);
 		$criteria->compare('is_looking_cofounder', $this->is_looking_cofounder);
 		$criteria->compare('is_looking_internship', $this->is_looking_internship);
 		$criteria->compare('is_looking_apprenticeship', $this->is_looking_apprenticeship);
 		$criteria->compare('visibility', $this->visibility);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('json_social', $this->json_social, true);
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
			'userId' => $this->user_id,
			'slug' => $this->slug,
			'cvJobposId' => $this->cv_jobpos_id,
			'organizationName' => $this->organization_name,
			'location' => $this->location,
			'textAddressResidential' => $this->text_address_residential,
			'latlongAddressResidential' => $this->latlong_address_residential,
			'stateCode' => $this->state_code,
			'countryCode' => $this->country_code,
			'displayName' => $this->display_name,
			'imageAvatar' => $this->image_avatar,
			'imageAvatarThumbUrl' => $this->getImageAvatarThumbUrl(),
			'imageAvatarUrl' => $this->getImageAvatarUrl(),
			'highAcademyExperienceId' => $this->high_academy_experience_id,
			'currentJobExperienceId' => $this->current_job_experience_id,
			'textOneliner' => $this->text_oneliner,
			'textShortDescription' => $this->text_short_description,
			'isLookingFulltime' => $this->is_looking_fulltime,
			'isLookingContract' => $this->is_looking_contract,
			'isLookingFreelance' => $this->is_looking_freelance,
			'isLookingCofounder' => $this->is_looking_cofounder,
			'isLookingInternship' => $this->is_looking_internship,
			'isLookingApprenticeship' => $this->is_looking_apprenticeship,
			'visibility' => $this->visibility,
			'isActive' => $this->is_active,
			'jsonSocial' => $this->json_social,
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
 	public function getImageAvatarUrl()
 	{
 		if (!empty($this->image_avatar)) {
 			return StorageHelper::getUrl($this->image_avatar);
 		}
 	}

 	public function getImageAvatarThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_avatar)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_avatar));
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

			'isLookingFulltime' => array('condition' => 't.is_looking_fulltime = 1'),
			'isLookingContract' => array('condition' => 't.is_looking_contract = 1'),
			'isLookingFreelance' => array('condition' => 't.is_looking_freelance = 1'),
			'isLookingCofounder' => array('condition' => 't.is_looking_cofounder = 1'),
			'isLookingInternship' => array('condition' => 't.is_looking_internship = 1'),
			'isLookingApprenticeship' => array('condition' => 't.is_looking_apprenticeship = 1'),
			'isActive' => array('condition' => 't.is_active = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return CvPortfolio the static model class
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
 			Neo4jCvPortfolio::model($this)->sync();
 		}

 		return parent::afterSave();
 	}

 	protected function afterDelete()
 	{
 		// custom code here
 		// ...
 		if (Yii::app()->neo4j->getStatus()) {
 			Neo4jCvPortfolio::model()->deleteOneByPk($this->id);
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
 			if ($this->state_code == '') {
 				$this->state_code = null;
 			}
 			if ($this->country_code == '') {
 				$this->country_code = null;
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
 			$this->json_social = json_encode($this->jsonArray_social);
 			if ($this->json_social == 'null') {
 				$this->json_social = null;
 			}

 			// save as null if empty
 			if (empty($this->slug)) {
 				$this->slug = null;
 			}
 			if (empty($this->cv_jobpos_id) && $this->cv_jobpos_id !== 0) {
 				$this->cv_jobpos_id = null;
 			}
 			if (empty($this->organization_name)) {
 				$this->organization_name = null;
 			}
 			if (empty($this->location)) {
 				$this->location = null;
 			}
 			if (empty($this->text_address_residential)) {
 				$this->text_address_residential = null;
 			}
 			if (empty($this->latlong_address_residential) && $this->latlong_address_residential !== 0) {
 				$this->latlong_address_residential = null;
 			}
 			if (empty($this->state_code)) {
 				$this->state_code = null;
 			}
 			if (empty($this->country_code)) {
 				$this->country_code = null;
 			}
 			if (empty($this->image_avatar)) {
 				$this->image_avatar = null;
 			}
 			if (empty($this->high_academy_experience_id) && $this->high_academy_experience_id !== 0) {
 				$this->high_academy_experience_id = null;
 			}
 			if (empty($this->current_job_experience_id) && $this->current_job_experience_id !== 0) {
 				$this->current_job_experience_id = null;
 			}
 			if (empty($this->text_oneliner)) {
 				$this->text_oneliner = null;
 			}
 			if (empty($this->text_short_description)) {
 				$this->text_short_description = null;
 			}
 			if (empty($this->visibility)) {
 				$this->visibility = null;
 			}
 			if (empty($this->json_social)) {
 				$this->json_social = null;
 			}
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
 		if ($this->is_looking_fulltime != '' || $this->is_looking_fulltime != null) {
 			$this->is_looking_fulltime = intval($this->is_looking_fulltime);
 		}
 		if ($this->is_looking_contract != '' || $this->is_looking_contract != null) {
 			$this->is_looking_contract = intval($this->is_looking_contract);
 		}
 		if ($this->is_looking_freelance != '' || $this->is_looking_freelance != null) {
 			$this->is_looking_freelance = intval($this->is_looking_freelance);
 		}
 		if ($this->is_looking_cofounder != '' || $this->is_looking_cofounder != null) {
 			$this->is_looking_cofounder = intval($this->is_looking_cofounder);
 		}
 		if ($this->is_looking_internship != '' || $this->is_looking_internship != null) {
 			$this->is_looking_internship = intval($this->is_looking_internship);
 		}
 		if ($this->is_looking_apprenticeship != '' || $this->is_looking_apprenticeship != null) {
 			$this->is_looking_apprenticeship = intval($this->is_looking_apprenticeship);
 		}
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}

 		$this->jsonArray_extra = json_decode($this->json_extra);
 		$this->jsonArray_social = json_decode($this->json_social);

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
			'spatial' => array(
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => array(
					// all spatial fields here
					'latlong_address_residential'
				),
			),
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumVisibility($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumVisibility(''));
 		}

 		$result[] = array('code' => 'public', 'title' => $this->formatEnumVisibility('public'));
 		$result[] = array('code' => 'protected', 'title' => $this->formatEnumVisibility('protected'));
 		$result[] = array('code' => 'private', 'title' => $this->formatEnumVisibility('private'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumVisibility($code)
 	{
 		switch ($code) {
			case 'public': {return Yii::t('app', 'Public'); break;}

			case 'protected': {return Yii::t('app', 'Protected'); break;}

			case 'private': {return Yii::t('app', 'Private'); break;}
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
 		$result = Yii::app()->db->createCommand()->select('id as key, display_name as title')->from(self::tableName())->queryAll();
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

 	public function setLatLongAddressResidential($pos)
 	{
 		if (!empty($pos)) {
 			if (is_array($pos)) {
 				$this->latlong_address_residential = $pos;
 			} else {
 				$this->latlong_address_residential = self::latLngString2Flat($pos);
 			}
 		}
 	}
 }
