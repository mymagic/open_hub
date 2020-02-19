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
 * This is the model class for table "magic_misc.news".
 *
 * The followings are the available columns in table 'magic_misc.news':
			 * @property integer $id
			 * @property integer $organization_id
			 * @property string $title
			 * @property string $text
			 * @property string $publish_date
			 * @property string $author
			 * @property string $url
			 * @property string $source
			 * @property string $header_image
			 * @property string $keywords
			 * @property string $summary
			 * @property string $scrape_date
 */
 class NewsBase extends ActiveRecordBase
{
	public $uploadPath;

	
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

		if($this->scenario == "search") {
		} else {
		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'magic_misc.news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organization_id, scrape_date', 'required'),
			array('organization_id', 'numerical', 'integerOnly'=>true),
			array('title, author, url, source, header_image', 'length', 'max'=>255),
			array('text, publish_date, keywords, summary', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, organization_id, title, text, publish_date, author, url, source, header_image, keywords, summary, scrape_date', 'safe', 'on'=>'search'),
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
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'organization_id' => Yii::t('app', 'Organization'),
		'title' => Yii::t('app', 'Title'),
		'text' => Yii::t('app', 'Text'),
		'publish_date' => Yii::t('app', 'Publish Date'),
		'author' => Yii::t('app', 'Author'),
		'url' => Yii::t('app', 'Url'),
		'source' => Yii::t('app', 'Source'),
		'header_image' => Yii::t('app', 'Header Image'),
		'keywords' => Yii::t('app', 'Keywords'),
		'summary' => Yii::t('app', 'Summary'),
		'scrape_date' => Yii::t('app', 'Scrape Date'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('organization_id',$this->organization_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('publish_date',$this->publish_date,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('header_image',$this->header_image,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('scrape_date',$this->scrape_date,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'organizationId' => $this->organization_id,
			'title' => $this->title,
			'text' => $this->text,
			'publishDate' => $this->publish_date,
			'author' => $this->author,
			'url' => $this->url,
			'source' => $this->source,
			'headerImage' => $this->header_image,
			'keywords' => $this->keywords,
			'summary' => $this->summary,
			'scrapeDate' => $this->scrape_date,
		
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

	public function scopes()
    {
		return array
		(
			// 'isActive'=>array('condition'=>"t.is_active = 1"),


		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
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
		if($this->isNewRecord) {
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
		if(parent::beforeSave()) {

	


			// save as null if empty
					if(empty($this->title)) $this->title = null;
						if(empty($this->text)) $this->text = null;
						if(empty($this->publish_date)) $this->publish_date = null;
						if(empty($this->author)) $this->author = null;
						if(empty($this->url)) $this->url = null;
						if(empty($this->source)) $this->source = null;
						if(empty($this->header_image)) $this->header_image = null;
						if(empty($this->keywords)) $this->keywords = null;
						if(empty($this->summary)) $this->summary = null;
	
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
	
	function behaviors() 
	{
		return array(
			
		);
	}
	




	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
