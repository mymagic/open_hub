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

class EventOrganization extends EventOrganizationBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

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
		if(empty($this->event_id) && !empty($this->event_code))
		{
			$event = Event::model()->findByAttributes(array('code'=>$this->event_code));
			if(!empty($event)) $this->event_id = $event->id;
		}
		else if(!empty($this->event_id) && empty($this->event_code))
		{
			$event = Event::model()->findByPk($this->event_id);
			if(!empty($event)) $this->event_code = $event->code;
		}

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
		$return['event_vendor_code'] = Yii::t('app', 'Source (coded)');
		$return['as_role_code'] = Yii::t('app', 'As Role (coded)');

		return $return;
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			
			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on'=>sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on'=>'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through'=>'metaStructures'),
		);
	}

	public function renderAsRoleCode($value='')
	{
		if(!empty($value)) $asRoleCode = $value;
		else $asRoleCode = $this->as_role_code;

		preg_match_all('/((?:^|[A-Z])[a-z]+)/', $asRoleCode, $matches);
		return ucwords(implode(' ', $matches[0]));
	}

	public function toApi($params=array())
	{
		$this->fixSpatial();
		
		$return = array(
			'id' => $this->id,
			'eventCode' => $this->event_code,
			'eventId' => $this->event_id,
			'eventVendorCode' => $this->event_vendor_code,
			'registrationCode' => $this->registration_code,
			'organizationId' => $this->organization_id,
			'organizationName' => $this->organization_name,
			'asRoleCode' => $this->as_role_code,
			'dateAction' => $this->date_action,
			'fDateAction'=>$this->renderDateAction(),
			'dateAdded' => $this->date_added,
			'fDateAdded'=>$this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified'=>$this->renderDateModified(),
		
		);
		
		if(!in_array('-event', $params) && !empty($this->event)) 
		{
			$return['event'] = $this->event->toApi(array('-eventOrganizations', $params['config']));
		}

		// many2many

		return $return;
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		//$criteria->compare('event_code',$this->event_code,true);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('event_vendor_code',$this->event_vendor_code,true);
		$criteria->compare('registration_code',$this->registration_code,true);
		$criteria->compare('organization_id',$this->organization_id);
		$criteria->compare('organization_name',$this->organization_name,true);
		$criteria->compare('as_role_code',$this->as_role_code,true);
		if(!empty($this->sdate_action) && !empty($this->edate_action))
		{
			$sTimestamp = strtotime($this->sdate_action);
			$eTimestamp = strtotime("{$this->edate_action} +1 day");
			$criteria->addCondition(sprintf('date_action >= %s AND date_action < %s', $sTimestamp, $eTimestamp));
		}
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
			'sort' => array('defaultOrder' => 't.id DESC'),
		));
	}
}
