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
 * This is the model class for table "embed".
 *
 * The followings are the available columns in table 'embed':
		 * @property integer $id
		 * @property string $code
		 * @property string $title_en
		 * @property string $title_ms
		 * @property string $title_zh
		 * @property string $text_description_en
		 * @property string $text_description_ms
		 * @property string $text_description_zh
		 * @property string $html_content_en
		 * @property string $html_content_ms
		 * @property string $html_content_zh
		 * @property string $image_main_en
		 * @property string $image_main_ms
		 * @property string $image_main_zh
		 * @property string $text_note
		 * @property integer $is_title_enabled
		 * @property integer $is_text_description_enabled
		 * @property integer $is_html_content_enabled
		 * @property integer $is_image_main_enabled
		 * @property integer $is_default
		 * @property integer $date_added
		 * @property integer $date_modified
 */
 class EmbedBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $imageFile_main_en;
 	public $imageFile_main_ms;
 	public $imageFile_main_zh;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'embed';
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'embed';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code, is_title_enabled, is_text_description_enabled, is_html_content_enabled, is_image_main_enabled, is_default', 'required'),
			array('is_title_enabled, is_text_description_enabled, is_html_content_enabled, is_image_main_enabled, is_default, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('code', 'length', 'max' => 32),
			array('title_en, title_ms, title_zh, image_main_en, image_main_ms, image_main_zh', 'length', 'max' => 255),
			array('text_description_en, text_description_ms, text_description_zh, html_content_en, html_content_ms, html_content_zh, text_note', 'safe'),
			array('imageFile_main_en, imageFile_main_ms, imageFile_main_zh', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, title_en, title_ms, title_zh, text_description_en, text_description_ms, text_description_zh, html_content_en, html_content_ms, html_content_zh, image_main_en, image_main_ms, image_main_zh, text_note, is_title_enabled, is_text_description_enabled, is_html_content_enabled, is_image_main_enabled, is_default, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
		'title_en' => Yii::t('app', 'Title [English]'),
		'title_ms' => Yii::t('app', 'Title [Bahasa]'),
		'title_zh' => Yii::t('app', 'Title [中文]'),
		'text_description_en' => Yii::t('app', 'Text Description [English]'),
		'text_description_ms' => Yii::t('app', 'Text Description [Bahasa]'),
		'text_description_zh' => Yii::t('app', 'Text Description [中文]'),
		'html_content_en' => Yii::t('app', 'Html Content [English]'),
		'html_content_ms' => Yii::t('app', 'Html Content [Bahasa]'),
		'html_content_zh' => Yii::t('app', 'Html Content [中文]'),
		'image_main_en' => Yii::t('app', 'Image Main [English]'),
		'image_main_ms' => Yii::t('app', 'Image Main [Bahasa]'),
		'image_main_zh' => Yii::t('app', 'Image Main [中文]'),
		'text_note' => Yii::t('app', 'Text Note'),
		'is_title_enabled' => Yii::t('app', 'Is Title Enabled'),
		'is_text_description_enabled' => Yii::t('app', 'Is Text Description Enabled'),
		'is_html_content_enabled' => Yii::t('app', 'Is Html Content Enabled'),
		'is_image_main_enabled' => Yii::t('app', 'Is Image Main Enabled'),
		'is_default' => Yii::t('app', 'Is Default'),
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
 		$criteria->compare('title_en', $this->title_en, true);
 		$criteria->compare('title_ms', $this->title_ms, true);
 		$criteria->compare('title_zh', $this->title_zh, true);
 		$criteria->compare('text_description_en', $this->text_description_en, true);
 		$criteria->compare('text_description_ms', $this->text_description_ms, true);
 		$criteria->compare('text_description_zh', $this->text_description_zh, true);
 		$criteria->compare('html_content_en', $this->html_content_en, true);
 		$criteria->compare('html_content_ms', $this->html_content_ms, true);
 		$criteria->compare('html_content_zh', $this->html_content_zh, true);
 		$criteria->compare('image_main_en', $this->image_main_en, true);
 		$criteria->compare('image_main_ms', $this->image_main_ms, true);
 		$criteria->compare('image_main_zh', $this->image_main_zh, true);
 		$criteria->compare('text_note', $this->text_note, true);
 		$criteria->compare('is_title_enabled', $this->is_title_enabled);
 		$criteria->compare('is_text_description_enabled', $this->is_text_description_enabled);
 		$criteria->compare('is_html_content_enabled', $this->is_html_content_enabled);
 		$criteria->compare('is_image_main_enabled', $this->is_image_main_enabled);
 		$criteria->compare('is_default', $this->is_default);
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
			'isTitleEnabled' => array('condition' => 't.is_title_enabled = 1'),
			'isTextDescriptionEnabled' => array('condition' => 't.is_text_description_enabled = 1'),
			'isHtmlContentEnabled' => array('condition' => 't.is_html_content_enabled = 1'),
			'isImageMainEnabled' => array('condition' => 't.is_image_main_enabled = 1'),
			'isDefault' => array('condition' => 't.is_default = 1'),
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Embed the static model class
 	 */
 	public static function model($className = __CLASS__)
 	{
 		return parent::model($className);
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

 			return true;
 		} else {
 			return false;
 		}
 	}
 }
