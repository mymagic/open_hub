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
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
			 * @property integer $id
			 * @property string $vendor
			 * @property string $txnid
			 * @property string $txntype
			 * @property string $txntype_code
			 * @property string $currency_code
			 * @property string $amount
			 * @property string $ref_id
			 * @property string $ref_type
			 * @property string $status
			 * @property string $json_extra
			 * @property string $json_payload
			 * @property integer $is_valid
			 * @property integer $date_added
			 * @property integer $date_modified
 */
 class TransactionBase extends ActiveRecordBase
{
	public $uploadPath;
	
	public $sdate_added, $edate_added;
	public $sdate_modified, $edate_modified;

	// json
	public $jsonArray_extra;
	public $jsonArray_payload;
	
	public function init()
	{
		$this->uploadPath = Yii::getPathOfAlias('uploads').DIRECTORY_SEPARATOR.'transaction';

		if($this->scenario == "search")
		{
			$this->is_valid = null;
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
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('txnid, txntype, currency_code, amount, ref_id, ref_type, status', 'required'),
			array('is_valid, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('vendor, ref_id, status', 'length', 'max'=>64),
			array('txnid, txntype, ref_type', 'length', 'max'=>32),
			array('txntype_code', 'length', 'max'=>6),
			array('currency_code', 'length', 'max'=>3),
			array('amount', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor, txnid, txntype, txntype_code, currency_code, amount, ref_id, ref_type, status, json_extra, json_payload, is_valid, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
		'vendor' => Yii::t('app', 'Vendor'),
		'txnid' => Yii::t('app', 'Txnid'),
		'txntype' => Yii::t('app', 'Txntype'),
		'txntype_code' => Yii::t('app', 'Txntype Code'),
		'currency_code' => Yii::t('app', 'Currency Code'),
		'amount' => Yii::t('app', 'Amount'),
		'ref_id' => Yii::t('app', 'Ref'),
		'ref_type' => Yii::t('app', 'Ref Type'),
		'status' => Yii::t('app', 'Status'),
		'json_extra' => Yii::t('app', 'Json Extra'),
		'json_payload' => Yii::t('app', 'Json Payload'),
		'is_valid' => Yii::t('app', 'Is Valid'),
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
		$criteria->compare('vendor',$this->vendor,true);
		$criteria->compare('txnid',$this->txnid,true);
		$criteria->compare('txntype',$this->txntype,true);
		$criteria->compare('txntype_code',$this->txntype_code,true);
		$criteria->compare('currency_code',$this->currency_code,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('ref_id',$this->ref_id,true);
		$criteria->compare('ref_type',$this->ref_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('json_extra',$this->json_extra,true);
		$criteria->compare('json_payload',$this->json_payload,true);
		$criteria->compare('is_valid',$this->is_valid);
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
			'isValid' => array('condition'=>'t.is_valid = 1'),

		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Transaction the static model class
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


		return parent::beforeValidate();
	}

	
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->txntype_code == '') $this->txntype_code = NULL;

			// auto deal with date added and date modified
			if($this->isNewRecord)
			{
				$this->date_added=$this->date_modified=time();
			}
			else
			{
				$this->date_modified=time();
			}
	

			// json
			$this->json_extra = json_encode($this->jsonArray_extra);
			if($this->json_extra == 'null') $this->json_extra = null;
			$this->json_payload = json_encode($this->jsonArray_payload);
			if($this->json_payload == 'null') $this->json_payload = null;

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
	
		$this->jsonArray_extra = json_decode($this->json_extra);
		$this->jsonArray_payload = json_decode($this->json_payload);


		parent::afterFind();
	}

	function behaviors() 
	{
		return array
		(
		);
	}
	



}
