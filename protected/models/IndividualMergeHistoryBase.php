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
 * This is the model class for table "individual_merge_history".
 *
 * The followings are the available columns in table 'individual_merge_history':
			 * @property integer $id
			 * @property integer $src_individual_id
			 * @property integer $dest_individual_id
			 * @property string $dest_individual_title
			 * @property integer $admin_code
			 * @property integer $date_action
			 * @property integer $date_added
			 * @property integer $date_modified
 *
 * The followings are the available model relations:
 * @property Individual $srcIndividual
 * @property Individual $destIndividual
 * @property User $user
 */
 class IndividualMergeHistoryBase extends ActiveRecordBase
{	
	public $sdate_action, $edate_action;
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;
	
	public function init()
	{
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'individual_merge_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('src_individual_id, dest_individual_id, dest_individual_title', 'required'),
			array('date_action, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, src_individual_id, dest_individual_id, dest_individual_title, sdate_action, edate_action, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
			'srcIndividual' => array(self::BELONGS_TO, 'Individual', 'src_individual_id'),
			'destIndividual' => array(self::BELONGS_TO, 'Individual', 'dest_individual_id'),
            'user' => array(self::BELONGS_TO, 'User', 'admin_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$return = array(
		'id' => Yii::t('app', 'ID'),
		'src_individual_id' => Yii::t('app', 'Source Individual'), 
		'dest_individual_id' => Yii::t('app', 'Destination Individual'), 
		'dest_individual_title' => Yii::t('app', 'Destination Individual Title'), 
		'admin_code' => Yii::t('app', 'Admin'),
		'date_action' => Yii::t('app', 'Date Action'),
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
		$criteria->compare('src_individual_id',$this->src_individual_id);
		$criteria->compare('dest_individual_id',$this->dest_individual_id);
		$criteria->compare('dest_individual_title',$this->dest_individual_title);
		$criteria->compare('admin_code',$this->admin_code);
		if(!empty($this->sdate_action) && !empty($this->edate_action)) {
			$sTimestamp = strtotime($this->sdate_action);
			$eTimestamp = strtotime("{$this->edate_action} +1 day");
			$criteria->addCondition(sprintf('date_action >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp));
		}
		if(!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,

		));
	}

	public function toApi($params='')
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'sourceIndividual' => $this->src_individual_id, 
			'destinationIndividual' => $this->dest_individual_id, 
			'destinationIndividualTitle' => $this->dest_individual_title, 
			'adminCode' => $this->admin_code,
			'dateAction' => $this->date_action,
			'fDateAction' => $this->renderDateAction(),
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

	public function renderDateAction()
	{
		return Html::formatDateTimezone($this->date_action, 'standard', 'standard', '-', $this->getTimezone());
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
		return array();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrganizationRevenue the static model class
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

			// auto deal with date added and date modified
			if($this->isNewRecord) {
				$this->date_added = $this->date_modified = time();
			} else {
				$this->date_modified = time();
			}

			$this->admin_code = Yii::app()->user->id;
			$this->date_action = time();

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
		return array();
	}


	/**
	* These are function for spatial usage
	*/
	public function fixSpatial()
	{
	}


}
