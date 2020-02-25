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

class EventRegistration extends EventRegistrationBase
{
	public $searchEvent;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function init()
	{
		// custom code here
		// ...

		parent::init();

		// return void
	}

	public function beforeValidate()
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate()
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...

		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		// custom code here
		// ...

		parent::afterFind();

		// return void
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			// loosely coupled, no foreign relationship enforced on db since registration data sync from bizzabo or legacy system can refer to event that not in record
			'event' => [self::HAS_ONE, 'Event', ['code' => 'event_code']],

			// meta
			'metaStructures' => [self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())],
			'metaItems' => [self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'],
		];
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes();

		$this->full_name = $keyword;
		$this->email = $keyword;
		$this->phone = $keyword;
		$this->organization = $keyword;
		$this->searchEvent = $keyword;

		$tmp = $this->search(['compareOperator' => 'OR']);
		$tmp->sort->defaultOrder = 't.id DESC';

		return $tmp;
	}

	public function search($params = null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if (empty($params['compareOperator'])) {
			$params['compareOperator'] = 'AND';
		}

		$criteria = new CDbCriteria;
		$criteria->together = true;

		$criteria->compare('id', $this->id, false, $params['compareOperator']);
		$criteria->compare('event_code', $this->event_code, true, $params['compareOperator']);
		$criteria->compare('event_id', $this->event_id, false, $params['compareOperator']);
		$criteria->compare('event_vendor_code', $this->event_vendor_code, true, $params['compareOperator']);
		$criteria->compare('registration_code', $this->registration_code, true, $params['compareOperator']);
		$criteria->compare('full_name', $this->full_name, true, $params['compareOperator']);
		$criteria->compare('first_name', $this->first_name, true, $params['compareOperator']);
		$criteria->compare('last_name', $this->last_name, true, $params['compareOperator']);
		$criteria->compare('email', $this->email, true, $params['compareOperator']);
		$criteria->compare('phone', $this->phone, true, $params['compareOperator']);
		$criteria->compare('organization', $this->organization, true, $params['compareOperator']);
		$criteria->compare('gender', $this->gender, false, $params['compareOperator']);
		$criteria->compare('age_group', $this->age_group, true, $params['compareOperator']);
		$criteria->compare('where_found', $this->where_found, true, $params['compareOperator']);
		$criteria->compare('persona', $this->persona, true, $params['compareOperator']);
		$criteria->compare('paid_fee', $this->paid_fee, true, $params['compareOperator']);
		$criteria->compare('is_attended', $this->is_attended);
		$criteria->compare('nationality', $this->nationality, true, $params['compareOperator']);
		$criteria->compare('is_bumi', $this->is_bumi, false, $params['compareOperator']);
		if (!empty($this->sdate_registered) && !empty($this->edate_registered)) {
			$sTimestamp = strtotime($this->sdate_registered);
			$eTimestamp = strtotime("{$this->edate_registered} +1 day");
			$criteria->addCondition(sprintf('date_registered >= %s AND date_registered < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_payment) && !empty($this->edate_payment)) {
			$sTimestamp = strtotime($this->sdate_payment);
			$eTimestamp = strtotime("{$this->edate_payment} +1 day");
			$criteria->addCondition(sprintf('date_payment >= %s AND date_payment < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		$criteria->compare('json_original', $this->json_original, true);
		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('date_added >= %s AND date_added < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}
		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('date_modified >= %s AND date_modified < %s', $sTimestamp, $eTimestamp), $params['compareOperator']);
		}

		if ($this->searchEvent !== null) {
			$criteriaEvent = new CDbCriteria;
			$criteriaEvent->together = true;
			$criteriaEvent->with = ['event'];
			$criteriaEvent->addSearchCondition('title', trim($this->searchEvent), true, 'OR');
			$criteria->mergeWith($criteriaEvent, $params['compareOperator']);
		}

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
			'pagination' => ['pageSize' => 30],
			'sort' => ['defaultOrder' => 't.id DESC'],
		]);
	}

	public function toApi($params = '')
	{
		$this->fixSpatial();

		$return = [
			'id' => $this->id,
			'eventCode' => $this->event_code,
			'eventId' => $this->event_id,
			'eventVendorCode' => $this->event_vendor_code,
			'registrationCode' => $this->registration_code,
			'fullName' => $this->full_name,
			'firstName' => $this->first_name,
			'lastName' => $this->last_name,
			'email' => $this->email,
			'phone' => $this->phone,
			'organization' => $this->organization,
			'gender' => $this->gender,
			'ageGroup' => $this->age_group,
			'whereFound' => $this->where_found,
			'persona' => $this->persona,
			'paidFee' => $this->paid_fee,
			'isAttended' => $this->is_attended,
			'nationality' => $this->nationality,
			'isBumi' => $this->is_bumi,
			'dateRegistered' => $this->date_registered,
			'fDateRegistered' => $this->renderDateRegistered(),
			'datePayment' => $this->date_payment,
			'fDatePayment' => $this->renderDatePayment(),
			'jsonOriginal' => $this->json_original,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		];

		// many2many

		return $return;
	}

	public function searchRegistration()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('event_id', $this->event_id);

		return new CActiveDataProvider($this, [
			'criteria' => $criteria,
			'sort' => ['defaultOrder' => 'email ASC'],
		]);
	}

	public function behaviors()
	{
		$return = array();

		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['EventRegistration'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['EventRegistration'];
				$return[$moduleKey]['model'] = $this;
			}
		}

		return $return;
	}
}
