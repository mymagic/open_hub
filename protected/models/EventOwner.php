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

class EventOwner extends EventOwnerBase
{
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
		if (empty($this->as_role_code)) {
			$this->as_role_code = 'owner';
		}

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
		$return['organization_code'] = Yii::t('app', 'Organization');
		$return['event_code'] = Yii::t('app', 'Event');
		$return['as_role_code'] = Yii::t('app', 'As Role (coded)');

		return $return;
	}

	public function renderAsRoleCode($value = '')
	{
		if (!empty($value)) {
			$asRoleCode = $value;
		} else {
			$asRoleCode = $this->as_role_code;
		}

		preg_match_all('/((?:^|[A-Z])[a-z]+)/', $asRoleCode, $matches);

		return ucwords(implode(' ', $matches[0]));
	}

	public function toApi($params = null)
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'eventCode' => $this->event_code,
			'organizationCode' => $this->organization_code,
			'department' => $this->department,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
			'asRoleCode' => $this->as_role_code,
		);
		if (!in_array('-event', $params) && !empty($this->event)) {
			$return['event'][] = $this->event->toApi();
		}
		if (!in_array('-organization', $params) && !empty($this->organization)) {
			$return['organization'][] = $this->organization->toApi();
		}

		// many2many

		return $return;
	}
}
