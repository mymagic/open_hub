<?php

class Transaction extends TransactionBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'charge' => array(self::HAS_ONE, 'Charge', array('code'=>'ref_id'), 'with'=>array('transaction')),
		);
	}
	
	public function scopes()
    {
		return array
		(
			'charge'=>array('condition'=>"t.ref_type = 'charge'"),
		);
    }
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vendor',$this->vendor,true);
		$criteria->compare('txnid',$this->txnid,true);
		$criteria->compare('txntype',$this->txntype,true);
		$criteria->compare('txntype_code',$this->txntype_code,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('ref_id',$this->ref_id,true);
		$criteria->compare('ref_type',$this->ref_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('is_valid',$this->is_valid);
		$criteria->compare('json_extra',$this->json_extra,true);
		$criteria->compare('json_payload',$this->json_payload,true);
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
			'sort'=>array('defaultOrder'=>'t.id DESC',)
		));
	}
	
	public function toApi($params='')
	{
		$return = array(
			'id'=>$this->id,
			'vendor'=>$this->vendor,
			'txnid'=>$this->txnid,
			'txntype'=>$this->txntype,
			'txntypeCode'=>$this->txntype_code,
			'currencyCode'=>$this->currency_code,
			'amount'=>$this->amount,
			'refId'=>$this->ref_id,
			'refType'=>$this->ref_type,
			'status'=>$this->status,
			'isValid'=>boolval($this->is_valid),
			'dateAdded'=>$this->date_added,
			'dateModified'=>$this->date_modified,
			'currency'=>$this->jsonArray_payload->currency,
			
			'fDateAdded'=>$this->renderDateAdded(),
			'fDateModified'=>$this->renderDateModified(),
			
			'fGetOneLinerDetail'=>$this->getOneLinerDetail(),
			'fGetStatus'=>$this->getStatus(),
			'fGetAmount4Display'=>$this->getAmount4Display(),
		);
		return $return;
	}
	
	public function getObjByTxn($vendor, $txnId)
	{
		return Transaction::model()->find('t.vendor=:vendor AND t.txnid=:txnId', array(':vendor'=>$vendor, ':txnId'=>$txnId));
	}
	
	public function canRefund()
	{
		if($this->status == 'Approved' && $this->vendor == 'securePay') return true;
		return false;
	}
	
	public function getRefViewUrl($context='backend')
	{
		if(!empty($this->ref_id) && !empty($this->ref_type))
		{
			switch($this->ref_type)
			{
				case 'orderzRound':
				{
					return Yii::app()->createUrl('orderz/viewByAdmin', array('code'=>RDS::getOrderzCodeFromOrderzRoundCode($this->ref_id)));
					break;
				}
			}
		}
		return '';
	}
	
	public function getOneLinerDetail()
	{
		if($this->vendor == 'securePay')
		{
			if($this->txntype == 'Receipt') return sprintf('%s %s', $this->jsonArray_payload->cardtype, $this->jsonArray_payload->pan);
			if($this->txntype == 'Refund') return sprintf('%s %s (%s)', $this->jsonArray_payload->CreditCardInfo->cardDescription, $this->jsonArray_payload->CreditCardInfo->pan, Yii::t('app', 'Refund'));
		}
		// todo: paypal
	}
	
	public function getStatus()
	{
		if($this->vendor == 'securePay' && $this->txntype == 'Receipt') return $this->status;
		return $this->status;
	}
	
	
	public function isSuccess()
	{
		return !$this->isFail();
	}
	
	public function isFail()
	{
		if($this->vendor == 'securePay')
		{	
			$arraySuccess = array('00', '08', '11');
			if($this->txntype == 'Receipt')
				if(in_array($this->jsonArray_payload->rescode, $arraySuccess)) return false;
			if($this->txntype == 'Refund')
				if(in_array($this->jsonArray_payload->responseCode, $arraySuccess)) return false;
			
		}
		else if($this->vendor == 'paypal'){
			if($this->status == 'Completed') return false;
		}
		return true;
	}
	
	// after check with checksum
	public function isValid()
	{
		return $this->is_valid;
	}
	
	public function getAmount4Display()
	{
		$currencyCode = (!empty($this->jsonArray_payload) && !empty($this->jsonArray_payload->currency))?$this->jsonArray_payload->currency:'';
		return Html::formatMoney($this->amount, $currencyCode);
	}
	
	public function renderDateAdded()
	{
		return Html::formatDateTimezone($this->date_added, 'long', 'short', '-');
	}
	public function renderDateModified()
	{
		return Html::formatDateTimezone($this->date_modified, 'long', 'short', '-');
	}
}
