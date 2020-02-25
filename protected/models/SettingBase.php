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
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
		 * @property string $id
		 * @property string $code
		 * @property string $value
		 * @property string $datatype
		 * @property string $datatype_value
		 * @property string $note
		 * @property integer $date_added
		 * @property integer $date_modified
 */
 class SettingBase extends ActiveRecordBase
 {
 	public $uploadPath;

 	public $sdate_added;

 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'setting';
 	}

 	/**
 	 * @return string the associated database table name
 	 */
 	public function tableName()
 	{
 		return 'setting';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('code', 'required'),
			array('date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('code', 'length', 'max' => 64),
			array('datatype', 'length', 'max' => 7),
			array('value, datatype_value, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, value, datatype, datatype_value, note, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
		'value' => Yii::t('app', 'Value'),
		'datatype' => Yii::t('app', 'Datatype'),
		'datatype_value' => Yii::t('app', 'Datatype Value'),
		'note' => Yii::t('app', 'Note'),
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

 		$criteria->compare('id', $this->id, true);
 		$criteria->compare('code', $this->code, true);
 		$criteria->compare('value', $this->value, true);
 		$criteria->compare('datatype', $this->datatype);
 		$criteria->compare('datatype_value', $this->datatype_value, true);
 		$criteria->compare('note', $this->note, true);
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
		);
 	}

 	/**
 	 * Returns the static model of the specified AR class.
 	 * Please note that you should have this exact method in all your CActiveRecord descendants!
 	 * @param string $className active record class name.
 	 * @return Setting the static model class
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

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumDatatype($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumDatatype(''));
 		}

 		$result[] = array('code' => 'boolean', 'title' => $this->formatEnumDatatype('boolean'));
 		$result[] = array('code' => 'integer', 'title' => $this->formatEnumDatatype('integer'));
 		$result[] = array('code' => 'float', 'title' => $this->formatEnumDatatype('float'));
 		$result[] = array('code' => 'string', 'title' => $this->formatEnumDatatype('string'));
 		$result[] = array('code' => 'text', 'title' => $this->formatEnumDatatype('text'));
 		$result[] = array('code' => 'html', 'title' => $this->formatEnumDatatype('html'));
 		$result[] = array('code' => 'array', 'title' => $this->formatEnumDatatype('array'));
 		$result[] = array('code' => 'enum', 'title' => $this->formatEnumDatatype('enum'));
 		$result[] = array('code' => 'date', 'title' => $this->formatEnumDatatype('date'));
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
			case 'boolean': {return Yii::t('app', 'Boolean'); break;}

			case 'integer': {return Yii::t('app', 'Integer'); break;}

			case 'float': {return Yii::t('app', 'Float'); break;}

			case 'string': {return Yii::t('app', 'String'); break;}

			case 'text': {return Yii::t('app', 'Text'); break;}

			case 'html': {return Yii::t('app', 'Html'); break;}

			case 'array': {return Yii::t('app', 'Array'); break;}

			case 'enum': {return Yii::t('app', 'Enum'); break;}

			case 'date': {return Yii::t('app', 'Date'); break;}

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
 		$result = Yii::app()->db->createCommand()->select('code as key, code as title')->from(self::tableName())->queryAll();
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
