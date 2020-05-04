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

class Event extends EventBase
{
	// tag
	public $tag_backend;
	public $inputBackendTags;
	public $searchBackendTags;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		// custom code here
		// ...
		parent::init();

		// return void
	}

	public function beforeValidate()
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate()
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...
		if (Yii::app()->neo4j->getStatus()) {
			Neo4jEvent::model($this)->sync();
		}

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...

		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		// custom code here
		// ...

		parent::afterFind();

		// return void
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['code, title, date_started, vendor', 'required'],
			['date_started, date_ended, is_paid_event, is_cancelled, is_active, is_survey_enabled, date_added, date_modified', 'numerical', 'integerOnly' => true],
			['code, event_group_code, vendor_code', 'length', 'max' => 64],
			['title, genre, funnel', 'length', 'max' => 128],
			['url_website, at, full_address, email_contact', 'length', 'max' => 255],
			['vendor', 'length', 'max' => 32],
			array('address_zip', 'length', 'max' => 16),
			array('address_line1, address_line2, address_city, address_state', 'length', 'max' => 128),
			['address_country_code', 'length', 'max' => 2],
			['address_state_code', 'length', 'max' => 6],
			['text_short_desc, latlong_address, tag_backend, inputIndustries, inputPersonas, inputStartupStages', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, code, event_group_code, title, text_short_desc, url_website, date_started, date_ended, is_paid_event, genre, funnel, vendor, vendor_code, at, address_country_code, address_state_code, full_address, address_line1, address_line2, address_zip, address_city, address_state, latlong_address, email_contact, is_cancelled, is_active, is_survey_enabled,, json_original, json_extra, date_added, date_modified, sdate_started, edate_started, sdate_ended, edate_ended, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend, inputBackendTags, searchBackendTags', 'safe', 'on' => 'search'],
			// meta
			['_dynamicData', 'safe'],
		];
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');
		$return['event_group_code'] = Yii::t('app', 'Event Group');
		$return['text_short_desc'] = Yii::t('app', 'Short Description');
		$return['url_website'] = Yii::t('app', 'Website URL');
		$return['backend'] = Yii::t('app', 'Backend Tags');
		$return['vendor_code'] = Yii::t('app', 'Vendor Reference Code');
		$return['at'] = Yii::t('app', 'At Location');
		$return['address_country_code'] = Yii::t('app', 'Address Country');
		$return['address_state_code'] = Yii::t('app', 'Address State');
		$return['latlong_address'] = Yii::t('app', 'Address Location');
		$return['email_contact'] = Yii::t('app', 'Contact Email');

		$return['searchBackendTags'] = Yii::t('app', 'Backend Tags');
		$return['inputBackendTags'] = Yii::t('app', 'Backend Tags');

		return $return;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'eventGroup' => [self::BELONGS_TO, 'EventGroup', 'event_group_code'],
			'country' => [self::BELONGS_TO, 'Country', ['address_country_code' => 'code']],
			'addressCountry' => [self::BELONGS_TO, 'Country', 'address_country_code'],
			'addressState' => [self::BELONGS_TO, 'State', 'address_state_code'],
			'industries' => [self::MANY_MANY, 'Industry', 'event2industry(event_id, industry_id)'],
			'personas' => [self::MANY_MANY, 'Persona', 'event2persona(event_id, persona_id)'],
			'startupStages' => [self::MANY_MANY, 'StartupStage', 'event2startup_stage(event_id, startup_stage_id)'],
			'eventFeedbacks' => [self::HAS_MANY, 'EventFeedback', 'event_code'],
			'eventOwners' => [self::HAS_MANY, 'EventOwner', 'event_code'],

			// event_registration
			'eventRegistrations' => [self::HAS_MANY, 'EventRegistration', ['event_id' => 'id'], 'order' => 'email ASC'],
			'eventRegistrationsAttended' => [self::HAS_MANY, 'EventRegistration', ['event_id' => 'id'], 'condition' => 'is_attended=1', 'order' => 'email ASC'],

			'countRegistration' => [self::STAT, 'EventRegistration', 'event_id', 'condition' => '1=1'],
			'countAttended' => [self::STAT, 'EventRegistration', 'event_id', 'condition' => 'is_attended=1'],

			'countRegistrationNoNationality' => [self::STAT, 'EventRegistration', 'event_id', 'condition' => 'nationality IS NULL OR nationality=""'],
			'countRegistrationNoEmail' => [self::STAT, 'EventRegistration', 'event_id', 'condition' => 'email IS NULL OR email=""'],
			'countRegistrationNoName' => [self::STAT, 'EventRegistration', 'event_id', 'condition' => 'full_name IS NULL OR full_name=""'],

			// event_organization
			'eventOrganizations' => [self::HAS_MANY, 'EventOrganization', ['event_id' => 'id'], 'order' => 'organization_id ASC'],
			'activeEventOrganizations' => [self::HAS_MANY, 'Organization', 'organization_id',  'through' => 'eventOrganizations', 'condition' => '1=1'],
			//'eventOrganizationsAttended' => array(self::HAS_MANY, 'EventRegistration', array('event_id'=>'id'), 'condition'=>'is_attended=1', 'order'=>'email ASC'),

			'countOrganization' => [self::STAT, 'EventOrganization', 'event_id', 'condition' => '1=1'],

			// tags
			'tag2Events' => [self::HAS_MANY, 'Tag2Event', 'event_id'],
			'tags' => [self::HAS_MANY, 'Tag', ['tag_id' => 'id'], 'through' => 'tag2Events'],

			// meta
			'metaStructures' => [self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())],
			'metaItems' => [self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'],
		];
	}

	public function scopes()
	{
		return [
			// 'isActive'=>array('condition'=>"t.is_active = 1"),

			'isPaidEvent' => ['condition' => 't.is_paid_event = 1'],
			'isCancelled' => ['condition' => 't.is_cancelled = 1'],
			'isNotCancelled' => ['condition' => 't.is_cancelled != 1'],
			'isActive' => ['condition' => 't.is_active = 1'],
			'isSurveyEnabled' => ['condition' => 't.is_survey_enabled = 1'],
		];
	}

	public function behaviors()
	{
		$return = [
			'spatial' => [
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => [
					// all spatial fields here
					'latlong_address',
				],
			],

			'backend' => [
				'class' => 'application.yeebase.extensions.taggable-behavior.ETaggableBehavior',
				'tagTable' => 'tag',
				'tagBindingTable' => 'tag2event',
				'modelTableFk' => 'event_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Event',
				'createTagsAutomatically' => true,
			],
		];

		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['Event'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['Event'];
				$return[$moduleKey]['model'] = $this;
			}
		}

		return $return;
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes();

		$this->title = $keyword;
		$this->url_website = $keyword;
		$this->searchBackendTags = [$keyword];

		$tmp = $this->search(['compareOperator' => 'OR']);
		$tmp->sort->defaultOrder = 't.is_active DESC, t.date_started DESC';

		return $tmp;
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria();
		$criteria->together = true;

		$criteria->compare('t.id', $this->id, false, $params['compareOperator']);
		$criteria->compare('t.code', $this->code, true, $params['compareOperator']);
		$criteria->compare('event_group_code', $this->event_group_code, true, $params['compareOperator']);
		$criteria->compare('t.title', $this->title, true, $params['compareOperator']);
		$criteria->compare('text_short_desc', $this->text_short_desc, true, $params['compareOperator']);
		$criteria->compare('t.url_website', $this->url_website, true, $params['compareOperator']);
		if (!empty($this->sdate_started) && !empty($this->edate_started)) {
			$sTimestamp = strtotime($this->sdate_started);
			$eTimestamp = strtotime("{$this->edate_started} +1 day");
			$criteria->addCondition(sprintf('date_started >= %s AND date_started < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_ended) && !empty($this->edate_ended)) {
			$sTimestamp = strtotime($this->sdate_ended);
			$eTimestamp = strtotime("{$this->edate_ended} +1 day");
			$criteria->addCondition(sprintf('date_ended >= %s AND date_ended < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		$criteria->compare('is_paid_event', $this->is_paid_event, false, $params['compareOperator']);
		$criteria->compare('genre', $this->genre, true, $params['compareOperator']);
		$criteria->compare('funnel', $this->funnel, true, $params['compareOperator']);
		$criteria->compare('vendor', $this->vendor, true, $params['compareOperator']);
		$criteria->compare('vendor_code', $this->vendor_code, true, $params['compareOperator']);
		$criteria->compare('at', $this->at, true, $params['compareOperator']);
		$criteria->compare('address_country_code', $this->address_country_code, true, $params['compareOperator']);
		$criteria->compare('address_state_code', $this->address_state_code, true, $params['compareOperator']);
		$criteria->compare('full_address', $this->full_address, true, $params['compareOperator']);
		$criteria->compare('latlong_address', $this->latlong_address, true, $params['compareOperator']);
		$criteria->compare('email_contact', $this->email_contact, true, $params['compareOperator']);
		$criteria->compare('is_cancelled', $this->is_cancelled, false, $params['compareOperator']);
		$criteria->compare('t.is_active', $this->is_active, false, $params['compareOperator']);
		$criteria->compare('is_survey_enabled', $this->is_survey_enabled, false, $params['compareOperator']);
		//$criteria->compare('json_original',$this->json_original,true, $params['compareOperator']);
		//$criteria->compare('json_extra',$this->json_extra,true);
		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}

		// tag
		if ($this->searchBackendTags !== null) {
			$criteriaBackendTag = new CDbCriteria();
			$criteriaBackendTag->together = true;
			$criteriaBackendTag->with = ['tags'];
			foreach ($this->searchBackendTags as $backendTag) {
				$criteriaBackendTag->addSearchCondition('name', trim($backendTag), true, 'OR');
			}
			$criteria->mergeWith($criteriaBackendTag, $params['compareOperator']);
		}
		if ($this->inputBackendTags !== null) {
			$criteriaInputBackendTag = new CDbCriteria();
			$criteriaInputBackendTag->together = true;
			$criteriaInputBackendTag->with = ['tag2Events'];
			foreach ($this->inputBackendTags as $backendTag) {
				$criteriaInputBackendTag->addCondition(sprintf('tag2Events.tag_id=%s', trim($backendTag)), 'OR');
			}
			$criteria->mergeWith($criteriaInputBackendTag, $params['compareOperator']);
		}

		// either event or event group title
		$criteria2 = new CDbCriteria();
		$criteria2->together = true;
		$criteria2->with = ['eventGroup'];
		$criteria2->compare('eventGroup.title', $this->title, true, 'OR');
		$criteria->mergeWith($criteria2, 'OR');

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
			'pagination' => ['pageSize' => 30],
			'sort' => ['defaultOrder' => 't.date_started DESC'],
		]);
	}

	public function countRegistration()
	{
		return $this->countRegistration;
	}

	public function countAttended()
	{
		return $this->countAttended;
	}

	public function getForeignReferList($isNullable = false, $is4Filter = false, $htmlOptions = '')
	{
		$language = Yii::app()->language;

		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = ['key' => '', 'title' => ''];
		}

		if (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'isActiveNotCancelled') {
			$result = Yii::app()->db->createCommand()->select('code as key, title as title')->from(self::tableName())->order(['title ASC'])->where('is_active=:isActive AND is_cancelled!=:isCancelled', [':isActive' => 1, ':isCancelled' => 1])->queryAll();
		} elseif (!empty($htmlOptions['params']) && !empty($htmlOptions['params']['mode']) && $htmlOptions['params']['mode'] == 'idAsKey') {
			$result = Yii::app()->db->createCommand()->select('id as key, title as title')->from(self::tableName())->order(['title ASC'])->queryAll();
		} else {
			$result = Yii::app()->db->createCommand()->select('code as key, title as title')->from(self::tableName())->queryAll();
		}

		if ($is4Filter) {
			$newResult = [];
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	public function hasEventRegistration()
	{
		if (!empty($this->eventRegistrations)) {
			return true;
		}

		return false;
	}

	public function hasEventOrganization()
	{
		if (!empty($this->eventOrganizations)) {
			return true;
		}

		return false;
	}

	public function countEventOrganizationRoles()
	{
		$sql = sprintf('SELECT COUNT(id) as total, (as_role_code) FROM `event_organization` WHERE event_id=%s GROUP BY as_role_code', $this->id);

		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public function toApi($params = null)
	{
		$this->fixSpatial();

		$return = [
			'id' => $this->id,
			'code' => $this->code,
			'eventGroupCode' => $this->event_group_code,
			'title' => $this->title,
			'textShortDesc' => $this->text_short_desc,
			'urlWebsite' => $this->url_website,
			'dateStarted' => $this->date_started,
			'fDateStarted' => $this->renderDateStarted(),
			'fDateStartedDateOnly' => $this->renderDateStarted('date'),
			'fDateStartedTimeOnly' => $this->renderDateStarted('time'),
			'dateEnded' => $this->date_ended,
			'fDateEnded' => $this->renderDateEnded(),
			'fDateEndedDateOnly' => $this->renderDateEnded('date'),
			'fDateEndedTimeOnly' => $this->renderDateEnded('time'),
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
			'isSurveyEnabled' => $this->is_survey_enabled,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		];

		if (!empty($params['config']['mode']) && $params['config']['mode'] != 'public') {
			$set = [
				'jsonOriginal' => $this->json_original,
				'jsonExtra' => $this->json_extra,
				'urlBackendView' => Yii::app()->createAbsoluteUrl('/event/view', ['id' => $this->id]),
			];
			$return = array_merge($return, $set);
		}
		if (!in_array('-eventGroup', $params) && !empty($this->eventGroup)) {
			$return['eventGroup'][] = $this->eventGroup->toApi(['-event', $params['config']]);
		}

		// many2many
		if (!in_array('-industries', $params) && !empty($this->industries)) {
			foreach ($this->industries as $industry) {
				$return['industries'][] = $industry->toApi(['-event', $params['config']]);
			}
		}
		if (!in_array('-personas', $params) && !empty($this->personas)) {
			foreach ($this->personas as $persona) {
				$return['personas'][] = $persona->toApi(['-event', $params['config']]);
			}
		}
		if (!in_array('-startupStages', $params) && !empty($this->startupStages)) {
			foreach ($this->startupStages as $startupStage) {
				$return['startupStages'][] = $startupStage->toApi(['-event', $params['config']]);
			}
		}

		return $return;
	}

	public function renderDateStarted($format = '')
	{
		if ($format == 'date') {
			return Html::formatDateTimezone($this->date_started, 'standard', '', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == 'time') {
			return Html::formatDateTimezone($this->date_started, '', 'standard', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == '') {
			return Html::formatDateTimezone($this->date_started, 'standard', 'standard', '-', $this->getTimezone());
		}
	}

	public function renderDateEnded($format = '')
	{
		if ($format == 'date') {
			return Html::formatDateTimezone($this->date_ended, 'standard', '', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == 'time') {
			return Html::formatDateTimezone($this->date_ended, '', 'standard', '-', $this->getTimezone(), 'GMT', true);
		} elseif ($format == '') {
			return Html::formatDateTimezone($this->date_ended, 'standard', 'standard', '-', $this->getTimezone());
		}
	}

	public function hasSurveyForm()
	{
		if (strcasecmp($this->eventGroup->participant_type, 'entrepreneur') === 0) {
			return true;
		}

		return false;
	}

	// todo: modularize
	public function getPublicUrl()
	{
		if ($this->vendor == 'eventbrite') {
			return Yii::app()->createAbsoluteUrl('/eventbrite/frontend/register', ['id' => $this->vendor_code]);
		} elseif ($this->vendor == 'bizzabo') {
			return Yii::app()->createAbsoluteUrl('/bizzabo/register', ['id' => $this->vendor_code]);
		}
	}

	// use this with care, as event title is never meant to be unique
	public function title2obj($title)
	{
		// exiang: spent 3 hrs on the single quote around title. it's important if you passing data from different collation db table columns and do compare with = (equal). Changed to LIKE for safer comparison
		return Event::model()->find('t.title=:title', [':title' => trim($title)]);
	}

	public function hasEventOwner($organizationCode, $asRoleCode = '')
	{
		foreach ($this->eventOwners as $eventOwner) {
			if ($eventOwner->organization_code == $organizationCode) {
				if (!empty($asRoleCode) && $eventOwner->as_role_code == $asRoleCode) {
					return $eventOwner;
				} else {
					return $eventOwner;
				}
			}
		}

		return false;
	}

	public function searchActiveOrInactiveEvent()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;
		$criteria->with = ['eventGroup'];
		$criteria->compare('eventGroup.id', $this->id);
		$criteria->compare('t.is_active', $this->is_active);

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
			'sort' => ['defaultOrder' => 't.date_started DESC'],
		]);
	}

	public function resetAddressParts()
	{
		if (!empty($this->full_address)) {
			$addressParts = HubGeo::geocoder2AddressParts(HubGeo::address2Geocoder($this->full_address));
			$this->address_line1 = $addressParts['line1'];
			$this->address_line2 = $addressParts['line2'];
			$this->address_zip = $addressParts['zipcode'];
			$this->address_city = $addressParts['city'];
			$this->address_state = $addressParts['state'];
			$this->address_country_code = $addressParts['countryCode'];
			$this->setLatLongAddress(array($addressParts['lat'], $addressParts['lng']));
		}
	}
}
