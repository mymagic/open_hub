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

class Charge extends ChargeBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'transaction' => array(self::BELONGS_TO, 'Transaction', array('code' => 'ref_id'), 'condition' => 'transaction.ref_type="charge" '),
			'transactions' => array(self::HAS_MANY, 'Transaction', array('ref_id' => 'code'), 'condition' => 'transactions.ref_type="charge" '),
			'organization' => array(self::HAS_ONE, 'Organization', array('code' => 'charge_to_code'), ),
		);
	}

	public function canUpdateByAdmin()
	{
		if ($this->status == 'pending' || $this->status == 'new') {
			return true;
		}

		return false;
	}

	public function canMakePayment()
	{
		// expired
		if (HUB::now() > $this->date_expired) {
			return false;
		}
		// havent started
		if (HUB::now() < $this->date_started) {
			return false;
		}
		if ($this->status == 'pending') {
			return true;
		}

		return false;
	}

	public function code2id($code)
	{
		$obj = Charge::model()->find('t.code=:code', array(':code' => $code));
		if (!empty($obj)) {
			return $obj->id;
		}
	}

	public static function code2obj($code)
	{
		$obj = Charge::model()->find('t.code=:code', array(':code' => $code));
		if (!empty($obj)) {
			return $obj;
		}
	}

	public function isUniqueCode($code)
	{
		$obj = Charge::model()->find('t.code=:code', array(':code' => $code));
		if (!empty($obj) && !empty($obj->code)) {
			return false;
		}

		return true;
	}

	public function codeIsUnique($attribute, $params)
	{
		if (!Charge::isUniqueCode($this->$attribute)) {
			$this->addError($attribute, Yii::t('app', 'This code has already been taken.'));
		}
	}

	// 'new','pending','paid','cancel','expired'
	public function renderStatusMode()
	{
		if ($this->status == 'paid') {
			return 'primary';
		}
		if ($this->status == 'cancel') {
			return 'danger';
		}
		if ($this->status == 'expired') {
			return 'danger';
		}

		return 'default';
	}

	public function renderChargeTo($mode = 'text')
	{
		if ($this->charge_to == 'email') {
			return sprintf('%s', $this->charge_to_code);
		}
		if ($this->charge_to == 'organization') {
			if ($mode == 'html') {
				return sprintf('<a href="%s">%s</a>', Yii::app()->createUrl('//organization/view', array('id' => $this->organization->id)), $this->organization->title);
			} else {
				return sprintf('%s', $this->organization->title);
			}
		}
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('amount', $this->amount, true);
		$criteria->compare('currency_code', $this->currency_code, true);
		$criteria->compare('text_description', $this->text_description, true);
		if (!empty($this->sdate_started) && !empty($this->edate_started)) {
			$sTimestamp = strtotime($this->sdate_started);
			$eTimestamp = strtotime("{$this->edate_started} +1 day");
			$criteria->addCondition(sprintf('date_started >= %s AND date_started < %s', $sTimestamp, $eTimestamp));
		}
		if (!empty($this->sdate_expired) && !empty($this->edate_expired)) {
			$sTimestamp = strtotime($this->sdate_expired);
			$eTimestamp = strtotime("{$this->edate_expired} +1 day");
			$criteria->addCondition(sprintf('date_expired >= %s AND date_expired < %s', $sTimestamp, $eTimestamp));
		}
		$criteria->compare('status', $this->status);
		$criteria->compare('is_active', $this->is_active);
		$criteria->compare('charge_to', $this->charge_to);
		$criteria->compare('charge_to_code', $this->charge_to_code, true);
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
			'sort' => array(
				'defaultOrder' => 't.id DESC',
			),
		));
	}
}
