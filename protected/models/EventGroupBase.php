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
 * This is the model class for table "event_group".
 *
 * The followings are the available columns in table 'event_group':
			 * @property integer $id
			 * @property string $code
			 * @property string $title
			 * @property string $text_oneliner
			 * @property string $text_short_description
			 * @property string $url_website
			 * @property string $slug
			 * @property string $genre
			 * @property string $funnel
			 * @property integer $date_started
			 * @property integer $date_ended
			 * @property integer $is_active
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property string $department
			 * @property string $participant_type
			 * @property string $group_category
 *
 * The followings are the available model relations:
 * @property Event[] $events
 */
 class EventGroupBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $imageFile_cover;
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

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

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
 		return 'event_group';
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
			array('date_started, date_ended, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('code, slug', 'length', 'max' => 64),
			array('title, genre, funnel, participant_type', 'length', 'max' => 128),
			array('image_cover', 'length', 'max' => 255),
			array('imageFile_cover', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('text_oneliner, department', 'length', 'max' => 200),
			array('url_website', 'length', 'max' => 255),
			array('group_category', 'length', 'max' => 100),
			array('text_short_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, title, image_cover, text_oneliner, text_short_description, url_website, slug, genre, funnel, date_started, date_ended, is_active, json_extra, date_added, date_modified, department, participant_type, group_category, sdate_started, edate_started, sdate_ended, edate_ended, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'events' => array(self::HAS_MANY, 'Event', 'event_group_code'),

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
		'title' => Yii::t('app', 'Title'),
		'image_cover' => Yii::t('app', 'Image Cover'),
		'text_oneliner' => Yii::t('app', 'Text Oneliner'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'url_website' => Yii::t('app', 'Url Website'),
		'slug' => Yii::t('app', 'Slug'),
		'genre' => Yii::t('app', 'Genre'),
		'funnel' => Yii::t('app', 'Funnel'),
		'date_started' => Yii::t('app', 'Date Started'),
		'date_ended' => Yii::t('app', 'Date Ended'),
		'is_active' => Yii::t('app', 'Is Active'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'department' => Yii::t('app', 'Department'),
		'participant_type' => Yii::t('app', 'Participant Type'),
		'group_category' => Yii::t('app', 'Group Category'),
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
 		$criteria->compare('code', $this->code, true);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('text_oneliner', $this->text_oneliner, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('url_website', $this->url_website, true);
 		$criteria->compare('slug', $this->slug, true);
 		$criteria->compare('genre', $this->genre, true);
 		$criteria->compare('funnel', $this->funnel, true);
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
 		$criteria->compare('department', $this->department, true);
 		$criteria->compare('participant_type', $this->participant_type, true);
 		$criteria->compare('group_category', $this->group_category, true);

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.title ASC'),
		));
 	}

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'title' => $this->title,
			'textOneliner' => $this->text_oneliner,
			'textShortDescription' => $this->text_short_description,
			'urlWebsite' => $this->url_website,
			'slug' => $this->slug,
			'genre' => $this->genre,
			'funnel' => $this->funnel,
			'dateStarted' => $this->date_started,
			'fDateStarted' => $this->renderDateStarted(),
			'dateEnded' => $this->date_ended,
			'fDateEnded' => $this->renderDateEnded(),
			'isActive' => $this->is_active,
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'department' => $this->department,
			'participantType' => $this->participant_type,
			'groupCategory' => $this->group_category,
		);

 		// many2many

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

			'isActive' => array('condition' => 't.is_active = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return EventGroup the static model class
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
 		return parent::afterSave();
 	}

 	/**
 	 * This is invoked before the record is saved.
 	 * @return boolean whether the record should be saved.
 	 */
 	protected function beforeSave()
 	{
 		if (parent::beforeSave()) {
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

 			// save as null if empty
 			if (empty($this->text_oneliner)) {
 				$this->text_oneliner = null;
 			}
 			if (empty($this->text_short_description)) {
 				$this->text_short_description = null;
 			}
 			if (empty($this->url_website)) {
 				$this->url_website = null;
 			}
 			if (empty($this->slug)) {
 				$this->slug = null;
 			}
 			if (empty($this->genre)) {
 				$this->genre = null;
 			}
 			if (empty($this->funnel)) {
 				$this->funnel = null;
 			}
 			if (empty($this->date_started) && $this->date_started !== 0) {
 				$this->date_started = null;
 			}
 			if (empty($this->date_ended) && $this->date_ended !== 0) {
 				$this->date_ended = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->department)) {
 				$this->department = null;
 			}
 			if (empty($this->participant_type)) {
 				$this->participant_type = null;
 			}
 			if (empty($this->group_category)) {
 				$this->group_category = null;
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

 		$this->jsonArray_extra = json_decode($this->json_extra);

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
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
 		$exists = EventGroup::model()->find('code=:code', array(':code' => $code));
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
 	}
 }
