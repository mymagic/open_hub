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

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_ACCOUNT_BLOCKED = 10;

	private $_id;
	public $user;
	public $availableAttempts;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate($type = 'default')
	{
		$this->resetLogin();

		if ($type == 'social') {
			// password in this case is not real password, but social_identifier (provider code)
			$user = User::model()->findByAuthSocial($this->username, $this->password);
		} else {
			$user = User::model()->username2Obj($this->username);
		}
		$this->user = $user;

		// no such user
		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		// password unmatch
		elseif ($user->password !== sha1($this->password) && ($type == 'default')) {
			$user->stat_login_count++;
			$user->save(false);
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		// user is not active and date activated is already set
		elseif (!$user->is_active && !empty($user->date_activated)) {
			$user->stat_login_count++;
			$user->save(false);
			$this->errorCode = self::ERROR_ACCOUNT_BLOCKED;
		}
		// login success
		else {
			$this->_id = $user->id;
			$this->doLogin($user);
			$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}

	private function resetLogin()
	{
		$this->setState('accessBackend', false);
		$this->setState('accessSensitiveData', false);
		$this->setState('accessCpanel', false);

		$this->setState('rolesAssigned', false);

		Yii::app()->session['accessBackend'] = false;
		Yii::app()->session['accessSensitiveData'] = false;
		Yii::app()->session['accessCpanel'] = false;
	}

	private function doLogin($user)
	{
		// $rolesCanAccessBackend = Yii::app()->params['rolesCanAccessBackend'];
		$user->stat_login_count++;

		// increase stat_login_success_count
		$user->stat_login_success_count++;
		// first time login
		if ($user->stat_login_success_count == 1 && $user->is_active == 0 && empty($user->date_activated)) {
			$user->is_active = 1;
			$user->date_activated = time();
		}

		$user->date_last_login = time();
		$user->last_login_ip = Yii::app()->request->userHostAddress;
		$user->save(false);

		$this->setState('username', $user->username);

		//
		// role
		$roleLevelDisplay = '';
		$rolesAssigned = [];
		$roles = Role::model()->findAll();

		// can access backend?
		if (count($roles) > 0) {
			// loop through all role and preset them to false
			foreach ($roles as $role) {
				$this->setState('is' . ucwords($role->code), false);
			}

			// loop all roles this user has
			if (count($user->roles) > 0) {
				foreach ($user->roles as $role) {
					// $this->setState('is' . ucwords($role->code), true);
					$roleLevelDisplay .= Yii::t('default', $role->title) . ', ';

					/*
					if (in_array($role->code, $rolesCanAccessBackend)) {
						$this->setState('accessBackend', true);
						Yii::app()->session['accessBackend'] = true;
					}
					//*/

					$rolesAssigned[] = $role->code;
					if ($role->is_access_backend == 1 && (!isset(Yii::app()->session['accessBackend']) || Yii::app()->session['accessBackend'] === false)) {
						$this->setState('accessBackend', true);
						Yii::app()->session['accessBackend'] = true;
					}
					if ($role->is_access_sensitive_data == 1 && (!isset(Yii::app()->session['accessSensitiveData']) || Yii::app()->session['accessSensitiveData'] === false)) {
						$this->setState('accessSensitiveData', true);
						Yii::app()->session['accessSensitiveData'] = true;
					}
				}
			}
		}
		$this->setState('roleLevelDisplay', substr($roleLevelDisplay, 0, -2));
		$this->setState('rolesAssigned', implode(',', $rolesAssigned));

		// can access cpanel?
		if ((!empty($user->member) && !empty($user->member->username))) {
			$this->setState('accessCpanel', true);
			Yii::app()->session['accessCpanel'] = true;
		}
	}
}
