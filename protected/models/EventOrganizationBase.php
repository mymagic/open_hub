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
 * This is the model class for table "event_organization".
 *
 * The followings are the available columns in table 'event_organization':
			 * @property integer $id
			 * @property string $event_code
			 * @property integer $event_id
			 * @property string $event_vendor_code
			 * @property string $registration_code
			 * @property integer $organization_id
			 * @property string $organization_name
			 * @property string $as_role_code
			 * @property integer $date_action
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Organization $organization
 * @property Event $event
 */
 class EventOrganizationBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_action;

 	public $edate_action;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();

 		if ($this->scenario == 'search') {
 		} else {
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'event_organization';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('event_id, organization_id, as_role_code', 'required'),
			array('event_id, organization_id, date_action, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('event_code, event_vendor_code, registration_code, as_role_code', 'length', 'max' => 64),
			array('organization_name', 'length', 'max' => 255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_code, event_id, event_vendor_code, registration_code, organization_id, organization_name, as_role_code, date_action, date_added, date_modified, sdate_action, edate_action, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
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
		'event_id' => Yii::t('app', 'Event'),
		'event_vendor_code' => Yii::t('app', 'Event Vendor Code'),
		'registration_code' => Yii::t('app', 'Registration Code'),
		'organization_id' => Yii::t('app', 'Organization'),
		'organization_name' => Yii::t('app', 'Organization Name'),
		'as_role_code' => Yii::t('app', 'As Role Code'),
		'date_action' => Yii::t('app', 'Date Action'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
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
 		$criteria->compare('event_code', $this->event_code, true);
 		$criteria->compare('event_id', $this->event_id);
 		$criteria->compare('event_vendor_code', $this->event_vendor_code, true);
 		$criteria->compare('registration_code', $this->registration_code, true);
 		$criteria->compare('organization_id', $this->organization_id);
 		$criteria->compare('organization_name', $this->organization_name, true);
 		$criteria->compare('as_role_code', $this->as_role_code, true);
 		if (!empty($this->sdate_action) && !empty($this->edate_action)) {
 			$sTimestamp = strtotime($this->sdate_action);
 			$eTimestamp = strtotime("{$this->edate_action} +1 day");
 			$criteria->addCondition(sprintf('date_action >= %s AND date_action < %s', $sTimestamp, $eTimestamp));
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
		));
 	}

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'eventCode' => $this->event_code,
			'eventId' => $this->event_id,
			'eventVendorCode' => $this->event_vendor_code,
			'registrationCode' => $this->registration_code,
			'organizationId' => $this->organization_id,
			'organizationName' => $this->organization_name,
			'asRoleCode' => $this->as_role_code,
			'dateAction' => $this->date_action,
			'fDateAction' => $this->renderDateAction(),
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

 	//
 	// date
 	public function getTimezone()
 	{
 		return date_default_timezone_get();
 	}

 	public function renderDateAction()
 	{
 		return Html::formatDateTimezone($this->date_action, 'standard', 'standard', '-', $this->getTimezone());
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
 	 * @return EventOrganization the static model class
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
 			if ($this->event_code == '') {
 				$this->event_code = null;
 			}
 			if ($this->event_vendor_code == '') {
 				$this->event_vendor_code = null;
 			}
 			if ($this->registration_code == '') {
 				$this->registration_code = null;
 			}
 			if (!empty($this->date_action)) {
 				if (!is_numeric($this->date_action)) {
 					$this->date_action = strtotime($this->date_action);
 				}
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// save as null if empty
 			if (empty($this->event_code) && $this->event_code != 0) {
 				$this->event_code = null;
 			}
 			if (empty($this->event_vendor_code) && $this->event_vendor_code != 0) {
 				$this->event_vendor_code = null;
 			}
 			if (empty($this->registration_code) && $this->registration_code != 0) {
 				$this->registration_code = null;
 			}
 			if (empty($this->organization_name) && $this->organization_name != 0) {
 				$this->organization_name = null;
 			}
 			if (empty($this->date_action) && $this->date_action != 0) {
 				$this->date_action = null;
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
 	* These are function for spatial usage
 	*/
 	public function fixSpatial()
 	{
 	}
 }
