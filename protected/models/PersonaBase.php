<?php

 /**
  * This is the model class for table "persona".
  *
  * The followings are the available columns in table 'persona':
  *
  * @property int $id
  * @property string $code
  * @property string $slug
  * @property string $title
  * @property string $text_short_description
  * @property int $is_active
  * @property int $date_added
  * @property int $date_modified
  * @property string $title_en
  * @property string $title_ms
  * @property string $text_short_description_en
  * @property string $text_short_description_ms
  *
  * The followings are the available model relations:
  * @property Event[] $events
  * @property Individual[] $individuals
  * @property Intake[] $intakes
  * @property Organization[] $organizations
  * @property resource[] $resources
  */
 class PersonaBase extends ActiveRecordBase
 {
     public $uploadPath;

     public $sdate_added;

     public $edate_added;
     public $sdate_modified;
     public $edate_modified;

     public function init()
     {
         $this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.$this->tableName();

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
         return 'persona';
     }

     /**
      * @return array validation rules for model attributes
      */
     public function rules()
     {
         // NOTE: you should only define rules for those attributes that
         // will receive user inputs.
         return array(
            array('code, slug, title, title_en, title_ms', 'required'),
            array('is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
            array('code, slug', 'length', 'max' => 64),
            array('title, title_en, title_ms', 'length', 'max' => 100),
            array('text_short_description, text_short_description_en, text_short_description_ms', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, slug, title, text_short_description, is_active, date_added, date_modified, title_en, title_ms, text_short_description_en, text_short_description_ms, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
        );
     }

     /**
      * @return array relational rules
      */
     public function relations()
     {
         // NOTE: you may need to adjust the relation name and the related
         // class name for the relations automatically generated below.
         return array(
            'events' => array(self::MANY_MANY, 'Event', 'event2persona(persona_id, event_id)'),
            'individuals' => array(self::MANY_MANY, 'Individual', 'persona2individual(persona_id, individual_id)'),
            'organizations' => array(self::MANY_MANY, 'Organization', 'persona2organization(persona_id, organization_id)'),
            'resources' => array(self::MANY_MANY, 'Resource', 'resource2persona(persona_id, resource_id)'),
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
        'slug' => Yii::t('app', 'Slug'),
        'title' => Yii::t('app', 'Title'),
        'text_short_description' => Yii::t('app', 'Text Short Description'),
        'is_active' => Yii::t('app', 'Is Active'),
        'date_added' => Yii::t('app', 'Date Added'),
        'date_modified' => Yii::t('app', 'Date Modified'),
        'title_en' => Yii::t('app', 'Title [English]'),
        'title_ms' => Yii::t('app', 'Title [Bahasa]'),
        'text_short_description_en' => Yii::t('app', 'Text Short Description [English]'),
        'text_short_description_ms' => Yii::t('app', 'Text Short Description [Bahasa]'),
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
      *                             based on the search/filter conditions
      */
     public function search()
     {
         // @todo Please modify the following code to remove attributes that should not be searched.

         $criteria = new CDbCriteria();

         $criteria->compare('id', $this->id);
         $criteria->compare('code', $this->code, true);
         $criteria->compare('slug', $this->slug, true);
         $criteria->compare('title', $this->title, true);
         $criteria->compare('text_short_description', $this->text_short_description, true);
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
         $criteria->compare('title_en', $this->title_en, true);
         $criteria->compare('title_ms', $this->title_ms, true);
         $criteria->compare('text_short_description_en', $this->text_short_description_en, true);
         $criteria->compare('text_short_description_ms', $this->text_short_description_ms, true);

         return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
     }

     public function toApi($params = '')
     {
         $this->fixSpatial();

         $return = array(
            'id' => $this->id,
            'code' => $this->code,
            'slug' => $this->slug,
            'title' => $this->title,
            'textShortDescription' => $this->text_short_description,
            'isActive' => $this->is_active,
            'dateAdded' => $this->date_added,
            'fDateAdded' => $this->renderDateAdded(),
            'dateModified' => $this->date_modified,
            'fDateModified' => $this->renderDateModified(),
            'titleEn' => $this->title_en,
            'titleMs' => $this->title_ms,
            'textShortDescriptionEn' => $this->text_short_description_en,
            'textShortDescriptionMs' => $this->text_short_description_ms,
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
         return array(
            // 'isActive'=>array('condition'=>"t.is_active = 1"),

            'isActive' => array('condition' => 't.is_active = 1'),
        );
     }

     /**
      * Returns the static model of the specified AR class.
      * Please note that you should have this exact method in all your CActiveRecord descendants!
      *
      * @param string $className active record class name
      *
      * @return Persona the static model class
      */
     public static function model($className = __CLASS__)
     {
         return parent::model($className);
     }

     /**
      * This is invoked before the record is validated.
      *
      * @return bool whether the record should be saved
      */
     public function beforeValidate()
     {
         if ($this->isNewRecord) {
             // UUID
             $this->code = ysUtil::generateUUID();
         } else {
             // UUID
             if (empty($this->code)) {
                 $this->code = ysUtil::generateUUID();
             }
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
      *
      * @return bool whether the record should be saved
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

             // save as null if empty
             if (empty($this->text_short_description)) {
                 $this->text_short_description = null;
             }
             if (empty($this->text_short_description_en)) {
                 $this->text_short_description_en = null;
             }
             if (empty($this->text_short_description_ms)) {
                 $this->text_short_description_ms = null;
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

         parent::afterFind();
     }

     public function behaviors()
     {
         return array(
        );
     }

     /**
      * These are function for foregin refer usage.
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

     public function isCodeExists($code)
     {
         $exists = Persona::model()->find('code=:code', array(':code' => $code));
         if ($exists === null) {
             return false;
         }

         return true;
     }

     /**
      * These are function for spatial usage.
      */
     public function fixSpatial()
     {
     }
 }
