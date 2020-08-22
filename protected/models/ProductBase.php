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
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
			 * @property integer $id
			 * @property integer $organization_id
			 * @property integer $product_category_id
			 * @property string $title
			 * @property string $text_short_description
			 * @property string $typeof
			 * @property string $image_cover
			 * @property string $url_website
			 * @property integer $is_active
			 * @property integer $date_added
			 * @property integer $date_modified
			 * @property string $price_min
			 * @property string $price_max
 *
 * The followings are the available model relations:
 * @property Organization $organization
 * @property ProductCategory $productCategory
 */
 class ProductBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $imageFile_cover;
 	public $sdate_added;
 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'product';

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
 		return 'product';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('organization_id, title, text_short_description', 'required'),
			array('organization_id, product_category_id, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('title', 'length', 'max' => 100),
			array('typeof', 'length', 'max' => 7),
			array('image_cover, url_website', 'length', 'max' => 255),
			array('price_min, price_max', 'length', 'max' => 10),
			array('imageFile_cover', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, organization_id, product_category_id, title, text_short_description, typeof, image_cover, url_website, is_active, date_added, date_modified, price_min, price_max, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		return array(
		'id' => Yii::t('app', 'ID'),
		'organization_id' => Yii::t('app', 'Organization'),
		'product_category_id' => Yii::t('app', 'Product Category'),
		'title' => Yii::t('app', 'Title'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'typeof' => Yii::t('app', 'Typeof'),
		'image_cover' => Yii::t('app', 'Image Cover'),
		'url_website' => Yii::t('app', 'Url Website'),
		'is_active' => Yii::t('app', 'Is Active'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		'price_min' => Yii::t('app', 'Price Min'),
		'price_max' => Yii::t('app', 'Price Max'),
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
 		$criteria->compare('organization_id', $this->organization_id);
 		$criteria->compare('product_category_id', $this->product_category_id);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('typeof', $this->typeof);
 		$criteria->compare('image_cover', $this->image_cover, true);
 		$criteria->compare('url_website', $this->url_website, true);
 		$criteria->compare('is_active', $this->is_active);
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
 		$criteria->compare('price_min', $this->price_min, true);
 		$criteria->compare('price_max', $this->price_max, true);

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
 	 * @return Product the static model class
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

 		return parent::beforeValidate();
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
 	public function getEnumTypeof($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumTypeof(''));
 		}

 		$result[] = array('code' => 'service', 'title' => $this->formatEnumTypeof('service'));
 		$result[] = array('code' => 'product', 'title' => $this->formatEnumTypeof('product'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}

 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumTypeof($code)
 	{
 		switch ($code) {
			case 'service': {return Yii::t('app', 'Service'); break;}

			case 'product': {return Yii::t('app', 'Product'); break;}
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
 }
