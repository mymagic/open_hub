<?php


/**
 * This is the model class for table "sample".
 *
 * The followings are the available columns in table 'sample':
			 * @property integer $id
			 * @property string $code
			 * @property integer $sample_group_id
			 * @property string $sample_zone_code
			 * @property string $title_en
			 * @property string $title_ms
			 * @property string $title_zh
			 * @property string $text_short_description_en
			 * @property string $text_short_description_ms
			 * @property string $text_short_description_zh
			 * @property string $html_content_en
			 * @property string $html_content_ms
			 * @property string $html_content_zh
			 * @property string $image_main
			 * @property string $file_backup
			 * @property string $price_main
			 * @property string $gender
			 * @property integer $age
			 * @property string $csv_keyword
			 * @property double $ordering
			 * @property integer $date_posted
			 * @property integer $is_active
			 * @property integer $is_public
			 * @property integer $is_member
			 * @property integer $is_admin
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property SampleGroup $sampleGroup
 * @property SampleZone $sampleZone
 */
 class SampleBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $imageFile_main;
 	public $sdate_posted;
 	public $edate_posted;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();

 		if ($this->scenario == 'search') {
 			$this->is_active = null;
 			$this->is_public = null;
 			$this->is_member = null;
 			$this->is_admin = null;
 		} else {
 			$this->ordering = $this->count() + 1;
 		}
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'sample';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, title_en, title_ms, title_zh, text_short_description_en, text_short_description_ms, text_short_description_zh, date_posted', 'required'),
			array('sample_group_id, age, date_posted, is_active, is_public, is_member, is_admin, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('ordering', 'numerical'),
			array('code, sample_zone_code', 'length', 'max' => 32),
			array('title_en, title_ms, title_zh', 'length', 'max' => 100),
			array('text_short_description_en, text_short_description_ms, text_short_description_zh, image_main, file_backup', 'length', 'max' => 255),
			array('price_main', 'length', 'max' => 10),
			array('gender', 'length', 'max' => 6),
			array('html_content_en, html_content_ms, html_content_zh, csv_keyword', 'safe'),
			array('imageFile_main', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, sample_group_id, sample_zone_code, title_en, title_ms, title_zh, text_short_description_en, text_short_description_ms, text_short_description_zh, html_content_en, html_content_ms, html_content_zh, image_main, file_backup, price_main, gender, age, csv_keyword, ordering, date_posted, is_active, is_public, is_member, is_admin, date_added, date_modified, sdate_posted, edate_posted, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'sampleGroup' => array(self::BELONGS_TO, 'SampleGroup', 'sample_group_id'),
			'sampleZone' => array(self::BELONGS_TO, 'SampleZone', 'sample_zone_code'),
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
		'sample_group_id' => Yii::t('app', 'Sample Group'),
		'sample_zone_code' => Yii::t('app', 'Sample Zone Code'),
		'title_en' => Yii::t('app', 'Title [English]'),
		'title_ms' => Yii::t('app', 'Title [Bahasa]'),
		'title_zh' => Yii::t('app', 'Title [中文]'),
		'text_short_description_en' => Yii::t('app', 'Text Short Description [English]'),
		'text_short_description_ms' => Yii::t('app', 'Text Short Description [Bahasa]'),
		'text_short_description_zh' => Yii::t('app', 'Text Short Description [中文]'),
		'html_content_en' => Yii::t('app', 'Html Content [English]'),
		'html_content_ms' => Yii::t('app', 'Html Content [Bahasa]'),
		'html_content_zh' => Yii::t('app', 'Html Content [中文]'),
		'image_main' => Yii::t('app', 'Image Main'),
		'file_backup' => Yii::t('app', 'File Backup'),
		'price_main' => Yii::t('app', 'Price Main'),
		'gender' => Yii::t('app', 'Gender'),
		'age' => Yii::t('app', 'Age'),
		'csv_keyword' => Yii::t('app', 'Csv Keyword'),
		'ordering' => Yii::t('app', 'Ordering'),
		'date_posted' => Yii::t('app', 'Date Posted'),
		'is_active' => Yii::t('app', 'Is Active'),
		'is_public' => Yii::t('app', 'Is Public'),
		'is_member' => Yii::t('app', 'Is Member'),
		'is_admin' => Yii::t('app', 'Is Admin'),
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
 		$criteria->compare('code', $this->code, true);
 		$criteria->compare('sample_group_id', $this->sample_group_id);
 		$criteria->compare('sample_zone_code', $this->sample_zone_code, true);
 		$criteria->compare('title_en', $this->title_en, true);
 		$criteria->compare('title_ms', $this->title_ms, true);
 		$criteria->compare('title_zh', $this->title_zh, true);
 		$criteria->compare('text_short_description_en', $this->text_short_description_en, true);
 		$criteria->compare('text_short_description_ms', $this->text_short_description_ms, true);
 		$criteria->compare('text_short_description_zh', $this->text_short_description_zh, true);
 		$criteria->compare('html_content_en', $this->html_content_en, true);
 		$criteria->compare('html_content_ms', $this->html_content_ms, true);
 		$criteria->compare('html_content_zh', $this->html_content_zh, true);
 		$criteria->compare('image_main', $this->image_main, true);
 		$criteria->compare('file_backup', $this->file_backup, true);
 		$criteria->compare('price_main', $this->price_main, true);
 		$criteria->compare('gender', $this->gender);
 		$criteria->compare('age', $this->age);
 		$criteria->compare('csv_keyword', $this->csv_keyword, true);
 		$criteria->compare('ordering', $this->ordering);
 		if (!empty($this->sdate_posted) && !empty($this->edate_posted)) {
 			$sTimestamp = strtotime($this->sdate_posted);
 			$eTimestamp = strtotime("{$this->edate_posted} +1 day");
 			$criteria->addCondition(sprintf('date_posted >= %s AND date_posted < %s', $sTimestamp, $eTimestamp));
 		}
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('is_public', $this->is_public);
 		$criteria->compare('is_member', $this->is_member);
 		$criteria->compare('is_admin', $this->is_admin);
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

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'code' => $this->code,
			'sampleGroupId' => $this->sample_group_id,
			'sampleZoneCode' => $this->sample_zone_code,
			'titleEn' => $this->title_en,
			'titleMs' => $this->title_ms,
			'titleZh' => $this->title_zh,
			'textShortDescriptionEn' => $this->text_short_description_en,
			'textShortDescriptionMs' => $this->text_short_description_ms,
			'textShortDescriptionZh' => $this->text_short_description_zh,
			'htmlContentEn' => $this->html_content_en,
			'htmlContentMs' => $this->html_content_ms,
			'htmlContentZh' => $this->html_content_zh,
			'imageMain' => $this->image_main,
			'imageMainThumbUrl' => $this->getImageMainThumbUrl(),
			'imageMainUrl' => $this->getImageMainUrl(),
			'fileBackup' => $this->file_backup,
			'priceMain' => $this->price_main,
			'gender' => $this->gender,
			'age' => $this->age,
			'csvKeyword' => $this->csv_keyword,
			'ordering' => $this->ordering,
			'datePosted' => $this->date_posted,
			'fDatePosted' => $this->renderDatePosted(),
			'isActive' => $this->is_active,
			'isPublic' => $this->is_public,
			'isMember' => $this->is_member,
			'isAdmin' => $this->is_admin,
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
 	public function getImageMainUrl()
 	{
 		if (!empty($this->image_main)) {
 			return StorageHelper::getUrl($this->image_main);
 		}
 	}

 	public function getImageMainThumbUrl($width = 100, $height = 100)
 	{
 		if (!empty($this->image_main)) {
 			return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_main));
 		}
 	}

 	//
 	// date
 	public function getTimezone()
 	{
 		return date_default_timezone_get();
 	}

 	public function renderDatePosted()
 	{
 		return Html::formatDateTimezone($this->date_posted, 'standard', 'standard', '-', $this->getTimezone());
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
			'isPublic' => array('condition' => 't.is_public = 1'),
			'isMember' => array('condition' => 't.is_member = 1'),
			'isAdmin' => array('condition' => 't.is_admin = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Sample the static model class
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
 			if ($this->sample_zone_code == '') {
 				$this->sample_zone_code = null;
 			}
 			if (!empty($this->date_posted)) {
 				if (!is_numeric($this->date_posted)) {
 					$this->date_posted = strtotime($this->date_posted);
 				}
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// save as null if empty
 			if (empty($this->sample_group_id) && $this->sample_group_id != 0) {
 				$this->sample_group_id = null;
 			}
 			if (empty($this->sample_zone_code)) {
 				$this->sample_zone_code = null;
 			}
 			if (empty($this->html_content_en)) {
 				$this->html_content_en = null;
 			}
 			if (empty($this->html_content_ms)) {
 				$this->html_content_ms = null;
 			}
 			if (empty($this->html_content_zh)) {
 				$this->html_content_zh = null;
 			}
 			if (empty($this->image_main)) {
 				$this->image_main = null;
 			}
 			if (empty($this->file_backup)) {
 				$this->file_backup = null;
 			}
 			if (empty($this->price_main)) {
 				$this->price_main = null;
 			}
 			if (empty($this->gender)) {
 				$this->gender = null;
 			}
 			if (empty($this->age) && $this->age != 0) {
 				$this->age = null;
 			}
 			if (empty($this->csv_keyword)) {
 				$this->csv_keyword = null;
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
 		if ($this->is_public != '' || $this->is_public != null) {
 			$this->is_public = intval($this->is_public);
 		}
 		if ($this->is_member != '' || $this->is_member != null) {
 			$this->is_member = intval($this->is_member);
 		}
 		if ($this->is_admin != '' || $this->is_admin != null) {
 			$this->is_admin = intval($this->is_admin);
 		}

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
 		$result[] = array('code' => 'secret', 'title' => $this->formatEnumGender('secret'));

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

			case 'secret': {return Yii::t('app', 'Secret'); break;}
			default: {return ''; break;}
		}
 	}

 	public function isCodeExists($code)
 	{
 		$exists = Sample::model()->find('code=:code', array(':code' => $code));
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
