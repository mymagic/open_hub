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
 * This is the model class for table "charge".
 *
 * The followings are the available columns in table 'charge':
			 * @property integer $id
			 * @property string $code
			 * @property string $title
			 * @property string $amount
			 * @property string $currency_code
			 * @property string $text_description
			 * @property integer $date_started
			 * @property integer $date_expired
			 * @property string $status
			 * @property integer $is_active
			 * @property string $charge_to
			 * @property string $charge_to_code
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
 */
 class ChargeBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_started;

 	public $edate_started;
 	public $sdate_expired;
 	public $edate_expired;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// json
 	public $jsonArray_extra;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'charge';

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
 		return 'charge';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, title, amount, currency_code, date_started, date_expired, status, charge_to, charge_to_code', 'required'),
			array('date_started, date_expired, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('code', 'length', 'max' => 64),
			array('title', 'length', 'max' => 255),
			array('amount', 'length', 'max' => 8),
			array('currency_code', 'length', 'max' => 3),
			array('status', 'length', 'max' => 7),
			array('charge_to', 'length', 'max' => 12),
			array('charge_to_code', 'length', 'max' => 100),
			array('text_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, title, amount, currency_code, text_description, date_started, date_expired, status, is_active, charge_to, charge_to_code, json_extra, date_added, date_modified, sdate_started, edate_started, sdate_expired, edate_expired, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		return array(
		'id' => Yii::t('app', 'ID'),
		'code' => Yii::t('app', 'Code'),
		'title' => Yii::t('app', 'Title'),
		'amount' => Yii::t('app', 'Amount'),
		'currency_code' => Yii::t('app', 'Currency Code'),
		'text_description' => Yii::t('app', 'Text Description'),
		'date_started' => Yii::t('app', 'Date Started'),
		'date_expired' => Yii::t('app', 'Date Expired'),
		'status' => Yii::t('app', 'Status'),
		'is_active' => Yii::t('app', 'Is Active'),
		'charge_to' => Yii::t('app', 'Charge To'),
		'charge_to_code' => Yii::t('app', 'Charge To Code'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);
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
 		$criteria->compare('amount', $this->amount, true);
 		$criteria->compare('currency_code', $this->currency_code, true);
 		$criteria->compare('text_description', $this->text_description, true);
 		if (!empty($this->sdate_started) && !empty($this->edate_started)) {
 			$sTimestamp = strtotime($this->sdate_started);
 			$eTimestamp = strtotime("{$this->edate_started} +1 day");
 			$criteria->addCondition(sprintf('date_started >= %s AND date_started < %s', $sTimestamp, $eTimestamp));
 		}
 		if (!empty($this->sdate_expired) && !empty($this->edate_expired)) {
 			$sTimestamp = strtotime($this->sdate_expired);
 			$eTimestamp = strtotime("{$this->edate_expired} +1 day");
 			$criteria->addCondition(sprintf('date_expired >= %s AND date_expired < %s', $sTimestamp, $eTimestamp));
 		}
 		$criteria->compare('status', $this->status);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('charge_to', $this->charge_to);
 		$criteria->compare('charge_to_code', $this->charge_to_code, true);
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

 		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
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
 	 * @return Charge the static model class
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

 		return parent::beforeValidate();
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
 			if (!empty($this->date_expired)) {
 				if (!is_numeric($this->date_expired)) {
 					$this->date_expired = strtotime($this->date_expired);
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
 		$this->jsonArray_extra = json_decode($this->json_extra);

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
 		$result[] = array('code' => 'paid', 'title' => $this->formatEnumStatus('paid'));
 		$result[] = array('code' => 'cancel', 'title' => $this->formatEnumStatus('cancel'));
 		$result[] = array('code' => 'expired', 'title' => $this->formatEnumStatus('expired'));

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

			case 'paid': {return Yii::t('app', 'Paid'); break;}

			case 'cancel': {return Yii::t('app', 'Cancel'); break;}

			case 'expired': {return Yii::t('app', 'Expired'); break;}
			default: {return ''; break;}
		}
 	}

 	public function getEnumChargeTo($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumChargeTo(''));
 		}

 		$result[] = array('code' => 'organization', 'title' => $this->formatEnumChargeTo('organization'));
 		$result[] = array('code' => 'email', 'title' => $this->formatEnumChargeTo('email'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumChargeTo($code)
 	{
 		switch ($code) {
			case 'organization': {return Yii::t('app', 'Organization'); break;}

			case 'email': {return Yii::t('app', 'User Email'); break;}
			default: {return ''; break;}
		}
 	}

 	public function isCodeExists($code)
 	{
 		$exists = Charge::model()->find('code=:code', array(':code' => $code));
 		if ($exists === null) {
 			return false;
 		}

 		return true;
 	}
 }
