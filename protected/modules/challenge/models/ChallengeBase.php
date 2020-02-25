<?php


/**
 * This is the model class for table "challenge".
 *
 * The followings are the available columns in table 'challenge':
			 * @property integer $id
			 * @property integer $owner_organization_id
			 * @property integer $creator_user_id
			 * @property string $title
			 * @property string $text_short_description
			 * @property string $html_content
			 * @property string $image_cover
			 * @property string $image_header
			 * @property string $url_video
			 * @property string $url_application_form
			 * @property string $html_deliverable
			 * @property string $html_criteria
			 * @property string $prize_title
			 * @property string $html_prize_detail
			 * @property integer $date_open
			 * @property integer $date_close
			 * @property double $ordering
			 * @property string $text_remark
			 * @property string $json_extra
			 * @property string $status
			 * @property string $timezone
			 * @property integer $is_active
			 * @property integer $is_publish
			 * @property integer $is_highlight
			 * @property string $process_by
			 * @property integer $date_submit
			 * @property integer $date_process
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $creatorUser
 * @property Organization $ownerOrganization
 * @property User $processBy
 * @property Industry[] $industries
 * @property Tag2challenge[] $tag2challenges
 */
 class ChallengeBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	// m2m
 	public $inputIndustries;

 	public $imageFile_cover;
 	public $imageFile_header;
 	public $sdate_open;
 	public $edate_open;
 	public $sdate_close;
 	public $edate_close;
 	public $sdate_submit;
 	public $edate_submit;
 	public $sdate_process;
 	public $edate_process;
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
 			$this->is_active = null;
 			$this->is_publish = null;
 			$this->is_highlight = null;
 		} else {
 			$this->ordering = $this->count() + 1;
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'challenge';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('owner_organization_id, creator_user_id, title', 'required'),
			array('owner_organization_id, creator_user_id, date_open, date_close, is_active, is_publish, is_highlight, date_submit, date_process, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('ordering', 'numerical'),
			array('title, text_short_description, image_cover, image_header, url_video, url_application_form, prize_title, process_by', 'length', 'max' => 255),
			array('status', 'length', 'max' => 10),
			array('timezone', 'length', 'max' => 128),
			array('html_content, html_deliverable, html_criteria, html_prize_detail, text_remark, tag_backend, inputIndustries', 'safe'),
			array('imageFile_cover, imageFile_header', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner_organization_id, creator_user_id, title, text_short_description, html_content, image_cover, image_header, url_video, url_application_form, html_deliverable, html_criteria, prize_title, html_prize_detail, date_open, date_close, ordering, text_remark, json_extra, status, timezone, is_active, is_publish, is_highlight, process_by, date_submit, date_process, date_added, date_modified, sdate_open, edate_open, sdate_close, edate_close, sdate_submit, edate_submit, sdate_process, edate_process, sdate_added, edate_added, sdate_modified, edate_modified, tag_backend', 'safe', 'on' => 'search'),
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
			'creatorUser' => array(self::BELONGS_TO, 'User', 'creator_user_id'),
			'ownerOrganization' => array(self::BELONGS_TO, 'Organization', 'owner_organization_id'),
			'processBy' => array(self::BELONGS_TO, 'User', 'process_by'),
			'industries' => array(self::MANY_MANY, 'Industry', 'industry2challenge(challenge_id, industry_id)'),
			'tag2challenges' => array(self::HAS_MANY, 'Tag2challenge', 'challenge_id'),

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
		'owner_organization_id' => Yii::t('app', 'Owner Organization'),
		'creator_user_id' => Yii::t('app', 'Creator User'),
		'title' => Yii::t('app', 'Title'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'html_content' => Yii::t('app', 'Html Content'),
		'image_cover' => Yii::t('app', 'Image Cover'),
		'image_header' => Yii::t('app', 'Image Header'),
		'url_video' => Yii::t('app', 'Url Video'),
		'url_application_form' => Yii::t('app', 'Url Application Form'),
		'html_deliverable' => Yii::t('app', 'Html Deliverable'),
		'html_criteria' => Yii::t('app', 'Html Criteria'),
		'prize_title' => Yii::t('app', 'Prize Title'),
		'html_prize_detail' => Yii::t('app', 'Html Prize Detail'),
		'date_open' => Yii::t('app', 'Date Open'),
		'date_close' => Yii::t('app', 'Date Close'),
		'ordering' => Yii::t('app', 'Ordering'),
		'text_remark' => Yii::t('app', 'Text Remark'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'status' => Yii::t('app', 'Status'),
		'timezone' => Yii::t('app', 'Timezone'),
		'is_active' => Yii::t('app', 'Is Active'),
		'is_publish' => Yii::t('app', 'Is Publish'),
		'is_highlight' => Yii::t('app', 'Is Highlight'),
		'process_by' => Yii::t('app', 'Process By'),
		'date_submit' => Yii::t('app', 'Date Submit'),
		'date_process' => Yii::t('app', 'Date Process'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);

 		$return['inputIndustries'] = Yii::t('app', 'Industries');

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
 		$criteria->compare('owner_organization_id', $this->owner_organization_id);
 		$criteria->compare('creator_user_id', $this->creator_user_id);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('html_content', $this->html_content, true);
 		$criteria->compare('image_cover', $this->image_cover, true);
 		$criteria->compare('image_header', $this->image_header, true);
 		$criteria->compare('url_video', $this->url_video, true);
 		$criteria->compare('url_application_form', $this->url_application_form, true);
 		$criteria->compare('html_deliverable', $this->html_deliverable, true);
 		$criteria->compare('html_criteria', $this->html_criteria, true);
 		$criteria->compare('prize_title', $this->prize_title, true);
 		$criteria->compare('html_prize_detail', $this->html_prize_detail, true);
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
 		$criteria->compare('ordering', $this->ordering);
 		$criteria->compare('text_remark', $this->text_remark, true);
 		$criteria->compare('json_extra', $this->json_extra, true);
 		$criteria->compare('status', $this->status);
 		$criteria->compare('timezone', $this->timezone, true);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('is_publish', $this->is_publish);
 		$criteria->compare('is_highlight', $this->is_highlight);
 		$criteria->compare('process_by', $this->process_by, true);
 		if (!empty($this->sdate_submit) && !empty($this->edate_submit)) {
 			$sTimestamp = strtotime($this->sdate_submit);
 			$eTimestamp = strtotime("{$this->edate_submit} +1 day");
 			$criteria->addCondition(sprintf('date_submit >= %s AND date_submit < %s', $sTimestamp, $eTimestamp));
 		}
 		if (!empty($this->sdate_process) && !empty($this->edate_process)) {
 			$sTimestamp = strtotime($this->sdate_process);
 			$eTimestamp = strtotime("{$this->edate_process} +1 day");
 			$criteria->addCondition(sprintf('date_process >= %s AND date_process < %s', $sTimestamp, $eTimestamp));
 		}
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
			'sort' => array('defaultOrder' => 't.ordering ASC'),
		));
 	}

 	public function toApi($params = array())
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'ownerOrganizationId' => $this->owner_organization_id,
			'creatorUserId' => $this->creator_user_id,
			'title' => $this->title,
			'textShortDescription' => $this->text_short_description,
			'htmlContent' => $this->html_content,
			'imageCover' => $this->image_cover,
			'imageCoverThumbUrl' => $this->getImageCoverThumbUrl(),
			'imageCoverUrl' => $this->getImageCoverUrl(),
			'imageHeader' => $this->image_header,
			'imageHeaderThumbUrl' => $this->getImageHeaderThumbUrl(),
			'imageHeaderUrl' => $this->getImageHeaderUrl(),
			'urlVideo' => $this->url_video,
			'urlApplicationForm' => $this->url_application_form,
			'htmlDeliverable' => $this->html_deliverable,
			'htmlCriteria' => $this->html_criteria,
			'prizeTitle' => $this->prize_title,
			'htmlPrizeDetail' => $this->html_prize_detail,
			'dateOpen' => $this->date_open,
			'fDateOpen' => $this->renderDateOpen(),
			'dateClose' => $this->date_close,
			'fDateClose' => $this->renderDateClose(),
			'ordering' => $this->ordering,
			'textRemark' => $this->text_remark,
			'jsonExtra' => $this->json_extra,
			'status' => $this->status,
			'timezone' => $this->timezone,
			'isActive' => $this->is_active,
			'isPublish' => $this->is_publish,
			'isHighlight' => $this->is_highlight,
			'processBy' => $this->process_by,
			'dateSubmit' => $this->date_submit,
			'fDateSubmit' => $this->renderDateSubmit(),
			'dateProcess' => $this->date_process,
			'fDateProcess' => $this->renderDateProcess(),
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

 		// many2many
 		if (!in_array('-industries', $params) && !empty($this->industries)) {
 			foreach ($this->industries as $industry) {
 				$return['industries'][] = $industry->toApi(array('-challenge'));
 			}
 		}

 		return $return;
 	}

 	//
 	// image
 	public function getImageCoverUrl()
 	{
 		if (!empty($this->image_cover)) {
 			return StorageHelper::getUrl($this->image_cover);
 		}
 	}

 	public function getImageCoverThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_cover)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_cover));
 		}
 	}

 	public function getImageHeaderUrl()
 	{
 		if (!empty($this->image_header)) {
 			return StorageHelper::getUrl($this->image_header);
 		}
 	}

 	public function getImageHeaderThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_header)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_header));
 		}
 	}

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

 	public function renderDateSubmit()
 	{
 		return Html::formatDateTimezone($this->date_submit, 'standard', 'standard', '-', $this->getTimezone());
 	}

 	public function renderDateProcess()
 	{
 		return Html::formatDateTimezone($this->date_process, 'standard', 'standard', '-', $this->getTimezone());
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

			'byDateAdded' => array('order' => 'date_added DESC'),
			'byDateStart' => array('order' => 'date_open DESC'),
			'byDateEnd' => array('order' => 'date_close DESC'),
			'isActive' => array('condition' => 't.is_active = 1'),
			'isPublish' => array('condition' => 't.is_publish = 1'),
			'isHighlight' => array('condition' => 't.is_highlight = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Challenge the static model class
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
 		$this->saveInputIndustry();

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
 			if (!empty($this->date_submit)) {
 				if (!is_numeric($this->date_submit)) {
 					$this->date_submit = strtotime($this->date_submit);
 				}
 			}
 			if (!empty($this->date_process)) {
 				if (!is_numeric($this->date_process)) {
 					$this->date_process = strtotime($this->date_process);
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

 			// save as null if empty
 			if (empty($this->text_short_description)) {
 				$this->text_short_description = null;
 			}
 			if (empty($this->html_content)) {
 				$this->html_content = null;
 			}
 			if (empty($this->image_cover)) {
 				$this->image_cover = null;
 			}
 			if (empty($this->image_header)) {
 				$this->image_header = null;
 			}
 			if (empty($this->url_video)) {
 				$this->url_video = null;
 			}
 			if (empty($this->url_application_form)) {
 				$this->url_application_form = null;
 			}
 			if (empty($this->html_deliverable)) {
 				$this->html_deliverable = null;
 			}
 			if (empty($this->html_criteria)) {
 				$this->html_criteria = null;
 			}
 			if (empty($this->prize_title)) {
 				$this->prize_title = null;
 			}
 			if (empty($this->html_prize_detail)) {
 				$this->html_prize_detail = null;
 			}
 			if (empty($this->date_open) && $this->date_open !== 0) {
 				$this->date_open = null;
 			}
 			if (empty($this->date_close) && $this->date_close !== 0) {
 				$this->date_close = null;
 			}
 			if (empty($this->ordering) && $this->ordering !== 0) {
 				$this->ordering = null;
 			}
 			if (empty($this->text_remark)) {
 				$this->text_remark = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->timezone)) {
 				$this->timezone = null;
 			}
 			if (empty($this->process_by)) {
 				$this->process_by = null;
 			}
 			if (empty($this->date_submit) && $this->date_submit !== 0) {
 				$this->date_submit = null;
 			}
 			if (empty($this->date_process) && $this->date_process !== 0) {
 				$this->date_process = null;
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
 		if ($this->is_active != '' || $this->is_active != null) {
 			$this->is_active = intval($this->is_active);
 		}
 		if ($this->is_publish != '' || $this->is_publish != null) {
 			$this->is_publish = intval($this->is_publish);
 		}
 		if ($this->is_highlight != '' || $this->is_highlight != null) {
 			$this->is_highlight = intval($this->is_highlight);
 		}

 		$this->jsonArray_extra = json_decode($this->json_extra);

 		$this->tag_backend = $this->backend->toString();

 		foreach ($this->industries as $industry) {
 			$this->inputIndustries[] = $industry->id;
 		}

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
			'backend' => array(
				'class' => 'application.yeebase.extensions.taggable-behavior.ETaggableBehavior',
				'tagTable' => 'tag',
				'tagBindingTable' => 'tag2challenge',
				'modelTableFk' => 'challenge_id',
				'tagTablePk' => 'id',
				'tagTableName' => 'name',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cacheTag2Challenge',
				'createTagsAutomatically' => true,
			)
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumStatus($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumStatus(''));
 		}

 		$result[] = array('code' => 'new', 'title' => $this->formatEnumStatus('new'));
 		$result[] = array('code' => 'pending', 'title' => $this->formatEnumStatus('pending'));
 		$result[] = array('code' => 'processing', 'title' => $this->formatEnumStatus('processing'));
 		$result[] = array('code' => 'reject', 'title' => $this->formatEnumStatus('reject'));
 		$result[] = array('code' => 'approved', 'title' => $this->formatEnumStatus('approved'));
 		$result[] = array('code' => 'completed', 'title' => $this->formatEnumStatus('completed'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumStatus($code)
 	{
 		switch ($code) {
			case 'new': {return Yii::t('app', 'New'); break;}

			case 'pending': {return Yii::t('app', 'Pending'); break;}

			case 'processing': {return Yii::t('app', 'Processing'); break;}

			case 'reject': {return Yii::t('app', 'Reject'); break;}

			case 'approved': {return Yii::t('app', 'Approved'); break;}

			case 'completed': {return Yii::t('app', 'Completed'); break;}
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
 			$many2many = Industry2Challenge::model()->findByAttributes(array('challenge_id' => $this->id, 'industry_id' => $key));
 			if (!empty($many2many)) {
 				return $many2many->delete();
 			}
 		}

 		return false;
 	}

 	public function addIndustry($key)
 	{
 		if ($this->hasNoIndustry($key)) {
 			$many2many = new Industry2Challenge;
 			$many2many->challenge_id = $this->id;
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
 }
