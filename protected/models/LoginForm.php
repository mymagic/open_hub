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
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			array('username', 'email'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe' => Yii::t('core', 'Remember me next time'),
			'username' => Yii::t('core', 'Email'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		Notice::debugFlash('LoginForm.authenticate()');

		if (!$this->hasErrors()) {
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
			if (!$this->_identity->errorCode) {
				$this->addError('password', Yii::t('core', 'Incorrect username or password.'));
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		Notice::debugFlash('LoginForm.login()');

		if ($this->_identity === null) {
			Notice::debugFlash(Yii::t('notice', 'username:{username}, password:{password}', ['username' => $this->username, 'password' => $this->password]));

			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}

		Notice::debugFlash(Yii::t('notice', 'login error code: {error}', ['error' => $this->_identity->errorCode]));

		// login decision
		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			Notice::debugFlash('UserIdentity::ERROR_NONE');
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);

			return true;
		} elseif ($this->_identity->errorCode === UserIdentity::ERROR_USERNAME_INVALID) {
			Notice::debugFlash('UserIdentity::ERROR_USERNAME_INVALID');
			$this->addError('username', 'Invalid username');
		} elseif ($this->_identity->errorCode === UserIdentity::ERROR_ACCOUNT_BLOCKED) {
			Notice::debugFlash('UserIdentity::ERROR_ACCOUNT_BLOCKED');
			$this->addError('username', Yii::t('core', 'Your account has been disabled by the system admin.'));
		} else {
			$this->addError('password', Yii::t('notice', 'Incorrect username or password.'));
		}

		return false;
	}
}
