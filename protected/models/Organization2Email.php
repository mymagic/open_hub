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

class Organization2Email extends Organization2EmailBase
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
			'organization' => array(self::BELONGS_TO, 'Organization', 'organization_id'),
			'user' => array(self::HAS_ONE, 'User', array('username' => 'user_email')),
		);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('organization_id', 'required'),
			array('organization_id, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('user_email', 'length', 'max' => 128),
			array('user_email', 'email', 'allowEmpty' => false, 'checkMX' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, organization_id, user_email, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),
		);
	}

	public function getNextToggleStatusClass()
	{
		switch ($this->status) {
			case 'approve': return 'danger'; break;
			case 'reject': return 'primary'; break;
			case 'pending': return 'primary'; break;
		}
	}

	public function getNextToggleStatus()
	{
		switch ($this->status) {
			case 'approve': return 'reject'; break;
			case 'reject': return 'approve'; break;
			case 'pending': return 'approve'; break;
		}
	}

	// od, organization_id, user_email, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified
	public function toApi($params = '')
	{
		$return = array(
			'id' => $this->id,
			'organizationId' => $this->organization_id,
			'userEmail' => $this->user_email,
			'status' => $this->status,
			'fStatus' => $this->renderStatus(),
			'dateAdded' => $this->date_added,
			'fDateAdded' => $this->renderDateAdded(),
			'dateModified' => $this->date_modified,
			'fDateModified' => $this->renderDateModified(),
		);
		if (!in_array('-organization', $params) && !empty($this->organization)) {
			$return['organization'] = $this->organization->toApi();
		}
		if (!in_array('-user', $params) && !empty($this->user)) {
			$return['user'] = $this->user->toApi();
		}

		return $return;
	}

	public function renderDateAdded()
	{
		return Html::formatDateTimezone($this->date_added, 'standard', 'standard', '-', $this->getTimezone());
	}

	public function renderDateModified()
	{
		return Html::formatDateTimezone($this->date_modified, 'standard', 'standard', '-', $this->getTimezone());
	}

	public function getTimezone()
	{
		return date_default_timezone_get();
	}

	public function renderStatus()
	{
		return $this->formatEnumStatus($this->status);
	}
}
