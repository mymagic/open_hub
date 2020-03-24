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
 * This is the model class for table "proof".
 *
 * The followings are the available columns in table 'proof':
			 * @property integer $id
			 * @property string $ref_table
			 * @property integer $ref_id
			 * @property string $value
			 * @property string $datatype
			 * @property string $datatype_value
			 * @property string $note
			 * @property string $user_username
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $userUsername
 */
 class ProofBase extends ActiveRecordBase
 {
 	public $uploadPath;

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
 		return 'proof';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('ref_id, user_username', 'required'),
			array('ref_id, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('ref_table', 'length', 'max' => 20),
			array('datatype', 'length', 'max' => 6),
			array('datatype_value, note', 'length', 'max' => 255),
			array('user_username', 'length', 'max' => 128),
			array('value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ref_table, ref_id, value, datatype, datatype_value, note, user_username, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'userUsername' => array(self::BELONGS_TO, 'User', 'user_username'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		$return = array(
		'id' => Yii::t('app', 'ID'),
		'ref_table' => Yii::t('app', 'Ref Table'),
		'ref_id' => Yii::t('app', 'Ref'),
		'value' => Yii::t('app', 'Value'),
		'datatype' => Yii::t('app', 'Datatype'),
		'datatype_value' => Yii::t('app', 'Datatype Value'),
		'note' => Yii::t('app', 'Note'),
		'user_username' => Yii::t('app', 'User Username'),
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
 		$criteria->compare('ref_table', $this->ref_table);
 		$criteria->compare('ref_id', $this->ref_id);
 		$criteria->compare('value', $this->value, true);
 		$criteria->compare('datatype', $this->datatype);
 		$criteria->compare('datatype_value', $this->datatype_value, true);
 		$criteria->compare('note', $this->note, true);
 		$criteria->compare('user_username', $this->user_username, true);
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
			'refTable' => $this->ref_table,
			'refId' => $this->ref_id,
			'value' => $this->value,
			'datatype' => $this->datatype,
			'datatypeValue' => $this->datatype_value,
			'note' => $this->note,
			'userUsername' => $this->user_username,
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
 	 * @return Proof the static model class
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
 			if (empty($this->value)) {
 				$this->value = null;
 			}
 			if (empty($this->datatype_value)) {
 				$this->datatype_value = null;
 			}
 			if (empty($this->note)) {
 				$this->note = null;
 			}
 			if (empty($this->date_added) && $this->date_added != 0) {
 				$this->date_added = null;
 			}
 			if (empty($this->date_modified) && $this->date_modified != 0) {
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

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumRefTable($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumRefTable(''));
 		}

 		$result[] = array('code' => 'organization_funding', 'title' => $this->formatEnumRefTable('organization_funding'));
 		$result[] = array('code' => 'organization_revenue', 'title' => $this->formatEnumRefTable('organization_revenue'));
 		$result[] = array('code' => 'organization_status', 'title' => $this->formatEnumRefTable('organization_status'));
 		$result[] = array('code' => 'idea_rfp', 'title' => $this->formatEnumRefTable('idea_rfp'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumRefTable($code)
 	{
 		switch ($code) {
			case 'organization_funding': {return Yii::t('app', 'Company Funding'); break;}

			case 'organization_revenue': {return Yii::t('app', 'Company Revenue'); break;}

			case 'organization_status': {return Yii::t('app', 'Company Status'); break;}

			case 'idea_rfp': {return Yii::t('app', 'Idea RFP'); break;}
			default: {return ''; break;}
		}
 	}

 	public function getEnumDatatype($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumDatatype(''));
 		}

 		$result[] = array('code' => 'string', 'title' => $this->formatEnumDatatype('string'));
 		$result[] = array('code' => 'image', 'title' => $this->formatEnumDatatype('image'));
 		$result[] = array('code' => 'file', 'title' => $this->formatEnumDatatype('file'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumDatatype($code)
 	{
 		switch ($code) {
			case 'string': {return Yii::t('app', 'String'); break;}

			case 'image': {return Yii::t('app', 'Image'); break;}

			case 'file': {return Yii::t('app', 'File'); break;}
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
 		$result = Yii::app()->db->createCommand()->select('id as key, id as title')->from(self::tableName())->queryAll();
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
