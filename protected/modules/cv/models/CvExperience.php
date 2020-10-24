<?php

class CvExperience extends CvExperienceBase
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

	public function resetAddressParts()
	{
		if (!empty($this->full_address)) {
			$addressParts = HubGeo::geocoder2AddressParts(HubGeo::address2Geocoder($this->full_address));
			/*$this->address_line1 = $addressParts['line1'];
			$this->address_line2 = $addressParts['line2'];
			$this->address_zip = $addressParts['zipcode'];
			if (!empty($addressParts['city'])) {
				$this->address_city = $addressParts['city'];
			}
			*/
			if (!empty($addressParts['countryCode'])) {
				$this->country_code = $addressParts['countryCode'];
			}
			if (!empty($addressParts['state'])) {
				$state = State::findByTitle($addressParts['state'], $this->country_code);
				if (!empty($state)) {
					$this->state_code = $state->code;
				}
			}
			$this->setLatLongAddress(array($addressParts['lat'], $addressParts['lng']));
		}
	}

	public function getFaIcon()
	{
		if ($this->genre == 'job') {
			return 'fa-briefcase';
		}
		if ($this->genre == 'study') {
			return 'fa-graduation-cap';
		}
		if ($this->genre == 'project') {
			return 'fa-folder';
		}
	}
}
