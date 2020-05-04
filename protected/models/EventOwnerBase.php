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
 * This is the model class for table "event_owner".
 *
 * The followings are the available columns in table 'event_owner':
			 * @property integer $id
			 * @property string $event_code
			 * @property string $organization_code
			 * @property string $department
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property string $as_role_code
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property Organization $organization
 */
 class EventOwnerBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_added;

 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

 		if ($this->scenario == 'search') {
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'event_owner';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('event_code, organization_code', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('event_code, organization_code, as_role_code', 'length', 'max' => 64),
			array('department', 'length', 'max' => 128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_code, organization_code, department, date_added, date_modified, as_role_code, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_code'),
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_code'),

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
		'event_code' => Yii::t('app', 'Event Code'),
		'organization_code' => Yii::t('app', 'Organization Code'),
		'department' => Yii::t('app', 'Department'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'as_role_code' => Yii::t('app', 'As Role Code'),
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
 		$criteria->compare('event_code', $this->event_code, true);
 		$criteria->compare('organization_code', $this->organization_code, true);
 		$criteria->compare('department', $this->department, true);
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
 		$criteria->compare('as_role_code', $this->as_role_code, true);

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
 	}

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'eventCode' => $this->event_code,
			'organizationCode' => $this->organization_code,
			'department' => $this->department,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'asRoleCode' => $this->as_role_code,
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
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return EventOwner the static model class
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

 			// save as null if empty
 			if (empty($this->department)) {
 				$this->department = null;
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
 		$result = Yii::app()->db->createCommand()->select('id as key, organization_code as title')->from(self::tableName())->queryAll();
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
 }
