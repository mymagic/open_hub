<?php


/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
			 * @property integer $id
			 * @property integer $parent_id
			 * @property string $object_key
			 * @property string $html_content
			 * @property string $file_main
			 * @property string $file_main_mimetype
			 * @property integer $creator_user_id
			 * @property string $creator_fullname
			 * @property string $url_creator_profile
			 * @property string $csv_ping
			 * @property integer $is_active
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property CommentUpvote[] $commentUpvotes
 */
 class CommentBase extends ActiveRecordBase
{
	public $uploadPath;

	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

		if($this->scenario == "search")
		{
			$this->is_active = null;
		}
		else
		{
		}
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, creator_user_id, is_active, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('object_key', 'length', 'max'=>128),
			array('file_main, file_main_mimetype, creator_fullname, url_creator_profile', 'length', 'max'=>255),
			array('html_content, csv_ping', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, object_key, html_content, file_main, file_main_mimetype, creator_user_id, creator_fullname, url_creator_profile, csv_ping, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'commentUpvotes' => array(self::HAS_MANY, 'CommentUpvote', 'comment_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'parent_id' => Yii::t('app', 'Parent'),
		'object_key' => Yii::t('app', 'Object Key'),
		'html_content' => Yii::t('app', 'Html Content'),
		'file_main' => Yii::t('app', 'File Main'),
		'file_main_mimetype' => Yii::t('app', 'File Main Mimetype'),
		'creator_user_id' => Yii::t('app', 'Creator User'),
		'creator_fullname' => Yii::t('app', 'Creator Fullname'),
		'url_creator_profile' => Yii::t('app', 'Url Creator Profile'),
		'csv_ping' => Yii::t('app', 'Csv Ping'),
		'is_active' => Yii::t('app', 'Is Active'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('object_key',$this->object_key,true);
		$criteria->compare('html_content',$this->html_content,true);
		$criteria->compare('file_main',$this->file_main,true);
		$criteria->compare('file_main_mimetype',$this->file_main_mimetype,true);
		$criteria->compare('creator_user_id',$this->creator_user_id);
		$criteria->compare('creator_fullname',$this->creator_fullname,true);
		$criteria->compare('url_creator_profile',$this->url_creator_profile,true);
		$criteria->compare('csv_ping',$this->csv_ping,true);
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

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'parentId' => $this->parent_id,
			'objectKey' => $this->object_key,
			'htmlContent' => $this->html_content,
			'fileMain' => $this->file_main,
			'fileMainMimetype' => $this->file_main_mimetype,
			'creatorUserId' => $this->creator_user_id,
			'creatorFullname' => $this->creator_fullname,
			'urlCreatorProfile' => $this->url_creator_profile,
			'csvPing' => $this->csv_ping,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
		
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
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * This is invoked before the record is validated.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeValidate() 
	{
		if($this->isNewRecord)
		{
		}
		else
		{
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
	


// save as null if empty
					if(empty($this->parent_id) && $this->parent_id !==0) $this->parent_id = null;
						if(empty($this->html_content)) $this->html_content = null;
						if(empty($this->file_main)) $this->file_main = null;
						if(empty($this->file_main_mimetype)) $this->file_main_mimetype = null;
						if(empty($this->creator_user_id) && $this->creator_user_id !==0) $this->creator_user_id = null;
						if(empty($this->creator_fullname)) $this->creator_fullname = null;
						if(empty($this->url_creator_profile)) $this->url_creator_profile = null;
						if(empty($this->csv_ping)) $this->csv_ping = null;
						if(empty($this->date_added) && $this->date_added !==0) $this->date_added = null;
						if(empty($this->date_modified) && $this->date_modified !==0) $this->date_modified = null;
	
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * This is invoked after the record is found.
	 */
	protected function afterFind()
	{
		// boolean
		if($this->is_active != '' || $this->is_active != null) $this->is_active = intval($this->is_active);




		parent::afterFind();
	}
	
	function behaviors() 
	{
		return array
		(
			
		);
	}
	




	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
