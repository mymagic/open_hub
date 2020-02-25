<?php


/**
 * This is the model class for table "interest".
 *
 * The followings are the available columns in table 'interest':
 * @property integer $id
 * @property integer $user_id
 * @property string $json_extra
 * @property integer $is_active
 * @property integer $date_added
 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property User $user
 * @property InterestUser2cluster[] $interestUser2clusters
 * @property InterestUser2industry[] $interestUser2industries
 * @property InterestUser2sdg[] $interestUser2sdgs
 * @property InterestUser2startupStage[] $interestUser2startupStages
 */
class InterestBase extends ActiveRecordBase
{
	public $uploadPath;

	// m2m
	public $inputIndustries;
	public $inputSdgs;
	public $inputClusters;
	public $inputStartupStages;

	public $sdate_added;
	public $edate_added;
	public $sdate_modified;
	public $edate_modified;

	// json
	public $jsonArray_extra;

	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . $this->tableName();

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
		return 'interest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('inputIndustries, inputSdgs, inputClusters, inputStartupStages', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, json_extra, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
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
			'clusters' => array(self::MANY_MANY, 'Cluster', 'interest_user2cluster(cluster_id, interest_id)'),
			'industries' => array(self::MANY_MANY, 'Industry', 'interest_user2industry(industry_id, interest_id)'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'sdgs' => array(self::MANY_MANY, 'Sdg', 'interest_user2sdg(sdg_id, interest_id)'),
			'startupStages' => array(self::MANY_MANY, 'StartupStage', 'interest_user2startup_stage(startup_stage_id, interest_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
			'id' => Yii::t('app', 'ID'),
			'user_id' => Yii::t('app', 'User'),
			'json_extra' => Yii::t('app', 'Json Extra'),
			'is_active' => Yii::t('app', 'Is Active'),
			'date_added' => Yii::t('app', 'Date Added'),
			'date_modified' => Yii::t('app', 'Date Modified'),
		);

		$return['inputIndustries'] = Yii::t('app', 'Industries');
		$return['inputSdgs'] = Yii::t('app', 'Sdgs');
		$return['inputClusters'] = Yii::t('app', 'Clusters');
		$return['inputStartupStages'] = Yii::t('app', 'Startup Stages');

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
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('json_extra', $this->json_extra, true);
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

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
	}

	public function toApi($params = '')
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'userId' => $this->user_id,
			'jsonExtra' => $this->json_extra,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

		// many2many
		if (!in_array('-industries', $params) && !empty($this->industries)) {
			foreach ($this->industries as $industry) {
				$return['industries'][] = $industry->toApi(array('-interest'));
			}
		}
		if (!in_array('-sdgs', $params) && !empty($this->sdgs)) {
			foreach ($this->sdgs as $sdg) {
				$return['sdgs'][] = $sdg->toApi(array('-interest'));
			}
		}
		if (!in_array('-clusters', $params) && !empty($this->clusters)) {
			foreach ($this->clusters as $cluster) {
				$return['clusters'][] = $cluster->toApi(array('-interest'));
			}
		}
		if (!in_array('-startupStages', $params) && !empty($this->startupStages)) {
			foreach ($this->startupStages as $startupStage) {
				$return['startupStages'][] = $startupStage->toApi(array('-interest'));
			}
		}

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
	 * @return Interest the static model class
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
		$this->saveInputIndustry();
		$this->saveInputSdg();
		$this->saveInputCluster();
		$this->saveInputStartupStage();

		return parent::afterSave();
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

			// json
			$this->json_extra = json_encode($this->jsonArray_extra);
			if ($this->json_extra == 'null') {
				$this->json_extra = null;
			}

			// save as null if empty
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

		foreach ($this->industries as $industry) {
			$this->inputIndustries[] = $industry->id;
		}
		foreach ($this->sdgs as $sdg) {
			$this->inputSdgs[] = $sdg->id;
		}
		foreach ($this->clusters as $cluster) {
			$this->inputClusters[] = $cluster->id;
		}
		foreach ($this->startupStages as $startupStage) {
			$this->inputStartupStages[] = $startupStage->id;
		}

		parent::afterFind();
	}

	/**
	 * These are function for spatial usage
	 */
	public function fixSpatial()
	{
	}

	//
	// industry
	public function getAllIndustriesKey()
	{
		$return = array();
		if (!empty($this->industries)) {
			foreach ($this->industries as $r) {
				$return[] = $r->id;
			}
		}

		return $return;
	}

	public function hasIndustry($key)
	{
		if (in_array($key, $this->getAllIndustriesKey())) {
			return true;
		}

		return false;
	}

	public function hasNoIndustry($key)
	{
		if (!in_array($key, $this->getAllIndustriesKey())) {
			return true;
		}

		return false;
	}

	public function removeIndustry($key)
	{
		if ($this->hasIndustry($key)) {
			$many2many = InterestUser2industry::model()->findByAttributes(array('interest_id' => $this->id, 'industry_id' => $key));
			if (!empty($many2many)) {
				return InterestUser2industry::model()->deleteAllByAttributes(array('interest_id' => $this->id, 'industry_id' => $key));
			}
		}

		return false;
	}

	public function addIndustry($key)
	{
		if ($this->hasNoIndustry($key)) {
			$many2many = new InterestUser2industry;
			$many2many->interest_id = $this->id;
			$many2many->industry_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputIndustry()
	{
		// loop thru existing
		foreach ($this->industries as $r) {
			// remove extra
			if (!in_array($r->id, $this->inputIndustries)) {
				$this->removeIndustry($r->id);
			}
		}

		// loop thru each input
		foreach ($this->inputIndustries as $input) {
			// if currently dont have
			if ($this->hasNoIndustry($input)) {
				$this->addIndustry($input);
			}
		}
	}

	//
	// sdg
	public function getAllSdgsKey()
	{
		$return = array();
		if (!empty($this->sdgs)) {
			foreach ($this->sdgs as $r) {
				$return[] = $r->id;
			}
		}

		return $return;
	}

	public function hasSdg($key)
	{
		if (in_array($key, $this->getAllSdgsKey())) {
			return true;
		}

		return false;
	}

	public function hasNoSdg($key)
	{
		if (!in_array($key, $this->getAllSdgsKey())) {
			return true;
		}

		return false;
	}

	public function removeSdg($key)
	{
		if ($this->hasSdg($key)) {
			$many2many = InterestUser2sdg::model()->findByAttributes(array('interest_id' => $this->id, 'sdg_id' => $key));
			if (!empty($many2many)) {
				return InterestUser2sdg::model()->deleteAllByAttributes(array('interest_id' => $this->id, 'sdg_id' => $key));
			}
		}

		return false;
	}

	public function addSdg($key)
	{
		if ($this->hasNoSdg($key)) {
			$many2many = new InterestUser2sdg;
			$many2many->interest_id = $this->id;
			$many2many->sdg_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputSdg()
	{
		// loop thru existing
		foreach ($this->sdgs as $r) {
			// remove extra
			if (!in_array($r->id, $this->inputSdgs)) {
				$this->removeSdg($r->id);
			}
		}

		// loop thru each input
		foreach ($this->inputSdgs as $input) {
			// if currently dont have
			if ($this->hasNoSdg($input)) {
				$this->addSdg($input);
			}
		}
	}

	//
	// cluster
	public function getAllClustersKey()
	{
		$return = array();
		if (!empty($this->clusters)) {
			foreach ($this->clusters as $r) {
				$return[] = $r->id;
			}
		}

		return $return;
	}

	public function hasCluster($key)
	{
		if (in_array($key, $this->getAllClustersKey())) {
			return true;
		}

		return false;
	}

	public function hasNoCluster($key)
	{
		if (!in_array($key, $this->getAllClustersKey())) {
			return true;
		}

		return false;
	}

	public function removeCluster($key)
	{
		if ($this->hasCluster($key)) {
			$many2many = InterestUser2cluster::model()->findByAttributes(array('interest_id' => $this->id, 'cluster_id' => $key));
			if (!empty($many2many)) {
				return InterestUser2cluster::model()->deleteAllByAttributes(array('interest_id' => $this->id, 'cluster_id' => $key));
			}
		}

		return false;
	}

	public function addCluster($key)
	{
		if ($this->hasNoCluster($key)) {
			$many2many = new InterestUser2cluster;
			$many2many->interest_id = $this->id;
			$many2many->cluster_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputCluster()
	{
		// loop thru existing
		foreach ($this->clusters as $r) {
			// remove extra
			if (!in_array($r->id, $this->inputClusters)) {
				$this->removeCluster($r->id);
			}
		}

		// loop thru each input
		foreach ($this->inputClusters as $input) {
			// if currently dont have
			if ($this->hasNoCluster($input)) {
				$this->addCluster($input);
			}
		}
	}

	//
	// startupStage
	public function getAllStartupStagesKey()
	{
		$return = array();
		if (!empty($this->startupStages)) {
			foreach ($this->startupStages as $r) {
				$return[] = $r->id;
			}
		}

		return $return;
	}

	public function hasStartupStage($key)
	{
		if (in_array($key, $this->getAllStartupStagesKey())) {
			return true;
		}

		return false;
	}

	public function hasNoStartupStage($key)
	{
		if (!in_array($key, $this->getAllStartupStagesKey())) {
			return true;
		}

		return false;
	}

	public function removeStartupStage($key)
	{
		if ($this->hasStartupStage($key)) {
			$many2many = InterestUser2startupStage::model()->findByAttributes(array('interest_id' => $this->id, 'startup_stage_id' => $key));
			if (!empty($many2many)) {
				return InterestUser2startupStage::model()->deleteAllByAttributes(array('interest_id' => $this->id, 'startup_stage_id' => $key));
			}
		}

		return false;
	}

	public function addStartupStage($key)
	{
		if ($this->hasNoStartupStage($key)) {
			$many2many = new InterestUser2startupStage;
			$many2many->interest_id = $this->id;
			$many2many->startup_stage_id = $key;

			return $many2many->save();
		}

		return false;
	}

	protected function saveInputStartupStage()
	{
		// loop thru existing
		foreach ($this->startupStages as $r) {
			// remove extra
			if (!in_array($r->id, $this->inputStartupStages)) {
				$this->removeStartupStage($r->id);
			}
		}

		// loop thru each input
		foreach ($this->inputStartupStages as $input) {
			// if currently dont have
			if ($this->hasNoStartupStage($input)) {
				$this->addStartupStage($input);
			}
		}
	}

	public function behaviors()
	{
		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['Interest'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['Interest'];
				$return[$moduleKey]['model'] = $this;
			}
		}

		return $return;
	}
}
