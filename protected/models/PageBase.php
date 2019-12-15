<?php


/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
		 * @property integer $id
		 * @property string $slug
		 * @property string $menu_code
		 * @property string $title
		 * @property string $text_keyword
		 * @property string $text_description
		 * @property string $html_content
		 * @property integer $is_active
		 * @property integer $is_default
		 * @property integer $date_added
		 * @property integer $date_modified
 */
 class PageBase extends ActiveRecordBase
{
	public $uploadPath;
	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'page';

	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slug, title', 'required'),
			array('is_active, is_default, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('slug, menu_code', 'length', 'max'=>32),
			array('title', 'length', 'max'=>128),
			array('text_keyword, text_description, html_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug, menu_code, title, text_keyword, text_description, html_content, is_active, is_default, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
		'slug' => Yii::t('app', 'Slug'),
		'menu_code' => Yii::t('app', 'Menu Code'),
		'title' => Yii::t('app', 'Title'),
		'text_keyword' => Yii::t('app', 'Text Keyword'),
		'text_description' => Yii::t('app', 'Text Description'),
		'html_content' => Yii::t('app', 'Html Content'),
		'is_active' => Yii::t('app', 'Is Active'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('menu_code',$this->menu_code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text_keyword',$this->text_keyword,true);
		$criteria->compare('text_description',$this->text_description,true);
		$criteria->compare('html_content',$this->html_content,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_default',$this->is_default);
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

		));
	}
	
	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),
			'isActive' => array('condition'=>'t.is_active = 1'),
			'isDefault' => array('condition'=>'t.is_default = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Page the static model class
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
			if($this->menu_code == '') $this->menu_code = NULL;

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




}
