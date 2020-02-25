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
 * This is the model class for table "organization".
 *
 * The followings are the available columns in table 'organization':
			 * @property integer $id
			 * @property string $code
			 * @property string $slug
			 * @property string $title
			 * @property string $text_oneliner
			 * @property string $html_content
			 * @property string $text_short_description
			 * @property integer $legalform_id
			 * @property string $company_number
			 * @property string $image_logo
			 * @property string $url_website
			 * @property string $email_contact
			 * @property string $timezone
			 * @property integer $year_founded
			 * @property integer $is_active
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property string $legal_name
			 * @property string $full_address
			 * @property string $address_line1
			 * @property string $address_line2
			 * @property string $address_zip
			 * @property string $address_city
			 * @property string $address_state
			 * @property string $address_country_code
			 * @property string $latlong_address
			 * @property double $score_completeness
 *
 * The followings are the available model relations:
 * @property EventOrganization[] $eventOrganizations
 * @property EventOwner[] $eventOwners
 * @property IdeaRfp[] $ideaRfps
 * @property IdeaRfp[] $ideaRfps1
 * @property IdeaWishlist[] $ideaWishlists
 * @property IdeaWishlist[] $ideaWishlists1
 * @property Impact[] $impacts
 * @property IndividualOrganization[] $individualOrganizations
 * @property Industry[] $industries
 * @property Milestone[] $milestones
 * @property Legalform $legalform
 * @property Organization2email[] $organization2emails
 * @property OrganizationFunding[] $organizationFundings
 * @property OrganizationFunding[] $organizationFundings1
 * @property OrganizationRevenue[] $organizationRevenues
 * @property OrganizationStatus[] $organizationStatuses
 * @property Persona[] $personas
 * @property Product[] $products
 * @property Resource[] $resources
 * @property Sdg[] $sdgs
 * @property Tag2Organization[] $tag2organizations
 * @property Vacancy[] $vacancies
 */
 class OrganizationBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $imageFile_logo;
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
 			$this->is_active = null;
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'organization';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, title', 'required'),
			array('legalform_id, year_founded, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('score_completeness', 'numerical'),
			array('code, slug, timezone', 'length', 'max' => 64),
			array('title, legal_name', 'length', 'max' => 100),
			array('text_oneliner', 'length', 'max' => 200),
			array('company_number', 'length', 'max' => 32),
			array('image_logo, url_website, email_contact, full_address', 'length', 'max' => 255),
			array('address_line1, address_line2, address_city, address_state', 'length', 'max' => 128),
			array('address_zip', 'length', 'max' => 16),
			array('address_country_code', 'length', 'max' => 2),
			array('html_content, text_short_description, latlong_address, tag_backend', 'safe'),
			array('imageFile_logo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, slug, title, text_oneliner, html_content, text_short_description, legalform_id, company_number, image_logo, url_website, email_contact, timezone, year_founded, is_active, date_added, date_modified, legal_name, full_address, address_line1, address_line2, address_zip, address_city, address_state, address_country_code, latlong_address, score_completeness, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend', 'safe', 'on' => 'search'),
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
			'eventOrganizations' => array(self::HAS_MANY, 'EventOrganization', 'organization_id'),
			'eventOwners' => array(self::HAS_MANY, 'EventOwner', 'organization_code'),
			'ideaRfps' => array(self::HAS_MANY, 'IdeaRfp', 'partner_organization_code'),
			'ideaRfps1' => array(self::MANY_MANY, 'IdeaRfp', 'idea_rfp2enterprise(enterprise_organization_code, idea_rfp_id)'),
			'ideaWishlists' => array(self::HAS_MANY, 'IdeaWishlist', 'partner_organization_code'),
			'ideaWishlists1' => array(self::HAS_MANY, 'IdeaWishlist', 'enterprise_organization_code'),
			'impacts' => array(self::MANY_MANY, 'Impact', 'impact2organization(organization_id, impact_id)'),
			'individualOrganizations' => array(self::HAS_MANY, 'IndividualOrganization', 'organization_code'),
			'industries' => array(self::MANY_MANY, 'Industry', 'industry2organization(organization_id, industry_id)'),
			'milestones' => array(self::HAS_MANY, 'Milestone', 'organization_id'),
			'legalform' => array(self::BELONGS_TO, 'Legalform', 'legalform_id'),
			'organization2emails' => array(self::HAS_MANY, 'Organization2email', 'organization_id'),
			'organizationFundings' => array(self::HAS_MANY, 'OrganizationFunding', 'organization_id'),
			'organizationFundings1' => array(self::HAS_MANY, 'OrganizationFunding', 'vc_organization_id'),
			'organizationRevenues' => array(self::HAS_MANY, 'OrganizationRevenue', 'organization_id'),
			'organizationStatuses' => array(self::HAS_MANY, 'OrganizationStatus', 'organization_id'),
			'personas' => array(self::MANY_MANY, 'Persona', 'persona2organization(organization_id, persona_id)'),
			'products' => array(self::HAS_MANY, 'Product', 'organization_id'),
			'resources' => array(self::MANY_MANY, 'Resource', 'resource2organization(organization_id, resource_id)'),
			'sdgs' => array(self::MANY_MANY, 'Sdg', 'sdg2organization(organization_id, sdg_id)'),
			'tag2Organizations' => array(self::HAS_MANY, 'Tag2Organization', 'organization_id'),
			'vacancies' => array(self::HAS_MANY, 'Vacancy', 'organization_id'),
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
		'title' => Yii::t('app', 'Title'),
		'text_oneliner' => Yii::t('app', 'Text Oneliner'),
		'html_content' => Yii::t('app', 'Html Content'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'legalform_id' => Yii::t('app', 'Legalform'),
		'company_number' => Yii::t('app', 'Company Number'),
		'image_logo' => Yii::t('app', 'Image Logo'),
		'url_website' => Yii::t('app', 'Url Website'),
		'email_contact' => Yii::t('app', 'Email Contact'),
		'timezone' => Yii::t('app', 'Timezone'),
		'year_founded' => Yii::t('app', 'Year Founded'),
		'is_active' => Yii::t('app', 'Is Active'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'legal_name' => Yii::t('app', 'Legal Name'),
		'full_address' => Yii::t('app', 'Full Address'),
		'address_line1' => Yii::t('app', 'Address Line1'),
		'address_line2' => Yii::t('app', 'Address Line2'),
		'address_zip' => Yii::t('app', 'Address Zip'),
		'address_city' => Yii::t('app', 'Address City'),
		'address_state' => Yii::t('app', 'Address State'),
		'address_country_code' => Yii::t('app', 'Address Country Code'),
		'latlong_address' => Yii::t('app', 'Latlong Address'),
		'score_completeness' => Yii::t('app', 'Score Completeness'),
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
 		$criteria->compare('code', $this->code, true);
 		$criteria->compare('slug', $this->slug, true);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('text_oneliner', $this->text_oneliner, true);
 		$criteria->compare('html_content', $this->html_content, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('legalform_id', $this->legalform_id);
 		$criteria->compare('company_number', $this->company_number, true);
 		$criteria->compare('image_logo', $this->image_logo, true);
 		$criteria->compare('url_website', $this->url_website, true);
 		$criteria->compare('email_contact', $this->email_contact, true);
 		$criteria->compare('timezone', $this->timezone, true);
 		$criteria->compare('year_founded', $this->year_founded);
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
 		$criteria->compare('legal_name', $this->legal_name, true);
 		$criteria->compare('full_address', $this->full_address, true);
 		$criteria->compare('address_line1', $this->address_line1, true);
 		$criteria->compare('address_line2', $this->address_line2, true);
 		$criteria->compare('address_zip', $this->address_zip, true);
 		$criteria->compare('address_city', $this->address_city, true);
 		$criteria->compare('address_state', $this->address_state, true);
 		$criteria->compare('address_country_code', $this->address_country_code, true);
 		$criteria->compare('latlong_address', $this->latlong_address, true);
 		$criteria->compare('score_completeness', $this->score_completeness);

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
 	}

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'slug' => $this->slug,
			'title' => $this->title,
			'textOneliner' => $this->text_oneliner,
			'htmlContent' => $this->html_content,
			'textShortDescription' => $this->text_short_description,
			'legalformId' => $this->legalform_id,
			'companyNumber' => $this->company_number,
			'imageLogo' => $this->image_logo,
			'imageLogoThumbUrl' => $this->getImageLogoThumbUrl(),
			'imageLogoUrl' => $this->getImageLogoUrl(),
			'urlWebsite' => $this->url_website,
			'emailContact' => $this->email_contact,
			'timezone' => $this->timezone,
			'yearFounded' => $this->year_founded,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'legalName' => $this->legal_name,
			'fullAddress' => $this->full_address,
			'addressLine1' => $this->address_line1,
			'addressLine2' => $this->address_line2,
			'addressZip' => $this->address_zip,
			'addressCity' => $this->address_city,
			'addressState' => $this->address_state,
			'addressCountryCode' => $this->address_country_code,
			'latlong_address' => $this->latlong_address,
			'scoreCompleteness' => $this->score_completeness,
		);

 		// many2many

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

			'isActive' => array('condition' => 't.is_active = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Organization the static model class
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
 		$this->saveInputImpact();
 		$this->saveInputSdg();
 		$this->saveInputIndustry();
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
 			if ($this->address_country_code == '') {
 				$this->address_country_code = null;
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// save as null if empty
 			if (empty($this->slug)) {
 				$this->slug = null;
 			}
 			if (empty($this->text_oneliner)) {
 				$this->text_oneliner = null;
 			}
 			if (empty($this->html_content)) {
 				$this->html_content = null;
 			}
 			if (empty($this->text_short_description)) {
 				$this->text_short_description = null;
 			}
 			if (empty($this->legalform_id) && $this->legalform_id !== 0) {
 				$this->legalform_id = null;
 			}
 			if (empty($this->company_number)) {
 				$this->company_number = null;
 			}
 			if (empty($this->image_logo)) {
 				$this->image_logo = null;
 			}
 			if (empty($this->url_website)) {
 				$this->url_website = null;
 			}
 			if (empty($this->email_contact)) {
 				$this->email_contact = null;
 			}
 			if (empty($this->timezone)) {
 				$this->timezone = null;
 			}
 			if (empty($this->year_founded) && $this->year_founded !== 0) {
 				$this->year_founded = null;
 			}
 			if (empty($this->legal_name)) {
 				$this->legal_name = null;
 			}
 			if (empty($this->full_address)) {
 				$this->full_address = null;
 			}
 			if (empty($this->address_line1)) {
 				$this->address_line1 = null;
 			}
 			if (empty($this->address_line2)) {
 				$this->address_line2 = null;
 			}
 			if (empty($this->address_zip)) {
 				$this->address_zip = null;
 			}
 			if (empty($this->address_city)) {
 				$this->address_city = null;
 			}
 			if (empty($this->address_state)) {
 				$this->address_state = null;
 			}
 			if (empty($this->address_country_code)) {
 				$this->address_country_code = null;
 			}
 			if (empty($this->latlong_address) && $this->latlong_address !== 0) {
 				$this->latlong_address = null;
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

 		$this->tag_backend = $this->backend->toString();

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
				'tagBindingTable' => 'tag2organization',
				'modelTableFk' => 'organization_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Organization',
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
 		$exists = Organization::model()->find('code=:code', array(':code' => $code));
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
 }
