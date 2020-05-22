<?php
/**
* NOTICE OF LICENSE.
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
*
* @see https://github.com/mymagic/open_hub
*
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class Resource extends ResourceBase
{
	public $searchOrganizationId;

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

		// backward compatible: auto update default value
		$this->title = $this->title_en;
		$this->html_content = $this->html_content_en;

		if ($this->isNewRecord) {
			$this->slug = ysUtil::slugify($this->title);
		}

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

		// auto deactivate/unpublished when resource is blocked by admin
		if ($this->is_blocked == 1) {
			$this->is_active = 0;
		}

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...
		if (Yii::app()->neo4j->getStatus()) {
			Neo4jResource::model($this)->sync();
		}

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...
		parent::beforeFind();
		/*$criteria = new CDbCriteria;
		// ys: need to include tableAlias or else it will cause ambiguous error
		$criteria->select = sprintf("*, X(%s.latlong) AS lat, Y(%s.latlong) as lng", $this->getTableAlias(), $this->getTableAlias());
		$this->dbCriteria->mergeWith($criteria); */

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
		return array(
			array('title, slug, html_content, html_content_en, title_en', 'required'),
			array('is_featured, is_active, is_blocked, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('orid', 'length', 'max' => 32),
			array('title, title_en, title_ms', 'length', 'max' => 200),
			array('slug', 'length', 'max' => 64),
			array('image_logo, url_website, full_address, owner', 'length', 'max' => 255),
			array('typefor', 'length', 'max' => 11),
			array('latlong_address, html_content_en, html_content_ms, tag_backend, inputOrganizations, inputIndustries, inputPersonas, inputStartupStages, inputResourceCategories, inputResourceGeofocuses', 'safe'),
			array('imageFile_logo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orid, title, title_en, title_ms, html_content_en, html_content_ms, slug, html_content, image_logo, url_website, latlong_address, full_address, typefor, owner, is_featured, is_active,  is_blocked, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend, inputBackendTags, searchBackendTags', 'safe', 'on' => 'search'),
			// meta
			array('_dynamicData', 'safe'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'industries' => array(self::MANY_MANY, 'Industry', 'resource2industry(resource_id, industry_id)'),
			'organizations' => array(self::MANY_MANY, 'Organization', 'resource2organization(resource_id, organization_id)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'resource2persona(resource_id, persona_id)'),
			'resource2OrganizationFundings' => array(self::HAS_MANY, 'Resource2organizationFunding', 'resource_id'),
			'resourceCategories' => array(self::MANY_MANY, 'ResourceCategory', 'resource2resource_category(resource_id, resource_category_id)'),
			'resourceGeofocuses' => array(self::MANY_MANY, 'ResourceGeofocus', 'resource2resource_geofocus(resource_id, resource_geofocus_id)'),
			'startupStages' => array(self::MANY_MANY, 'StartupStage', 'resource2startup_stage(resource_id, startup_stage_id)'),

			// tags
			'tag2Resources' => array(self::HAS_MANY, 'Tag2Resource', 'resource_id'),
			'tags' => array(self::HAS_MANY, 'Tag', array('tag_id' => 'id'), 'through' => 'tag2Resources'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
	}

	public function behaviors()
	{
		$return = array(
			'spatial' => array(
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => array(
					// all spatial fields here
					'latlong_address',
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
			),
		);

		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['Resource'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['Resource'];
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
		$this->searchBackendTags = array($keyword);

		$tmp = $this->search(array('compareOperator' => 'OR'));
		$tmp->sort->defaultOrder = 't.is_active DESC, t.id DESC';

		return $tmp;
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria();
		$criteria->with = array('organizations');
		$criteria->together = true;

		$criteria->compare('t.id', $this->id, false, $params['compareOperator']);
		$criteria->compare('t.orid', $this->orid, true, $params['compareOperator']);
		$criteria->compare('t.title', $this->title, true, $params['compareOperator']);
		$criteria->compare('t.slug', $this->slug, true, $params['compareOperator']);
		$criteria->compare('t.html_content', $this->html_content, true, $params['compareOperator']);
		$criteria->compare('t.image_logo', $this->image_logo, true, $params['compareOperator']);
		$criteria->compare('t.url_website', $this->url_website, true, $params['compareOperator']);
		$criteria->compare('t.latlong_address', $this->latlong_address, true, $params['compareOperator']);
		$criteria->compare('t.full_address', $this->full_address, true, $params['compareOperator']);
		$criteria->compare('t.typefor', $this->typefor, false, $params['compareOperator']);
		$criteria->compare('t.owner', $this->owner, true, $params['compareOperator']);
		$criteria->compare('t.is_featured', $this->is_featured, false, $params['compareOperator']);
		$criteria->compare('t.is_active', $this->is_active, false, $params['compareOperator']);
		$criteria->compare('t.is_blocked', $this->is_blocked, false, $params['compareOperator']);
		//$criteria->compare('t.json_extra',$this->json_extra,true);
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
		$criteria->compare('title_en', $this->title_en, true, $params['compareOperator']);
		$criteria->compare('title_ms', $this->title_ms, true, $params['compareOperator']);
		$criteria->compare('html_content_en', $this->html_content_en, true, $params['compareOperator']);
		$criteria->compare('html_content_ms', $this->html_content_ms, true, $params['compareOperator']);

		if (!empty($this->searchOrganizationId)) {
			$criteria->compare('organizations.id', $this->searchOrganizationId, false, $params['compareOperator']);
		}

		// tag
		if ($this->searchBackendTags !== null) {
			$criteriaBackendTag = new CDbCriteria();
			$criteriaBackendTag->together = true;
			$criteriaBackendTag->with = array('tags');
			foreach ($this->searchBackendTags as $backendTag) {
				$criteriaBackendTag->addSearchCondition('name', trim($backendTag), true, 'OR');
			}
			$criteria->mergeWith($criteriaBackendTag, $params['compareOperator']);
		}
		if ($this->inputBackendTags !== null) {
			$criteriaInputBackendTag = new CDbCriteria();
			$criteriaInputBackendTag->together = true;
			$criteriaInputBackendTag->with = array('tag2Resources');
			foreach ($this->inputBackendTags as $backendTag) {
				$criteriaInputBackendTag->addCondition(sprintf('tag2Resources.tag_id=%s', trim($backendTag)), 'OR');
			}
			$criteria->mergeWith($criteriaInputBackendTag, $params['compareOperator']);
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 30),
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		$return['is_active'] = Yii::t('app', 'Published?');
		$return['is_blocked'] = Yii::t('app', 'Blocked By Admin?');
		$return['organization'] = Yii::t('app', 'Organization');
		$return['organizations'] = Yii::t('app', 'Companies');
		$return['latlong_address'] = Yii::t('app', 'Exact Location');
		$return['html_content'] = Yii::t('app', 'Content');
		$return['html_content_en'] = Yii::t('app', 'Content [English]');
		$return['html_content_ms'] = Yii::t('app', 'Content [Bahasa]');
		$return['image_logo'] = Yii::t('app', 'Logo Image');
		$return['backend'] = Yii::t('app', 'Backend Tags');
		$return['typefor'] = Yii::t('app', 'Main Type');

		$return['searchBackendTags'] = Yii::t('app', 'Backend Tags');
		$return['inputBackendTags'] = Yii::t('app', 'Backend Tags');

		return $return;
	}

	public static function slug2obj($slug)
	{
		$r = self::model()->find('t.slug=:slug', array(':slug' => $slug));
		if (!empty($r)) {
			return $r;
		}
	}

	public function slug2id($slug)
	{
		$r = self::slug2obj($slug);
		if (!empty($r)) {
			return $r->id;
		}
	}

	public function renderTypeFor($output = 'html')
	{
		$typeFors = HubResource::getTypefors();

		return ucwords($typeFors[$this->typefor]);
	}

	public function toApi($params = array())
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'orid' => $this->orid,
			'title' => $this->title,
			'titleEn' => $this->title_en,
			'titleMs' => $this->title_ms,
			'slug' => $this->slug,
			'htmlContent' => $this->html_content,
			'htmlContentEn' => $this->html_content_en,
			'htmlContentMs' => $this->html_content_ms,
			'imageLogo' => $this->image_logo,
			'imageLogoThumbUrl' => $this->getImageLogoThumbUrl(),
			'imageLogoUrl' => $this->getImageLogoUrl(),
			'urlWebsite' => $this->url_website,
			'latlongAddress' => $this->latlong_address,
			'fullAddress' => $this->full_address,
			'typefor' => $this->typefor,
			'fTypefor' => $this->renderTypeFor('text'),
			'owner' => $this->owner,
			'isFeatured' => $this->is_featured,
			'isActive' => $this->is_active,
			'isBlocked' => $this->is_blocked,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

		if (!empty($params['config']['mode']) && $params['config']['mode'] != 'public') {
			$set = array(
				'urlBackendView' => Yii::app()->createAbsoluteUrl('/resource/view', array('id' => $this->id)),
			);
			$return = array_merge($return, $set);
		}

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

	public function getForeignReferList($isNullable = false, $is4Filter = false)
	{
		$language = Yii::app()->language;

		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('key' => '', 'title' => '');
		}

		$result = Yii::app()->db->createCommand()
		->select(array('t.id as key', "CONCAT(GROUP_CONCAT(o.title SEPARATOR ', '), ' - ', t.title, ' (', UPPER(t.typefor), ')') as title"))
		->from(self::tableName() . ' as t')
		->join('resource2organization r2o', 'r2o.resource_id=t.id')
		->join('organization o', 'r2o.organization_id=o.id')
		->group('t.id')
		->queryAll();

		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	public function renderOrganization($mode)
	{
		$buffer = '';
		$total = count($this->organizations);
		$i = 0;
		foreach ($this->organizations as $organization) {
			$buffer .= sprintf('%s', $organization->title);
			if ($i != $total - 1) {
				$buffer .= ', ';
			}
			++$i;
		}

		return $buffer;
	}

	public function getFrontendUrl($controller, $absolute = true)
	{
		$urlParams['id'] = $this->id;
		// $urlParams['language'] = $controller->language;

		if ($absolute) {
			return $controller->createAbsoluteUrl('/resource/frontend/view', $urlParams);
		} else {
			return $controller->createUrl('/resource/frontend/view', $urlParams);
		}
	}
}
