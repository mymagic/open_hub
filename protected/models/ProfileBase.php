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
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
			 * @property integer $user_id
			 * @property string $full_name
			 * @property string $gender
			 * @property string $address_line1
			 * @property string $address_line2
			 * @property string $town
			 * @property string $state
			 * @property string $postcode
			 * @property string $country_code
			 * @property string $mobile_no
			 * @property string $fax_no
			 * @property string $language
			 * @property string $currency
			 * @property string $timezone
			 * @property string $image_avatar
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $user
 */
 class ProfileBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $imageFile_avatar;
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
 		return 'profile';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('user_id', 'required'),
			array('user_id, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('full_name, town, state', 'length', 'max' => 128),
			array('gender', 'length', 'max' => 6),
			array('address_line1, address_line2, image_avatar', 'length', 'max' => 255),
			array('postcode', 'length', 'max' => 8),
			array('country_code', 'length', 'max' => 32),
			array('mobile_no, fax_no, timezone', 'length', 'max' => 64),
			array('language', 'length', 'max' => 2),
			array('currency', 'length', 'max' => 3),
			array('imageFile_avatar', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, full_name, gender, address_line1, address_line2, town, state, postcode, country_code, mobile_no, fax_no, language, currency, timezone, image_avatar, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		$return = array(
		'user_id' => Yii::t('app', 'User'),
		'full_name' => Yii::t('app', 'Full Name'),
		'gender' => Yii::t('app', 'Gender'),
		'address_line1' => Yii::t('app', 'Address Line1'),
		'address_line2' => Yii::t('app', 'Address Line2'),
		'town' => Yii::t('app', 'Town'),
		'state' => Yii::t('app', 'State'),
		'postcode' => Yii::t('app', 'Postcode'),
		'country_code' => Yii::t('app', 'Country Code'),
		'mobile_no' => Yii::t('app', 'Mobile No'),
		'fax_no' => Yii::t('app', 'Fax No'),
		'language' => Yii::t('app', 'Language'),
		'currency' => Yii::t('app', 'Currency'),
		'timezone' => Yii::t('app', 'Timezone'),
		'image_avatar' => Yii::t('app', 'Image Avatar'),
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

 		$criteria->compare('user_id', $this->user_id);
 		$criteria->compare('full_name', $this->full_name, true);
 		$criteria->compare('gender', $this->gender);
 		$criteria->compare('address_line1', $this->address_line1, true);
 		$criteria->compare('address_line2', $this->address_line2, true);
 		$criteria->compare('town', $this->town, true);
 		$criteria->compare('state', $this->state, true);
 		$criteria->compare('postcode', $this->postcode, true);
 		$criteria->compare('country_code', $this->country_code, true);
 		$criteria->compare('mobile_no', $this->mobile_no, true);
 		$criteria->compare('fax_no', $this->fax_no, true);
 		$criteria->compare('language', $this->language, true);
 		$criteria->compare('currency', $this->currency, true);
 		$criteria->compare('timezone', $this->timezone, true);
 		$criteria->compare('image_avatar', $this->image_avatar, true);
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
 		$return = array(
			'userId' => $this->user_id,
			'fullName' => $this->full_name,
			'gender' => $this->gender,
			'addressLine1' => $this->address_line1,
			'addressLine2' => $this->address_line2,
			'town' => $this->town,
			'state' => $this->state,
			'postcode' => $this->postcode,
			'countryCode' => $this->country_code,
			'mobileNo' => $this->mobile_no,
			'faxNo' => $this->fax_no,
			'language' => $this->language,
			'currency' => $this->currency,
			'timezone' => $this->timezone,
			'imageAvatar' => $this->image_avatar,
			'imageAvatarThumbUrl' => $this->getImageAvatarThumbUrl(),
			'imageAvatarUrl' => $this->getImageAvatarUrl(),
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
 	public function getImageAvatarUrl()
 	{
 		if (!empty($this->image_avatar)) {
 			return StorageHelper::getUrl($this->image_avatar);
 		}
 	}

 	public function getImageAvatarThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_avatar)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_avatar));
 		}
 	}

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
 	 * @return Profile the static model class
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
 			if ($this->country_code == '') {
 				$this->country_code = null;
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
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
 	public function getEnumGender($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumGender(''));
 		}

 		$result[] = array('code' => 'male', 'title' => $this->formatEnumGender('male'));
 		$result[] = array('code' => 'female', 'title' => $this->formatEnumGender('female'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumGender($code)
 	{
 		switch ($code) {
			case 'male': {return Yii::t('app', 'Male'); break;}

			case 'female': {return Yii::t('app', 'Female'); break;}
			default: {return ''; break;}
		}
 	}
 }
