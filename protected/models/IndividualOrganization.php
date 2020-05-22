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

class IndividualOrganization extends IndividualOrganizationBase
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
			'individual' => array(self::BELONGS_TO, 'Individual', 'individual_id'),
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_code'),

			// meta
			'metaStructures' => array(self::HAS_MANY, 'MetaStructure', '', 'on' => sprintf('metaStructures.ref_table=\'%s\'', $this->tableName())),
			'metaItems' => array(self::HAS_MANY, 'MetaItem', '', 'on' => 'metaItems.ref_id=t.id AND metaItems.meta_structure_id=metaStructures.id', 'through' => 'metaStructures'),
		);
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

		$return['organization_code'] = Yii::t('app', 'Organization');

		return $return;
	}

	public function toApi($params = '')
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'individualId' => $this->individual_id,
			'organizationCode' => $this->organization_code,
			'asRoleCode' => $this->as_role_code,
			'jobPosition' => $this->job_position,
			'dateStarted' => $this->date_started,
			'fDateStarted' => $this->renderDateStarted(),
			'dateEnded' => $this->date_ended,
			'fDateEnded' => $this->renderDateEnded(),
			'jsonExtra' => $this->json_extra,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

		if (!in_array('-individual', $params) && !empty($this->individual)) {
			$return['individual'] = $this->individual->toApi(array('', $params['config']));
		}
		if (!in_array('-organization', $params) && !empty($this->organization)) {
			$return['organization'] = $this->organization->toApi(array('-individualOrganizations', $params['config']));
		}

		// many2many

		return $return;
	}

	public function behaviors()
	{
		$return = array();

		foreach (Yii::app()->modules as $moduleKey => $moduleParams) {
			if (isset($moduleParams['modelBehaviors']) && !empty($moduleParams['modelBehaviors']['IndividualOrganization'])) {
				$return[$moduleKey] = Yii::app()->getModule($moduleKey)->modelBehaviors['IndividualOrganization'];
				$return[$moduleKey]['model'] = $this;
			}
		}

		return $return;
	}
}
