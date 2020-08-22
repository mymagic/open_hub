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

class Role extends RoleBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'match', 'pattern' => '/^([a-zA-Z0-9_-])+$/', 'message' => Yii::t('default', '{attribute} only accept valid character set like a-z, A-Z, 0-9, - and _')),
			array('code, title, is_access_backend, is_access_sensitive_data, is_active', 'required'),
			array('is_access_backend, is_access_sensitive_data, is_active, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('code', 'length', 'max' => 64),
			array('title', 'length', 'max' => 128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, is_access_backend, is_access_sensitive_data, is_active, date_added, date_modified', 'safe', 'on' => 'search'),
		);
	}

	public function code2id($code)
	{
		$role = Role::model()->find('t.code=:code', array(':code' => $code));
		if (!empty($role)) {
			return $role->id;
		}
	}
}
