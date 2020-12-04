<?php

class EventbriteOrganizationWebhook extends EventbriteOrganizationWebhookBase
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
		$this->organization_id = $this->organization->id;

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
		$return['as_role_code'] = Yii::t('app', 'As Role (coded)');

		return $return;
	}

	public function toApi($params = '')
	{
		$this->fixSpatial();

		$return = array(
			'id' => $this->id,
			'organizationCode' => $this->organization_code,
			'organizationId' => $this->organization_id,
			'asRoleCode' => $this->as_role_code,
			'eventbriteAccountId' => $this->eventbrite_account_id,
			'eventbriteOauthSecret' => $this->eventbrite_oauth_secret,
			'jsonExtra' => $this->json_extra,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);

		// many2many

		return $return;
	}
}
