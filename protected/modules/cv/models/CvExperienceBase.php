<?php


/**
 * This is the model class for table "cv_experience".
 *
 * The followings are the available columns in table 'cv_experience':
			 * @property integer $id
			 * @property integer $cv_portfolio_id
			 * @property string $genre
			 * @property string $title
			 * @property string $organization_name
			 * @property string $location
			 * @property string $full_address
			 * @property string $latlong_address
			 * @property string $state_code
			 * @property string $country_code
			 * @property string $text_short_description
			 * @property integer $year_start
			 * @property string $month_start
			 * @property integer $year_end
			 * @property string $month_end
			 * @property integer $is_active
			 * @property string $json_extra
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property CvPortfolio $cvPortfolio
 * @property State $state
 * @property CvPortfolio[] $cvPortfolios
 */
 class CvExperienceBase extends ActiveRecord
 {
 	public $uploadPath;

 	public $sdate_added;

 	public $edate_added;
 	public $sdate_modified;
 	public $edate_modified;

 	// json
 	public $jsonArray_extra;

 	public function init()
 	{
 		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();
 		// meta
 		$this->initMetaStructure($this->tableName());

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
 		return 'cv_experience';
 	}

 	/**
 	 * @return array validation rules for model attributes.
 	 */
 	public function rules()
 	{
 		// NOTE: you should only define rules for those attributes that
 		// will receive user inputs.
 		return array(
			array('cv_portfolio_id, title, year_start', 'required'),
			array('cv_portfolio_id, year_start, year_end, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('genre', 'length', 'max' => 7),
			array('title, organization_name, location', 'length', 'max' => 255),
			array('state_code', 'length', 'max' => 12),
			array('country_code, month_start, month_end', 'length', 'max' => 2),
			array('full_address, latlong_address, text_short_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cv_portfolio_id, genre, title, organization_name, location, full_address, latlong_address, state_code, country_code, text_short_description, year_start, month_start, year_end, month_end, is_active, json_extra, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
			// meta
			array('_dynamicData', 'safe'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_code'),
			'cvPortfolio' => array(self::BELONGS_TO, 'CvPortfolio', 'cv_portfolio_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_code'),
			'cvPortfolios' => array(self::HAS_MANY, 'CvPortfolio', 'high_academy_experience_id'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
 	}

 	/**
 	 * @return array customized attribute labels (name=>label)
 	 */
 	public function attributeLabels()
 	{
 		$return = array(
		'id' => Yii::t('app', 'ID'),
		'cv_portfolio_id' => Yii::t('app', 'Cv Portfolio'),
		'genre' => Yii::t('app', 'Genre'),
		'title' => Yii::t('app', 'Title'),
		'organization_name' => Yii::t('app', 'Organization Name'),
		'location' => Yii::t('app', 'Location'),
		'full_address' => Yii::t('app', 'Full Address'),
		'latlong_address' => Yii::t('app', 'Latlong Address'),
		'state_code' => Yii::t('app', 'State Code'),
		'country_code' => Yii::t('app', 'Country Code'),
		'text_short_description' => Yii::t('app', 'Text Short Description'),
		'year_start' => Yii::t('app', 'Year Start'),
		'month_start' => Yii::t('app', 'Month Start'),
		'year_end' => Yii::t('app', 'Year End'),
		'month_end' => Yii::t('app', 'Month End'),
		'is_active' => Yii::t('app', 'Is Active'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);

 		// meta
 		$return = array_merge((array)$return, array_keys($this->_dynamicFields));
 		foreach ($this->_metaStructures as $metaStruct) {
 			$return["_dynamicData[{$metaStruct->code}]"] = Yii::t('app', $metaStruct->label);
 		}

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
 		$criteria->compare('cv_portfolio_id', $this->cv_portfolio_id);
 		$criteria->compare('genre', $this->genre);
 		$criteria->compare('title', $this->title, true);
 		$criteria->compare('organization_name', $this->organization_name, true);
 		$criteria->compare('location', $this->location, true);
 		$criteria->compare('full_address', $this->full_address, true);
 		$criteria->compare('latlong_address', $this->latlong_address, true);
 		$criteria->compare('state_code', $this->state_code, true);
 		$criteria->compare('country_code', $this->country_code, true);
 		$criteria->compare('text_short_description', $this->text_short_description, true);
 		$criteria->compare('year_start', $this->year_start);
 		$criteria->compare('month_start', $this->month_start);
 		$criteria->compare('year_end', $this->year_end);
 		$criteria->compare('month_end', $this->month_end);
 		$criteria->compare('is_active', $this->is_active);
 		$criteria->compare('json_extra', $this->json_extra, true);
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

 	public function toApi($params = '')
 	{
 		$this->fixSpatial();

 		$return = array(
			'id' => $this->id,
			'cvPortfolioId' => $this->cv_portfolio_id,
			'genre' => $this->genre,
			'title' => $this->title,
			'organizationName' => $this->organization_name,
			'location' => $this->location,
			'fullAddress' => $this->full_address,
			'latlongAddress' => $this->latlong_address,
			'stateCode' => $this->state_code,
			'countryCode' => $this->country_code,
			'textShortDescription' => $this->text_short_description,
			'yearStart' => $this->year_start,
			'monthStart' => $this->month_start,
			'yearEnd' => $this->year_end,
			'monthEnd' => $this->month_end,
			'isActive' => $this->is_active,
			'jsonExtra' => $this->json_extra,
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
 	 * @param string $className active record class name.
 	 * @return CvExperience the static model class
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
 		if (Yii::app()->neo4j->getStatus()) {
 			Neo4jCvExperience::model($this)->sync();
 		}

 		return parent::afterSave();
 	}

 	protected function afterDelete()
 	{
 		// custom code here
 		// ...
 		if (Yii::app()->neo4j->getStatus()) {
 			Neo4jCvExperience::model()->deleteOneByPk($this->id);
 		}

 		return parent::afterDelete();
 	}

 	/**
 	 * This is invoked before the record is saved.
 	 * @return boolean whether the record should be saved.
 	 */
 	protected function beforeSave()
 	{
 		if (parent::beforeSave()) {
 			if ($this->state_code == '') {
 				$this->state_code = null;
 			}
 			if ($this->country_code == '') {
 				$this->country_code = null;
 			}

 			// auto deal with date added and date modified
 			if ($this->isNewRecord) {
 				$this->date_added = $this->date_modified = time();
 			} else {
 				$this->date_modified = time();
 			}

 			// json
 			$this->json_extra = json_encode($this->jsonArray_extra);
 			if ($this->json_extra == 'null') {
 				$this->json_extra = null;
 			}

 			// save as null if empty
 			if (empty($this->organization_name)) {
 				$this->organization_name = null;
 			}
 			if (empty($this->location)) {
 				$this->location = null;
 			}
 			if (empty($this->full_address)) {
 				$this->full_address = null;
 			}
 			if (empty($this->latlong_address) && $this->latlong_address !== 0) {
 				$this->latlong_address = null;
 			}
 			if (empty($this->state_code)) {
 				$this->state_code = null;
 			}
 			if (empty($this->country_code)) {
 				$this->country_code = null;
 			}
 			if (empty($this->text_short_description)) {
 				$this->text_short_description = null;
 			}
 			if (empty($this->month_start)) {
 				$this->month_start = null;
 			}
 			if (empty($this->year_end) && $this->year_end !== 0) {
 				$this->year_end = null;
 			}
 			if (empty($this->month_end)) {
 				$this->month_end = null;
 			}
 			if (empty($this->json_extra)) {
 				$this->json_extra = null;
 			}
 			if (empty($this->date_added) && $this->date_added !== 0) {
 				$this->date_added = null;
 			}
 			if (empty($this->date_modified) && $this->date_modified !== 0) {
 				$this->date_modified = null;
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

 		$this->jsonArray_extra = json_decode($this->json_extra);

 		parent::afterFind();
 	}

 	public function behaviors()
 	{
 		return array(
			'spatial' => array(
				'class' => 'application.yeebase.components.behaviors.SpatialDataBehavior',
				'spatialFields' => array(
					// all spatial fields here
					'latlong_address'
				),
			),
		);
 	}

 	/**
 	 * These are function for enum usage
 	 */
 	public function getEnumGenre($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumGenre(''));
 		}

 		$result[] = array('code' => 'job', 'title' => $this->formatEnumGenre('job'));
 		$result[] = array('code' => 'study', 'title' => $this->formatEnumGenre('study'));
 		$result[] = array('code' => 'project', 'title' => $this->formatEnumGenre('project'));
 		$result[] = array('code' => 'others', 'title' => $this->formatEnumGenre('others'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumGenre($code)
 	{
 		switch ($code) {
			case 'job': {return Yii::t('app', 'Job'); break;}

			case 'study': {return Yii::t('app', 'Study'); break;}

			case 'project': {return Yii::t('app', 'Project'); break;}

			case 'others': {return Yii::t('app', 'Others'); break;}
			default: {return ''; break;}
		}
 	}

 	public function getEnumMonthStart($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumMonthStart(''));
 		}

 		$result[] = array('code' => '1', 'title' => $this->formatEnumMonthStart('1'));
 		$result[] = array('code' => '2', 'title' => $this->formatEnumMonthStart('2'));
 		$result[] = array('code' => '3', 'title' => $this->formatEnumMonthStart('3'));
 		$result[] = array('code' => '4', 'title' => $this->formatEnumMonthStart('4'));
 		$result[] = array('code' => '5', 'title' => $this->formatEnumMonthStart('5'));
 		$result[] = array('code' => '6', 'title' => $this->formatEnumMonthStart('6'));
 		$result[] = array('code' => '7', 'title' => $this->formatEnumMonthStart('7'));
 		$result[] = array('code' => '8', 'title' => $this->formatEnumMonthStart('8'));
 		$result[] = array('code' => '9', 'title' => $this->formatEnumMonthStart('9'));
 		$result[] = array('code' => '10', 'title' => $this->formatEnumMonthStart('10'));
 		$result[] = array('code' => '11', 'title' => $this->formatEnumMonthStart('11'));
 		$result[] = array('code' => '12', 'title' => $this->formatEnumMonthStart('12'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumMonthStart($code)
 	{
 		switch ($code) {
			case '1': {return Yii::t('app', 'Jan'); break;}

			case '2': {return Yii::t('app', 'Feb'); break;}

			case '3': {return Yii::t('app', 'Mar'); break;}

			case '4': {return Yii::t('app', 'Apr'); break;}

			case '5': {return Yii::t('app', 'May'); break;}

			case '6': {return Yii::t('app', 'Jun'); break;}

			case '7': {return Yii::t('app', 'Jul'); break;}

			case '8': {return Yii::t('app', 'Aug'); break;}

			case '9': {return Yii::t('app', 'Sep'); break;}

			case '10': {return Yii::t('app', 'Oct'); break;}

			case '11': {return Yii::t('app', 'Nov'); break;}

			case '12': {return Yii::t('app', 'Dec'); break;}
			default: {return ''; break;}
		}
 	}

 	public function getEnumMonthEnd($isNullable = false, $is4Filter = false)
 	{
 		if ($is4Filter) {
 			$isNullable = false;
 		}
 		if ($isNullable) {
 			$result[] = array('code' => '', 'title' => $this->formatEnumMonthEnd(''));
 		}

 		$result[] = array('code' => '1', 'title' => $this->formatEnumMonthEnd('1'));
 		$result[] = array('code' => '2', 'title' => $this->formatEnumMonthEnd('2'));
 		$result[] = array('code' => '3', 'title' => $this->formatEnumMonthEnd('3'));
 		$result[] = array('code' => '4', 'title' => $this->formatEnumMonthEnd('4'));
 		$result[] = array('code' => '5', 'title' => $this->formatEnumMonthEnd('5'));
 		$result[] = array('code' => '6', 'title' => $this->formatEnumMonthEnd('6'));
 		$result[] = array('code' => '7', 'title' => $this->formatEnumMonthEnd('7'));
 		$result[] = array('code' => '8', 'title' => $this->formatEnumMonthEnd('8'));
 		$result[] = array('code' => '9', 'title' => $this->formatEnumMonthEnd('9'));
 		$result[] = array('code' => '10', 'title' => $this->formatEnumMonthEnd('10'));
 		$result[] = array('code' => '11', 'title' => $this->formatEnumMonthEnd('11'));
 		$result[] = array('code' => '12', 'title' => $this->formatEnumMonthEnd('12'));

 		if ($is4Filter) {
 			$newResult = array();
 			foreach ($result as $r) {
 				$newResult[$r['code']] = $r['title'];
 			}
 			return $newResult;
 		}

 		return $result;
 	}

 	public function formatEnumMonthEnd($code)
 	{
 		switch ($code) {
			case '1': {return Yii::t('app', 'Jan'); break;}

			case '2': {return Yii::t('app', 'Feb'); break;}

			case '3': {return Yii::t('app', 'Mar'); break;}

			case '4': {return Yii::t('app', 'Apr'); break;}

			case '5': {return Yii::t('app', 'May'); break;}

			case '6': {return Yii::t('app', 'Jun'); break;}

			case '7': {return Yii::t('app', 'Jul'); break;}

			case '8': {return Yii::t('app', 'Aug'); break;}

			case '9': {return Yii::t('app', 'Sep'); break;}

			case '10': {return Yii::t('app', 'Oct'); break;}

			case '11': {return Yii::t('app', 'Nov'); break;}

			case '12': {return Yii::t('app', 'Dec'); break;}
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

 	/**
 	* These are function for spatial usage
 	*/
 	public function fixSpatial()
 	{
 		$record = $this;
 		$criteria = new CDbCriteria();
 		$lineString = '';

 		$alias = $record->getTableAlias();

 		foreach ($this->spatialFields as $field) {
 			$asField = (($alias && $alias != 't') ? $alias . '_' . $field : $field);
 			$field = ($alias ? ('`' . $alias . '`.') : '') . '`' . $field . '`';
 			$lineString .= 'AsText(' . $field . ') AS ' . $asField . ',';
 		}
 		$lineString = substr($lineString, 0, -1);
 		$criteria->select = (($record->DBCriteria->select == '*') ? '*, ' : '') . $lineString;
 		$criteria->addSearchCondition('id', $record->id);
 		$record->dbCriteria->mergeWith($criteria);

 		$obj = $record->find($criteria);
 		foreach ($this->spatialFields as $field) {
 			$this->$field = $obj->$field;
 		}
 	}

 	public function setLatLongAddress($pos)
 	{
 		if (!empty($pos)) {
 			if (is_array($pos)) {
 				$this->latlong_address = $pos;
 			} else {
 				$this->latlong_address = self::latLngString2Flat($pos);
 			}
 		}
 	}
 }
