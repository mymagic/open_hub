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
 * This is the model class for table "faq".
 *
 * The followings are the available columns in table 'faq':
		 * @property integer $id
		 * @property integer $faq_group_id
		 * @property string $title_en
		 * @property string $title_ms
		 * @property string $html_content_en
		 * @property string $html_content_ms
		 * @property double $ordering
		 * @property integer $is_active
		 * @property integer $date_added
		 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property FaqGroup $faqGroup
 */
 class FaqBase extends ActiveRecord
{
	public $uploadPath;
	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'faq';

		if($this->scenario == "search")
		{
			$this->is_active = null;

		}
		else
		{
		$this->ordering = $this->count()+1;		}

	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title_en, title_ms, html_content_en, html_content_ms', 'required'),
			array('faq_group_id, is_active, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('ordering', 'numerical'),
			array('title_en, title_ms', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, faq_group_id, title_en, title_ms, html_content_en, html_content_ms, ordering, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'faqGroup' => array(self::BELONGS_TO, 'FaqGroup', 'faq_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		'id' => Yii::t('app', 'ID'),
		'faq_group_id' => Yii::t('app', 'Faq Group'),
		'title_en' => Yii::t('app', 'Title [English]'),
		'title_ms' => Yii::t('app', 'Title [Bahasa]'),
		'html_content_en' => Yii::t('app', 'Html Content [English]'),
		'html_content_ms' => Yii::t('app', 'Html Content [Bahasa]'),
		'ordering' => Yii::t('app', 'Ordering'),
		'is_active' => Yii::t('app', 'Is Active'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('faq_group_id',$this->faq_group_id);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('title_ms',$this->title_ms,true);
		$criteria->compare('html_content_en',$this->html_content_en,true);
		$criteria->compare('html_content_ms',$this->html_content_ms,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('is_active',$this->is_active);
		if(!empty($this->sdate_added) && !empty($this->edate_added))
		{
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified))
		{
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array('defaultOrder' => 't.ordering ASC'),
		));
	}
	
	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),
			'isActive' => array('condition'=>'t.is_active = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{

			// auto deal with date added and date modified
			if($this->isNewRecord)
			{
				$this->date_added=$this->date_modified=time();
			}
			else
			{
				$this->date_modified=time();
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}




	/**
	 * These are function for foregin refer usage
	 */
	public function getForeignReferList($isNullable=false, $is4Filter=false)
	{
		$language = Yii::app()->language;		
		
		if($is4Filter) $isNullable = false;
		if($isNullable) $result[] = array('key'=>'', 'title'=>'');
		$result = Yii::app()->db->createCommand()->select("id as key, title_{$language} as title")->from(self::tableName())->queryAll();
		if($is4Filter)	{ $newResult = array(); foreach($result as $r){ $newResult[$r['key']] = $r['title']; } return $newResult; }
		return $result;
	}
}
