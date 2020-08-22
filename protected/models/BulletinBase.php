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
 * This is the model class for table "bulletin".
 *
 * The followings are the available columns in table 'bulletin':
		 * @property integer $id
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
		 * @property integer $date_posted
		 * @property integer $is_active
		 * @property integer $is_public
		 * @property integer $is_member
		 * @property integer $is_admin
		 * @property integer $date_added
		 * @property integer $date_modified
 */

class BulletinBase extends ActiveRecordBase
{
	public $uploadPath;

	public $imageFile_main;

	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'bulletin';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bulletin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title_en, title_ms, title_zh, text_short_description_en, text_short_description_ms, text_short_description_zh, date_posted', 'required'),
			array('date_posted, is_active, is_public, is_member, is_admin, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('title_en, title_ms, title_zh', 'length', 'max' => 100),
			array('text_short_description_en, text_short_description_ms, text_short_description_zh, image_main', 'length', 'max' => 255),
			array('html_content_en, html_content_ms, html_content_zh', 'safe'),
			array('imageFile_main', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title_en, title_ms, title_zh, text_short_description_en, text_short_description_ms, text_short_description_zh, html_content_en, html_content_ms, html_content_zh, image_main, date_posted, is_active, is_public, is_member, is_admin, date_added, date_modified', 'safe', 'on' => 'search'),
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
		'date_posted' => Yii::t('app', 'Date Posted'),
		'is_active' => Yii::t('app', 'Is Active'),
		'is_public' => Yii::t('app', 'Is Public'),
		'is_member' => Yii::t('app', 'Is Member'),
		'is_admin' => Yii::t('app', 'Is Admin'),
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
		$criteria->compare('date_posted', $this->date_posted);
		$criteria->compare('is_active', $this->is_active);
		$criteria->compare('is_public', $this->is_public);
		$criteria->compare('is_member', $this->is_member);
		$criteria->compare('is_admin', $this->is_admin);
		$criteria->compare('date_added', $this->date_added);
		$criteria->compare('date_modified', $this->date_modified);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
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
	 * @return Bulletin the static model class
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

			return true;
		} else {
			return false;
		}
	}
}
