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

class Individual extends IndividualBase
{
	public $imageRemote_photo;

	public $inputBackendTags;
	public $searchBackendTags;
	public $searchOrganization;

	public $defaultPhoto = 'uploads/individual/photo.default.jpg';

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function behaviors()
	{
		$return = array(
			/*'spatial'=>array(
				'class'=>'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields'=>array(
					'latlong',
				),
			),*/
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

		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['Individual'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['Individual'];
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

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_code'),
			'state' => array(self::BELONGS_TO, 'State', 'state_code'),
			'individual2Emails' => array(self::HAS_MANY, 'Individual2Email', 'individual_id'),
			'verifiedIndividual2Emails' => array(self::HAS_MANY, 'Individual2Email', 'individual_id', 'condition' => 'is_verify=1'),

			'individualOrganizations' => array(self::HAS_MANY, 'IndividualOrganization', 'individual_id'),
			'organizations' => array(self::HAS_MANY, 'Organization', array('organization_code' => 'code'), 'through' => 'individualOrganizations'),

			'personas' => array(self::MANY_MANY, 'Persona', 'persona2individual(individual_id, persona_id)'),

			'eventRegistrations' => array(self::HAS_MANY, 'EventRegistration', array('user_email' => 'email'), 'through' => 'verifiedIndividual2Emails',  'order' => 'date_registered DESC'),
			'eventRegistrationsAttended' => array(self::HAS_MANY, 'EventRegistration', array('user_email' => 'email'), 'through' => 'verifiedIndividual2Emails', 'condition' => 'is_attended=1', 'order' => 'date_registered DESC'),
			'envoyVisitors' => array(self::HAS_MANY, 'EnvoyVisitor', array('user_email' => 'visitor_email'), 'through' => 'verifiedIndividual2Emails',  'order' => 'date_signed_in DESC'),
			'mentorSessions' => array(self::HAS_MANY, 'MentorSession', array('user_email' => 'mentee_email'), 'through' => 'verifiedIndividual2Emails',  'order' => 'mentorSessions.id DESC'),

			// tags
			'tag2Individuals' => array(self::HAS_MANY, 'Tag2Individual', 'individual_id'),
			'tags' => array(self::HAS_MANY, 'Tag', array('tag_id' => 'id'), 'through' => 'tag2Individuals'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$return = array(
			array('full_name', 'required'),
			array('can_code, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('full_name, mobile_number', 'length', 'max' => 128),
			array('gender, state_code', 'length', 'max' => 6),
			array('image_photo', 'length', 'max' => 255),
			array('country_code', 'length', 'max' => 2),
			array('ic_number', 'length', 'max' => 64),
			array('text_address_residential, tag_backend, inputPersonas', 'safe'),
			array('imageFile_photo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, full_name, gender, image_photo, country_code, state_code, ic_number, text_address_residential, mobile_number, can_code, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend, inputBackendTags, searchBackendTags, searchOrganization', 'safe', 'on' => 'search'),
		);

		// meta
		$return[] = array('_dynamicData', 'safe');

		return $return;
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
		$users = $this->getIndividualUser();
		foreach ($users as $user) {
			$interest = Neo4jInterest::model()->findOneByAttributes(array('user_id' => $user->id));
			if (!empty($interest)) {
				$interest->deletePersonas();
				$interest->addPersona($this->inputPersonas);
			}
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

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		$return['organizations'] = Yii::t('app', 'Companies');
		$return['text_address_residential'] = Yii::t('app', 'Residential Address');

		$return['searchBackendTags'] = Yii::t('app', 'Backend Tags');
		$return['inputBackendTags'] = Yii::t('app', 'Backend Tags');

		// meta
		$return = array_merge($return, array_keys($this->_dynamicFields));
		foreach ($this->_metaStructures as $metaStruct) {
			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
		}

		return $return;
	}

	public function getIndividualUser()
	{
		$emails = Individual2Email::model()->find('individual_id=:id', array(':id' => $this->id));
		$users = array();
		foreach ($emails as $email) {
			array_push($users, User::model()->find('username=:username', array(':username' => $email)));
		}

		return $users;
	}

	public function fullname2obj($fullname)
	{
		return Individual::model()->find('t.full_name=:fullName', array(':fullName' => trim($fullname)));
	}

	public function isFullnameExists($fullname)
	{
		$exists = self::fullname2obj($fullname);
		if ($exists === null) {
			return false;
		}

		return $exists->id;
	}

	// userEmail
	public function hasUserEmail($email)
	{
		foreach ($this->individual2Emails as $item) {
			if (strtolower($email) == strtolower($item->user_email)) {
				return true;
			}
		}

		return false;
	}

	public function getIndividualByEmail($email)
	{
		$individual2email = Individual2Email::model()->find('user_email=:email', array(':email' => $email));
		$individual = Individual::model()->findByPk($individual2email['individual_id']);

		return $individual;
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
		foreach ($this->individual2Emails as $item) {
			if ($user->username == $item->user_email && $item->status == 'approve') {
				return true;
			}
		}

		return false;
	}

	public function canAccessByUserEmail($userEmail)
	{
		foreach ($this->individual2Emails as $item) {
			if ($userEmail == $item->user_email && $item->is_verify) {
				return true;
			}
		}

		return false;
	}

	//
	public function getDefaultImagePhoto()
	{
		return 'uploads/individual/photo.default.jpg';
	}

	public function isDefaultImagePhoto()
	{
		if ($this->image_photo == $this->getDefaultImagePhoto()) {
			return true;
		}

		return false;
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes();

		$this->full_name = $keyword;
		$this->ic_number = $keyword;
		$this->mobile_number = $keyword;
		$this->searchBackendTags = array($keyword);
		$this->searchOrganization = $keyword;

		return $this->search(array('compareOperator' => 'OR'));
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria;
		$criteria->together = true;

		$criteria->compare('id', $this->id, false, $params['compareOperator']);
		$criteria->compare('full_name', $this->full_name, true, $params['compareOperator']);
		$criteria->compare('gender', $this->gender, true, $params['compareOperator']);
		$criteria->compare('image_photo', $this->image_photo, true, $params['compareOperator']);
		$criteria->compare('country_code', $this->country_code, true, $params['compareOperator']);
		$criteria->compare('state_code', $this->state_code, true, $params['compareOperator']);
		$criteria->compare('ic_number', $this->ic_number, true, $params['compareOperator']);
		$criteria->compare('text_address_residential', $this->text_address_residential, true, $params['compareOperator']);
		$criteria->compare('mobile_number', $this->mobile_number, true, $params['compareOperator']);
		$criteria->compare('can_code', $this->can_code, false, $params['compareOperator']);
		$criteria->compare('is_active', $this->is_active, false, $params['compareOperator']);
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

		if ($this->searchOrganization !== null) {
			$criteriaOrganization = new CDbCriteria;
			$criteriaOrganization->together = true;
			$criteriaOrganization->with = array('organizations');
			$criteriaOrganization->addSearchCondition('title', trim($this->searchOrganization), true, 'OR');
			$criteria->mergeWith($criteriaOrganization, $params['compareOperator']);
		}

		// tag
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
			$criteriaInputBackendTag->with = array('tag2Individuals');
			foreach ($this->inputBackendTags as $backendTag) {
				$criteriaInputBackendTag->addCondition(sprintf('tag2Individuals.tag_id=%s', trim($backendTag)), 'OR');
			}
			$criteria->mergeWith($criteriaInputBackendTag, $params['compareOperator']);
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 30),
			'sort' => array('defaultOrder' => 't.full_name ASC'),
		));
	}

	public function toApi($params = array())
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'fullName' => $this->full_name,
			'gender' => $this->gender,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

		if (!empty($params['config']['mode']) && $params['config']['mode'] != 'public') {
			$set = array(
				'imagePhoto' => $this->image_photo,
				'imagePhotoThumbUrl' => $this->getImagePhotoThumbUrl(),
				'imagePhotoUrl' => $this->getImagePhotoUrl(),
				'countryCode' => $this->country_code,
				'stateCode' => $this->state_code,
				'textAddressResidential' => $this->text_address_residential,
				'mobileNumber' => $this->mobile_number,
				'icNumber' => $this->ic_number,
				'canCode' => $this->can_code,
			);
			$return = array_merge($return, $set);
		}

		// many2many
		if (!in_array('-personas', $params) && !empty($this->personas)) {
			foreach ($this->personas as $persona) {
				$return['personas'][] = $persona->toApi(array('-individual', $params['config']));
			}
		}

		return $return;
	}

	public function calcProfileCompletenessScore()
	{
		$totalScore = 0;

		//
		$fields2Check = array('full_name', 'gender', 'image_photo', 'country_code', 'state_code', 'ic_number', 'text_address_residential', 'mobile_number', 'is_active');

		foreach ($fields2Check as $field2Check) {
			if (isset($this->$field2Check) && !empty($this->$field2Check)) {
				$totalScore++;
			}
		}

		if ($this->image_photo == $this->defaultPhoto) {
			$totalScore = $totalScore - 1;
		}
		if ($this->is_active == 0) {
			$totalScore = $totalScore - 1;
		}

		return ($totalScore / count($fields2Check)) * 100;
	}

	//
	// comments
	public function countAllComments()
	{
		return HubComment::countAllIndividualComments($this);
	}

	public function getActiveComments($limit = 100)
	{
		return HubComment::getActiveIndividualComments($this, $limit);
	}
}
