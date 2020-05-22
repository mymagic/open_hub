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

class Organization extends OrganizationBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public $inputImpacts;
	public $inputSdgs;
	public $imageRemote_logo;
	public $inputPersonas;
	public $inputIndustries;
	public $inputCountries;
	public $searchAccessEmails;
	public $inputBackendTags;
	public $searchBackendTags;
	public $searchIndividual;

	public function behaviors()
	{
		$return = array(
			'spatial' => array(
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => array(
					'latlong_address',
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
			),
		);

		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['Organization'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['Organization'];
				$return[$moduleKey]['model'] = $this;
			}
		}

		return $return;
	}

	public function init()
	{
		// meta
		$this->initMetaStructure($this->tableName());
		parent::init();
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$return = array(
			array('code, title', 'required'),
			array('legalform_id, year_founded, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('score_completeness', 'numerical'),
			array('code, slug, timezone', 'length', 'max' => 64),
			array('title, legal_name', 'length', 'max' => 100),
			array('text_oneliner', 'length', 'max' => 200),
			array('company_number', 'length', 'max' => 32),
			array('address_line1, address_line2, address_city, address_state', 'length', 'max' => 128),
			array('address_zip', 'length', 'max' => 16),
			array('address_country_code', 'length', 'max' => 2),
			array('image_logo, url_website, email_contact, full_address', 'length', 'max' => 255),
			array('text_oneliner, text_short_description, html_content, inputImpacts, inputSdgs, inputPersonas, inputIndustries, tag_backend', 'safe'),
			array('imageFile_logo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),

			/*array('title', 'validateTitle', 'on'=>array('create', 'createIdeaPartner', 'createIdeaEnterprise', 'createIdeaOrganization')),
			array('email_contact', 'required', 'on'=>array('createIdeaPartner',  'updateIdeaPartner', 'createIdeaOrganization', 'updateIdeaOrganization')),
			array('email_contact, text_oneliner, legalform_id, company_number', 'required', 'on'=>array('createIdeaEnterprise', 'updateIdeaEnterprise', 'createIdeaOrganization', 'updateIdeaOrganization')),*/

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, slug, timezone, title, text_oneliner, text_short_description, html_content, legalform_id, year_founded, company_number, image_logo, url_website, email_contact, is_active, date_added, date_modified, legal_name, full_address, address_line1, address_line2, address_zip, address_city, address_state, address_country_code, latlong_address, score_completeness, sdate_added, edate_added, sdate_modified, edate_modified,
			inputPersonas, inputIndustries, inputImpacts, inputSdgs, inputCountries, searchAccessEmails, searchBackendTags, inputBackendTags, searchIndividual', 'safe', 'on' => 'search'),
		);
		// meta
		$return[] = array('_dynamicData', 'safe');

		return $return;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'country' => array(self::BELONGS_TO, 'Country', array('address_country_code' => 'code')),
			'addressCountry' => array(self::BELONGS_TO, 'Country', 'address_country_code'),
			//'addressState' => array(self::BELONGS_TO, 'State', 'address_state_code'),

			'legalform' => array(self::BELONGS_TO, 'Legalform', 'legalform_id'),
			'organization2Emails' => array(self::HAS_MANY, 'Organization2Email', 'organization_id'),
			'products' => array(self::HAS_MANY, 'Product', 'organization_id'),
			'activeProducts' => array(self::HAS_MANY, 'Product', 'organization_id', 'condition' => 'is_active=1'),
			'vacancies' => array(self::HAS_MANY, 'Vacancy', 'organization_id'),
			'charges' => array(self::HAS_MANY, 'Charge', array('charge_to_code' => 'code'), 'condition' => "charges.charge_to='organization'"),
			'activeCharges' => array(self::HAS_MANY, 'Charge', array('charge_to_code' => 'code'), 'condition' => "activeCharges.charge_to='organization' AND activeCharges.is_active=1"),
			'pendingActiveCharges' => array(self::HAS_MANY, 'Charge', array('charge_to_code' => 'code'), 'condition' => "pendingActiveCharges.charge_to='organization' AND pendingActiveCharges.status='pending' AND pendingActiveCharges.is_active=1"),

			'sentNotifies' => array(self::HAS_MANY, 'Notify', array('sender_id' => 'id'), 'condition' => "sentNotifies.sender_type='organization'"),
			'receivedNotifies' => array(self::HAS_MANY, 'Notify', array('receiver_id' => 'id'), 'condition' => "receivedNotifies.receiver_type='organization'"),

			// m2m
			'impacts' => array(self::MANY_MANY, 'Impact', 'impact2organization(organization_id, impact_id)'),
			'sdgs' => array(self::MANY_MANY, 'Sdg', 'sdg2organization(organization_id, sdg_id)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'persona2organization(organization_id, persona_id)'),
			'industries' => array(self::MANY_MANY, 'Industry', 'industry2organization(organization_id, industry_id)'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),

			// idea
			// 'ideaRfps' => array(self::HAS_MANY, 'IdeaRfp', array('partner_organization_code' => 'code')),
			// 'ideaActiveRfps' => array(self::HAS_MANY, 'IdeaRfp', array('partner_organization_code' => 'code'), 'condition' => "ideaActiveRfps.status != 'cancel'"),

			// todo: ideaRfps2Enterprise relationship was disabled but need to enable for organization merge feature, not sure will it affect performance or not
			//'ideaRfps2Enterprise' => array(self::HAS_MANY, 'IdeaRfp2Enterprise', array('enterprise_organization_code'=>'code')),

			// resource
			'resources' => array(self::MANY_MANY, 'Resource', 'resource2organization(organization_id, resource_id)'),

			'activeResources' => array(self::MANY_MANY, 'Resource', 'resource2organization(organization_id, resource_id)', 'condition' => "is_active='1' AND is_blocked='0'"),

			// event
			'eventOrganizations' => array(self::HAS_MANY, 'EventOrganization', 'organization_id'),

			'eventOrganizationsSelectedParticipant' => array(self::HAS_MANY, 'EventOrganization', 'organization_id', 'condition' => "eventOrganizationsSelectedParticipant.as_role_code = 'selectedParticipant'"),

			// individual
			'individualOrganizations' => array(self::HAS_MANY, 'IndividualOrganization', 'organization_code'),
			'individuals' => array(self::HAS_MANY, 'Individual', array('individual_id' => 'id'), 'through' => 'individualOrganizations'),

			// todo:
			// 'eventOwners' => array(self::HAS_MANY, 'EventOwner', 'organization_code'),

			'activeDisclosedOrganizationFundings' => array(self::HAS_MANY, 'OrganizationFunding', 'organization_id', 'condition' => "is_active='1' AND is_publicized='1'"),
			'activeOrganizationFundings' => array(self::HAS_MANY, 'OrganizationFunding', 'organization_id', 'condition' => "is_active='1'"),
			'organizationFundings' => array(self::HAS_MANY, 'OrganizationFunding', 'organization_id'),
			'organizationRevenues' => array(self::HAS_MANY, 'OrganizationRevenue', 'organization_id'),
			'organizationStatuses' => array(self::HAS_MANY, 'OrganizationStatus', 'organization_id', 'order' => 'date_reported DESC'),

			'milestones' => array(self::HAS_MANY, 'Milestone', 'organization_id'),

			// tags
			'tag2Organizations' => array(self::HAS_MANY, 'Tag2Organization', 'organization_id'),
			'tags' => array(self::HAS_MANY, 'Tag', array('tag_id' => 'id'), 'through' => 'tag2Organizations'),
		);
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();
		$return['title'] = Yii::t('app', 'Organization Name');
		$return['company_number'] = Yii::t('app', 'Company Reg. No');
		$return['text_oneliner'] = Yii::t('app', 'One Liner');
		$return['text_short_description'] = Yii::t('app', 'Organization Description');
		$return['image_logo'] = Yii::t('app', 'Logo Image');
		$return['url_website'] = Yii::t('app', 'Website URL');
		$return['email_contact'] = Yii::t('app', 'Organization Email');
		$return['legalform_id'] = Yii::t('app', 'Type of Organization');
		$return['inputImpacts'] = Yii::t('app', 'Impacts');
		$return['inputSdgs'] = Yii::t('app', 'Sdgs');
		$return['inputPersonas'] = Yii::t('app', 'Personas');
		$return['inputIndustries'] = Yii::t('app', 'Industries');
		$return['inputCountries'] = Yii::t('app', 'Countries');
		$return['searchAccessEmails'] = Yii::t('app', 'Emails');
		$return['searchBackendTags'] = Yii::t('app', 'Backend Tags');
		$return['inputBackendTags'] = Yii::t('app', 'Backend Tags');
		$return['score_completeness'] = Yii::t('app', 'Profile Completeness Score');
		$return['address_country_code'] = Yii::t('app', 'Address Country');

		$return['backend'] = Yii::t('app', 'Backend Tags');

		// meta
		$return = array_merge($return, array_keys($this->_dynamicFields));
		foreach ($this->_metaStructures as $metaStruct) {
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}

		return $return;
	}

	public function beforeValidate()
	{
		if ($this->isNewRecord) {
			// UUID
			$this->code = strtolower(ysUtil::generateUUID());
		} else {
			// UUID
			if (empty($this->code)) {
				$this->code = strtolower(ysUtil::generateUUID());
			}
		}

		return parent::beforeValidate();
	}

	protected function beforeSave()
	{
		$this->title = trim($this->title);
		$completenessResult = $this->calcProfileCompletenessScore();
		$this->score_completeness = $completenessResult['score'];

		// fix url_website
		if (!empty(trim($this->url_website))) {
			$parsedUrl = parse_url($this->url_website);
			if (empty($parsedUrl['scheme'])) {
				$this->url_website = 'http://' . ltrim($this->url_website, '/');
			}
		}

		return parent::beforeSave();
	}

	public function title2obj($title)
	{
		// exiang: spent 3 hrs on the single quote around title. it's important if you passing data from different collation db table columns and do compare with = (equal). Changed to LIKE for safer comparison
		return Organization::model()->find('t.title=:title', array(':title' => trim($title)));
	}

	public function isTitleExists($title)
	{
		$exists = self::title2obj($title);
		if ($exists === null) {
			return false;
		}

		return $exists->id;
	}

	public function validateTitle($attributes, $params)
	{
		if ($organizationId = $this->isTitleExists($this->title)) {
			$errorMessage = !empty($params['message']) ? $params['message'] : sprintf('Organization with identical title already exists, you are not allowed to create duplicate.');
			$this->addError($attributes, $errorMessage);
		}
	}

	public function afterSave()
	{
		return parent::afterSave();
	}

	// case insensitive
	public function hasUserEmail($email)
	{
		foreach ($this->organization2Emails as $item) {
			if (strtolower($email) == strtolower($item->user_email)) {
				return true;
			}
		}

		return false;
	}

	public function canJoinByUserEmail($email)
	{
		if ($this->hasUserEmail($email)) {
			return false;
		}

		return true;
	}

	public function canAccessByUser($user)
	{
		foreach ($this->organization2Emails as $item) {
			if ($user->username == $item->user_email && $item->status == 'approve') {
				return true;
			}
		}

		return false;
	}

	public function canAccessByUserEmail($userEmail)
	{
		foreach ($this->organization2Emails as $item) {
			if ($userEmail == $item->user_email && $item->status == 'approve') {
				return true;
			}
		}

		return false;
	}

	public function code2obj($code)
	{
		$obj = self::model()->find('t.code=:code', array(':code' => $code));
		if (!empty($obj)) {
			return $obj;
		}
	}

	public function slug2obj($slug)
	{
		$obj = self::model()->find('t.slug=:slug', array(':slug' => $slug));
		if (!empty($obj)) {
			return $obj;
		}
	}

	protected function afterFind()
	{
		if (empty($this->image_logo)) {
			$this->image_logo = $this->getDefaultImageLogo();
		}
		foreach ($this->impacts as $impact) {
			$this->inputImpacts[] = $impact->id;
		}
		foreach ($this->sdgs as $sdg) {
			$this->inputSdgs[] = $sdg->id;
		}
		foreach ($this->personas as $persona) {
			$this->inputPersonas[] = $persona->id;
		}
		foreach ($this->industries as $industry) {
			$this->inputIndustries[] = $industry->id;
		}

		parent::afterFind();
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes();

		$this->title = $keyword;
		$this->text_oneliner = $keyword;
		$this->text_short_description = $keyword;
		$this->legal_name = $keyword;
		$this->url_website = $keyword;
		$this->searchBackendTags = array($keyword);
		$this->searchIndividual = $keyword;

		$tmp = $this->search(array('compareOperator' => 'OR', 'activeOnly' => true));
		$tmp->sort->defaultOrder = 't.is_active DESC, t.title ASC';

		return $tmp;
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria;
		$criteria->together = true;

		$criteria->compare('t.id', $this->id, false, $params['compareOperator']);
		$criteria->compare('t.code', $this->code, true, $params['compareOperator']);
		$criteria->compare('t.slug', $this->slug, true, $params['compareOperator']);
		$criteria->compare('t.title', $this->title, true, $params['compareOperator']);
		$criteria->compare('t.text_oneliner', $this->text_oneliner, true, $params['compareOperator']);
		$criteria->compare('t.text_short_description', $this->text_short_description, true, $params['compareOperator']);
		$criteria->compare('t.legalform_id', $this->legalform_id, false, $params['compareOperator']);
		$criteria->compare('t.company_number', $this->company_number, true, $params['compareOperator']);
		$criteria->compare('t.url_website', $this->url_website, true, $params['compareOperator']);
		if ($params['activeOnly']) {
			$criteria->compare('t.is_active', 1, false, 'AND');
		} else {
			$criteria->compare('t.is_active', $this->is_active, false, $params['compareOperator']);
		}

		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('t.date_added >= %s AND t.date_added < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('t.date_modified >= %s AND t.date_modified < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}

		$criteria->compare('t.legal_name', $this->legal_name, true, $params['compareOperator']);
		$criteria->compare('t.year_founded', $this->year_founded, false, $params['compareOperator']);
		$criteria->compare('t.full_address', $this->full_address, true, $params['compareOperator']);
		$criteria->compare('t.address_line1', $this->address_line1, true, $params['compareOperator']);
		$criteria->compare('t.address_line2', $this->address_line2, true, $params['compareOperator']);
		$criteria->compare('t.address_zip', $this->address_zip, true, $params['compareOperator']);
		$criteria->compare('t.address_city', $this->address_city, true, $params['compareOperator']);
		$criteria->compare('t.address_state', $this->address_state, true, $params['compareOperator']);
		$criteria->compare('t.address_country_code', $this->address_country_code, true, $params['compareOperator']);
		$criteria->compare('t.latlong_address', $this->latlong_address, true, $params['compareOperator']);
		$criteria->compare('t.score_completeness', $this->score_completeness, false, $params['compareOperator']);

		if ($this->inputPersonas !== null) {
			$criteriaPersona = new CDbCriteria;
			$criteriaPersona->together = true;
			$criteriaPersona->with = array('personas');
			foreach ($this->inputPersonas as $persona) {
				$criteriaPersona->addCondition(sprintf('personas.id=%s', trim($persona)), 'OR');
			}
			$criteria->mergeWith($criteriaPersona, $params['compareOperator']);
		}

		if ($this->inputIndustries !== null) {
			$criteriaIndustry = new CDbCriteria;
			$criteriaIndustry->together = true;
			$criteriaIndustry->with = array('industries');
			foreach ($this->inputIndustries as $industry) {
				$criteriaIndustry->addCondition(sprintf('industries.id=%s', trim($industry)), 'OR');
			}
			$criteria->mergeWith($criteriaIndustry, $params['compareOperator']);
		}

		if ($this->inputImpacts !== null) {
			$criteriaImpact = new CDbCriteria;
			$criteriaImpact->together = true;
			$criteriaImpact->with = array('impacts');
			foreach ($this->inputImpacts as $impact) {
				$criteriaImpact->addCondition(sprintf('impacts.id=%s', trim($impact)), 'OR');
			}
			$criteria->mergeWith($criteriaImpact, $params['compareOperator']);
		}

		if ($this->inputSdgs !== null) {
			$criteriaSdg = new CDbCriteria;
			$criteriaSdg->together = true;
			$criteriaSdg->with = array('sdgs');
			foreach ($this->inputSdgs as $sdg) {
				$criteriaSdg->addCondition(sprintf('sdgs.id=%s', trim($sdg)), 'OR');
			}
			$criteria->mergeWith($criteriaSdg, $params['compareOperator']);
		}

		if ($this->inputCountries !== null) {
			$criteriaCountry = new CDbCriteria;
			$criteriaCountry->together = true;
			$criteriaCountry->with = array('country');
			foreach ($this->inputCountries as $country) {
				$criteriaCountry->addCondition(sprintf('country.code=%s', trim($country)), 'OR');
			}
			$criteria->mergeWith($criteriaCountry, $params['compareOperator']);
		}

		if ($this->searchAccessEmails !== null) {
			$criteriaAccessEmail = new CDbCriteria;
			$criteriaAccessEmail->together = true;
			$criteriaAccessEmail->with = array('organization2Emails');
			foreach ($this->searchAccessEmails as $accessEmail) {
				$criteriaAccessEmail->addSearchCondition('organization2Emails.user_email', trim($accessEmail), true, 'OR');
			}
			$criteria->mergeWith($criteriaAccessEmail, $params['compareOperator']);
		}

		if ($this->searchIndividual !== null) {
			$criteriaIndividual = new CDbCriteria;
			$criteriaIndividual->together = true;
			$criteriaIndividual->with = array('individuals');
			$criteriaIndividual->addSearchCondition('full_name', trim($this->searchIndividual), true, 'OR');
			$criteria->mergeWith($criteriaIndividual, $params['compareOperator']);
		}

		if ($this->searchBackendTags !== null) {
			$criteriaBackendTag = new CDbCriteria;
			$criteriaBackendTag->together = true;
			$criteriaBackendTag->with = array('tags');
			foreach ($this->searchBackendTags as $backendTag) {
				$criteriaBackendTag->addSearchCondition('name', trim($backendTag), true, 'OR');
			}
			$criteria->mergeWith($criteriaBackendTag, $params['compareOperator']);
		}
		if ($this->inputBackendTags !== null) {
			$criteriaInputBackendTag = new CDbCriteria;
			$criteriaInputBackendTag->together = true;
			$criteriaInputBackendTag->with = array('tag2Organizations');
			foreach ($this->inputBackendTags as $backendTag) {
				$criteriaInputBackendTag->addCondition(sprintf('tag2Organizations.tag_id=%s', trim($backendTag)), 'OR');
			}
			$criteria->mergeWith($criteriaInputBackendTag, $params['compareOperator']);
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 30),
			'sort' => array(
				'defaultOrder' => 't.title ASC',
			),
		));
	}

	public function toApi($params = array())
	{
		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'slug' => $this->slug,
			'title' => $this->title,
			'textOneliner' => $this->text_oneliner,
			'textShortDescription' => $this->text_short_description,
			'htmlContent' => $this->html_content,
			'legalformId' => $this->legalform_id,
			'companyNumber' => $this->company_number,
			'imageLogo' => $this->image_logo,
			'imageLogoThumbUrl' => $this->getImageLogoThumbUrl(),
			'imageLogoUrl' => $this->getImageLogoUrl(),
			'urlWebsite' => $this->url_website,
			'emailContact' => $this->email_contact,
			'yearFounded' => $this->year_founded,
			'timezone' => $this->timezone,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'legalName' => $this->legal_name,
			'fullAddress' => $this->full_address,
			'addressline1' => $this->address_line1,
			'addressLine2' => $this->address_line2,
			'addressZip' => $this->address_zip,
			'addressCity' => $this->address_city,
			'addressState' => $this->address_state,
			'addressCountryCode' => $this->address_country_code,
			'latlong_address' => $this->latlong_address,
			'lat' => !empty($this->latlong_address) ? $this->latlong_address[0] : '',
			'lng' => !empty($this->latlong_address) ? $this->latlong_address[1] : '',
			'fDisclosedFunding' => $this->sumActiveDisclosedFunding(),
			'fPublicDisplayStatus' => $this->getPublicDisplayStatus('text')
		);

		if (!empty($params['config']['mode']) && $params['config']['mode'] != 'public') {
			$set = array(
				'scoreCompleteness' => $this->score_completeness,
				'urlBackendView' => Yii::app()->createAbsoluteUrl('/organization/view', array('id' => $this->id)),
			);
			$return = array_merge($return, $set);
		}

		if (!in_array('-products', $params) && !empty($this->products)) {
			foreach ($this->products as $product) {
				if (isset($params['config'])) {
					if (!empty($params['config']['mode']) && $params['config']['mode'] != 'public') {
						if ($product->is_active != 1) {
							continue;
						}
					}
				}
				$return['products'][] = $product->toApi(array('-organization', $params['config']));
			}
		}
		if (!in_array('-impacts', $params) && !empty($this->impacts)) {
			foreach ($this->impacts as $impact) {
				$return['impacts'][] = $impact->toApi(array('-organizations', $params['config']));
			}
		}
		if (!in_array('-sdgs', $params) && !empty($this->sdgs)) {
			foreach ($this->sdgs as $sdg) {
				$return['sdgs'][] = $sdg->toApi(array('-organizations', $params['config']));
			}
		}
		if (!in_array('-personas', $params) && !empty($this->personas)) {
			foreach ($this->personas as $persona) {
				$return['personas'][] = $persona->toApi(array('-organizations', $params['config']));
			}
		}
		if (!in_array('-industries', $params) && !empty($this->industries)) {
			foreach ($this->industries as $industry) {
				$return['industries'][] = $industry->toApi(array('-organizations', $params['config']));
			}
		}
		if (!in_array('-individualOrganizations', $params) && !empty($this->individualOrganizations)) {
			foreach ($this->individualOrganizations as $individualOrganization) {
				$return['individualOrganizations'][] = $individualOrganization->toApi(array('-organization', $params['config']));
			}
		}
		if (!in_array('-eventOrganizations', $params) && !empty($this->eventOrganizations)) {
			foreach ($this->eventOrganizations as $eventOrganization) {
				$return['eventOrganizations'][] = $eventOrganization->toApi(array('-organizations', $params['config']));
			}
		}
		if (!in_array('-eventOrganizationsSelectedParticipant', $params) && !empty($this->eventOrganizationsSelectedParticipant)) {
			foreach ($this->eventOrganizationsSelectedParticipant as $eventOrganization) {
				$return['eventOrganizationsSelectedParticipant'][] = $eventOrganization->toApi(array('-organizations', $params['config']));
			}
		}

		return $return;
	}

	public function getImageLogoUrl()
	{
		return StorageHelper::getUrl($this->image_logo);
	}

	public function getImageLogoThumbUrl($width = 100, $height = 100)
	{
		return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_logo));
	}

	public function getDefaultImageLogo()
	{
		return 'uploads/organization/logo.default.jpg';
	}

	public function isDefaultImageLogo()
	{
		if ($this->image_logo == $this->getDefaultImageLogo()) {
			return true;
		}

		return false;
	}

	public function renderDateAdded()
	{
		return Html::formatDateTimezone($this->date_added, 'standard', 'standard', '-', $this->getTimezone());
	}

	public function renderDateModified()
	{
		return Html::formatDateTimezone($this->date_modified, 'standard', 'standard', '-', $this->getTimezone());
	}

	public function getTimezone()
	{
		return date_default_timezone_get();
	}

	//
	// notify
	public function getMobileNo()
	{
		return '';
	}

	public function getFullName()
	{
		return $this->title;
	}

	public function getEmail()
	{
		return $this->email_contact;
	}

	public function canReceiveSms()
	{
		return false;
	}

	public function canReceiveEmail()
	{
		return !empty($this->getEmail()) ? true : false;
	}

	//
	// impact
	public function getAllImpactsKey()
	{
		$return = array();
		if (!empty($this->impacts)) {
			foreach ($this->impacts as $impact) {
				$return[] = $impact->id;
			}
		}

		return $return;
	}

	public function hasImpact($key)
	{
		if (in_array($key, $this->getAllImpactsKey())) {
			return true;
		}

		return false;
	}

	public function hasNoImpact($key)
	{
		if (!in_array($key, $this->getAllImpactsKey())) {
			return true;
		}

		return false;
	}

	public function removeImpact($key)
	{
		if ($this->hasImpact($key)) {
			$many2many = Impact2Organization::model()->findByAttributes(array('organization_id' => $this->id, 'impact_id' => $key));

			return $many2many->delete();
		}

		return false;
	}

	public function addImpact($key)
	{
		if ($this->hasNoImpact($key)) {
			$many2many = new Impact2Organization;
			$many2many->organization_id = $this->id;
			$many2many->impact_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputImpact()
	{
		// loop thru existing
		foreach ($this->impacts as $impact) {
			// remove extra
			if (!in_array($impact->id, $this->inputImpacts)) {
				$this->removeImpact($impact->id);
			}
		}

		// loop thru each input
		if (!empty($this->inputImpacts)) {
			foreach ($this->inputImpacts as $inputImpact) {
				// if currently dont have
				if ($this->hasNoImpact($inputImpact)) {
					$this->addImpact($inputImpact);
				}
			}
		}
	}

	//
	// sdg
	public function getAllSdgsKey()
	{
		$return = array();
		if (!empty($this->sdgs)) {
			foreach ($this->sdgs as $sdg) {
				$return[] = $sdg->id;
			}
		}

		return $return;
	}

	public function hasSdg($key)
	{
		if (in_array($key, $this->getAllSdgsKey())) {
			return true;
		}

		return false;
	}

	public function hasNoSdg($key)
	{
		if (!in_array($key, $this->getAllSdgsKey())) {
			return true;
		}

		return false;
	}

	public function removeSdg($key)
	{
		if ($this->hasSdg($key)) {
			$many2many = Sdg2Organization::model()->findByAttributes(array('organization_id' => $this->id, 'sdg_id' => $key));
			if (!empty($many2many)) {
				return $many2many->delete();
			}
		}

		return false;
	}

	public function addSdg($key)
	{
		if ($this->hasNoSdg($key)) {
			$many2many = new Sdg2Organization;
			$many2many->organization_id = $this->id;
			$many2many->sdg_id = $key;

			return $many2many->save();
		}

		return false;
	}

	public function clearSdgs()
	{
		return Sdg2Organization::model()->deleteAll('organization_id=:organizationId', array(':organizationId' => $this->id));
	}

	protected function saveInputSdg()
	{
		// loop thru existing
		if (!empty($this->sdgs)) {
			foreach ($this->sdgs as $sdg) {
				// remove extra
				if (!in_array($sdg->id, $this->inputSdgs)) {
					$this->removeSdg($sdg->id);
				}
			}
		}

		// loop thru each input
		if (!empty($this->inputSdgs)) {
			foreach ($this->inputSdgs as $inputSdg) {
				// if currently dont have
				if ($this->hasNoSdg($inputSdg)) {
					$this->addSdg($inputSdg);
				}
			}
		}
	}

	//
	// persona
	public function getAllPersonasKey()
	{
		$return = array();
		if (!empty($this->personas)) {
			foreach ($this->personas as $persona) {
				$return[] = $persona->id;
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
			$many2many = Persona2Organization::model()->findByAttributes(array('organization_id' => $this->id, 'persona_id' => $key));

			return $many2many->delete();
		}

		return false;
	}

	public function addPersona($key)
	{
		if ($this->hasNoPersona($key)) {
			$many2many = new Persona2Organization;
			$many2many->organization_id = $this->id;
			$many2many->persona_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputPersona()
	{
		// loop thru existing
		foreach ($this->personas as $persona) {
			// remove extra
			if (!in_array($persona->id, $this->inputPersonas)) {
				$this->removePersona($persona->id);
			}
		}

		// loop thru each input
		if (is_array($this->inputPersonas) || is_object($this->inputPersonas)) {
			foreach ($this->inputPersonas as $inputPersona) {
				// if currently dont have
				if ($this->hasNoPersona($inputPersona)) {
					$this->addPersona($inputPersona);
				}
			}
		}
	}

	//
	// industry
	public function getAllIndustrysKey()
	{
		$return = array();
		if (!empty($this->industries)) {
			foreach ($this->industries as $industry) {
				$return[] = $industry->id;
			}
		}

		return $return;
	}

	public function hasIndustry($key)
	{
		if (in_array($key, $this->getAllIndustrysKey())) {
			return true;
		}

		return false;
	}

	public function hasNoIndustry($key)
	{
		if (!in_array($key, $this->getAllIndustrysKey())) {
			return true;
		}

		return false;
	}

	public function removeIndustry($key)
	{
		if ($this->hasIndustry($key)) {
			$many2many = Industry2Organization::model()->findByAttributes(array('organization_id' => $this->id, 'industry_id' => $key));

			return $many2many->delete();
		}

		return false;
	}

	public function addIndustry($key)
	{
		if ($this->hasNoIndustry($key)) {
			$many2many = new Industry2Organization;
			$many2many->organization_id = $this->id;
			$many2many->industry_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputIndustry()
	{
		// loop thru existing
		foreach ($this->industries as $industry) {
			// remove extra
			if (!in_array($industry->id, $this->inputIndustries)) {
				$this->removeIndustry($industry->id);
			}
		}

		// loop thru each input
		if (!empty($this->inputIndustries)) {
			foreach ($this->inputIndustries as $inputIndustry) {
				// if currently dont have
				if ($this->hasNoIndustry($inputIndustry)) {
					$this->addIndustry($inputIndustry);
				}
			}
		}
	}

	//
	// event organization
	public function getAllEventOrganizationsKey()
	{
		$return = array();
		if (!empty($this->eventOrganizations)) {
			foreach ($this->eventOrganizations as $eo) {
				$return[] = sprintf('%s-%s', $eo->event_code, $eo->as_role_code);
			}
		}

		return $return;
	}

	public function hasNoEventOrganization($eventCode, $asRoleCode)
	{
		$key = sprintf('%s-%s', $eventCode, $asRoleCode);
		if (!in_array($key, $this->getAllEventOrganizationsKey())) {
			return true;
		}

		return false;
	}

	public function hasEventOrganization($eventCode, $asRoleCode)
	{
		$key = sprintf('%s-%s', $eventCode, $asRoleCode);
		if (in_array($key, $this->getAllEventOrganizationsKey())) {
			return true;
		}

		return false;
	}

	public function addEventOrganization($eventCode, $asRoleCode, $extra = '')
	{
		if ($this->hasNoEventOrganization($eventCode, $asRoleCode)) {
			$eo = new EventOrganization;
			$eo->organization_id = $this->id;
			$eo->organization_name = $this->title;
			$eo->as_role_code = $asRoleCode;
			$eo->event_code = $eventCode;

			if (!empty($extra) && !empty($extra['eventId'])) {
				$eo->event_id = $extra['eventId'];
			}
			if (!empty($extra) && !empty($extra['eventVendorCode'])) {
				$eo->event_vendor_code = $extra['eventVendorCode'];
			}
			if (!empty($extra) && !empty($extra['registrationCode'])) {
				$eo->registration_code = $extra['registrationCode'];
			}
			if (!empty($extra) && !empty($extra['dateAction'])) {
				$eo->date_action = $extra['dateAction'];
			}

			return $eo->validate() && $eo->save();
		}

		return false;
	}

	//
	// individual organization
	public function getAllIndividualOrganizationsKey()
	{
		$return = array();
		if (!empty($this->individualOrganizations)) {
			foreach ($this->individualOrganizations as $eo) {
				$return[] = sprintf('%s-%s', $eo->individual_id, $eo->as_role_code);
			}
		}

		return $return;
	}

	public function hasNoIndividualOrganization($individualId, $asRoleCode)
	{
		$key = sprintf('%s-%s', $individualId, $asRoleCode);
		if (!in_array($key, $this->getAllIndividualOrganizationsKey())) {
			return true;
		}

		return false;
	}

	public function hasIndividualOrganization($individualId, $asRoleCode)
	{
		$key = sprintf('%s-%s', $individualId, $asRoleCode);
		if (in_array($key, $this->getAllIndividualOrganizationsKey())) {
			return true;
		}

		return false;
	}

	public function addIndividualOrganization($individualId, $asRoleCode, $extra = '')
	{
		if ($this->hasNoIndividualOrganization($individualId, $asRoleCode)) {
			$eo = new IndividualOrganization;
			$eo->organization_code = $this->code;
			$eo->as_role_code = $asRoleCode;
			$eo->individual_id = $individualId;

			if (!empty($extra) && !empty($extra['jobPosition'])) {
				$eo->job_position = $extra['jobPosition'];
			}
			if (!empty($extra) && !empty($extra['dateStarted'])) {
				$eo->date_started = $extra['dateStarted'];
			}
			if (!empty($extra) && !empty($extra['dateEnded'])) {
				$eo->date_ended = $extra['dateEnded'];
			}

			return $eo->validate() && $eo->save();
		}

		return false;
	}

	//
	//
	public function getForeignReferList($isNullable = false, $is4Filter = false, $htmlOptions = '')
	{
		$language = Yii::app()->language;

		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('key' => '', 'title' => '');
		}

		/*if (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'ideaPartnerCode') {
			$sql = sprintf("SELECT o.code as `key`, o.title as `title` FROM `organization` as o

			INNER JOIN `meta_structure` as ms1 on ms1.ref_table='organization'
			INNER JOIN `meta_item` as mi1 on mi1.meta_structure_id=ms1.id

			INNER JOIN `meta_structure` as ms2 on ms2.ref_table='organization'
			INNER JOIN `meta_item` as mi2 on mi2.meta_structure_id=ms2.id
			WHERE
			(ms1.code='Organization-idea-isPartner' AND mi1.value=1 AND mi1.ref_id=o.id) AND
			(ms2.code='Organization-idea-isApplyPartner' AND mi2.value!=1 AND mi2.ref_id=o.id)
			 AND o.is_active=1
			GROUP BY o.id ORDER BY o.title ASC");

			$result = Yii::app()->db->createCommand($sql)->queryAll();
		} elseif (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'ideaEnterpriseCode') {
			$sql = sprintf("SELECT o.code as `key`, o.title as `title` FROM `organization` as o

			INNER JOIN `meta_structure` as ms1 on ms1.ref_table='organization'
			INNER JOIN `meta_item` as mi1 on mi1.meta_structure_id=ms1.id

			INNER JOIN `meta_structure` as ms2 on ms2.ref_table='organization'
			INNER JOIN `meta_item` as mi2 on mi2.meta_structure_id=ms2.id
			WHERE
			(ms1.code='Organization-idea-isEnterprise' AND mi1.value=1 AND mi1.ref_id=o.id) AND
			(ms2.code='Organization-idea-isApplyEnterprise' AND mi2.value!=1 AND mi2.ref_id=o.id)
			 AND o.is_active=1
			GROUP BY o.id ORDER BY o.title ASC");

			$result = Yii::app()->db->createCommand($sql)->queryAll();
		} else*/if (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'isActiveCode') {
			$result = Yii::app()->db->createCommand()->select('code as key, title as title')->from(self::tableName())->order(array('title ASC'))->where('is_active=:isActive', array(':isActive' => 1))->queryAll();
		} elseif (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'code') {
			$result = Yii::app()->db->createCommand()->select('code as key, title as title')->from(self::tableName())->order(array('title ASC'))->queryAll();
		} elseif (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'isActiveId') {
			$result = Yii::app()->db->createCommand()->select('id as key, title as title')->from(self::tableName())->order(array('title ASC'))->where('is_active=:isActive', array(':isActive' => 1))->queryAll();
		} else {
			$result = Yii::app()->db->createCommand()->select('id as key, title as title')->from(self::tableName())->order(array('title ASC'))->queryAll();
		}

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	public function calcProfileCompletenessScore()
	{
		$result = array();

		$score = 0;

		if (!empty($this->title)) {
			$score += 20;
		} else {
			$result['check']['title'] = Yii::t('app', 'Organization Name');
		}

		if (!empty($this->text_oneliner)) {
			$score += 10;
		} else {
			$result['check']['text_oneliner'] = Yii::t('app', 'One Liner');
		}

		if (!empty($this->image_logo) && $this->image_logo != $this->getDefaultImageLogo()) {
			$score += 15;
		} else {
			$result['check']['image_logo'] = Yii::t('app', 'Logo Image');
		}

		if (!empty($this->url_website)) {
			$score += 15;
		} else {
			$result['check']['url_website'] = Yii::t('app', 'Website URL');
		}

		if (!empty($this->email_contact)) {
			$score += 15;
		} else {
			$result['check']['email_contact'] = Yii::t('app', 'Organization Email');
		}

		if (!empty($this->text_short_description)) {
			$score += 15;
		} else {
			$result['check']['text_short_description'] = Yii::t('app', 'Organization Description');
		}

		// industries
		if (!empty($this->inputIndustries)) {
			$score += 10;
		} else {
			$result['check']['inputIndustries'] = Yii::t('app', 'Industries');
		}

		$result['score'] = $score;

		return $result;
	}

	// reset address part base on full_address
	// remember to call save() explicitly after calling this
	public function resetAddressParts()
	{
		if (!empty($this->full_address)) {
			$addressParts = HubGeo::geocoder2AddressParts(HubGeo::address2Geocoder($this->full_address));
			$this->address_line1 = $addressParts['line1'];
			$this->address_line2 = $addressParts['line2'];
			$this->address_zip = $addressParts['zipcode'];
			if (!empty($addressParts['city'])) {
				$this->address_city = $addressParts['city'];
			}
			if (!empty($addressParts['state'])) {
				$this->address_state = $addressParts['state'];
			}
			if (!empty($addressParts['countryCode'])) {
				$this->address_country_code = $addressParts['countryCode'];
			}
			$this->setLatLongAddress(array($addressParts['lat'], $addressParts['lng']));
		}
	}

	// assume is unique
	// dateRaised in unix timestamp format
	// return the record if found
	public function hasRevenueRecorded($yearReported, $amount, $source, $dateRaised = '')
	{
		if (!empty($dateRaised)) {
			return OrganizationRevenue::model()->find('year_reported=:yearReported AND amount=:amount AND source=:source AND date_raised=:dateRaised', array(':yearReported' => $yearReported, ':amount' => $amount, ':source' => $source, ':dateRaised' => $dateRaised));
		} else {
			return OrganizationRevenue::model()->find('year_reported=:yearReported AND amount=:amount AND source=:source', array(':yearReported' => $yearReported, ':amount' => $amount, ':source' => $source));
		}

		return false;
	}

	// assume is unique
	// dateRaised in unix timestamp format
	// return the record if found
	// 'seed','preSeriesA','seriesA','seriesB','seriesC','seriesD','seriesE','seriesF','debt','grant','equityCrowdfunding','crowdfunding'
	public function hasFundingRecorded($amount, $source, $roundTypeCode, $dateRaised = '')
	{
		if (!empty($dateRaised)) {
			return OrganizationFunding::model()->find('amount=:amount AND source=:source AND round_type_code=:roundTypeCode AND date_raised=:dateRaised', array(':amount' => $amount, ':source' => $source, ':roundTypeCode' => $roundTypeCode, ':dateRaised' => $dateRaised));
		} else {
			return OrganizationFunding::model()->find('year_reported=:yearReported AND amount=:amount AND source=:source AND round_type_code=:roundTypeCode', array(':amount' => $amount, ':source' => $source, ':roundTypeCode' => $roundTypeCode));
		}

		return false;
	}

	// todo: refer to issue CEN2-1379
	public function sumActiveDisclosedFunding()
	{
		$total = 0;
		foreach ($this->activeDisclosedOrganizationFundings as $funding) {
			$total += $funding->amount;
		}

		return $total;
	}

	public function getPublicDisplayStatus($outputFormat = 'text')
	{
		if ($this->is_active) {
			foreach ($this->organizationStatuses as $organizationStatus) {
				if ($organizationStatus->status == 'inactive') {
					return Yii::t('app', 'Inactive');
				}
			}

			// todo: active now, check the funding stage
			// 'seed','preSeriesA','seriesA','seriesB','seriesC','seriesD','seriesE','seriesF','debt','grant','equityCrowdfunding','crowdfunding'
			return Yii::t('app', 'Active');
		}

		return Yii::t('app', 'Inactive');
	}
}
