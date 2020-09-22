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
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SignupForm extends CFormModel
{
	public $email;
	public $cemail;
	public $fullname;

	public $tncContent;
	public $agreeTnc;

	public $verifyCode;

	public function init()
	{
		parent::init();
		$this->tncContent = Embed::code2value('signup-tncContent', 'html_content');
	}

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('email, cemail, fullname, verifyCode, agreeTnc', 'required'),
			// email has to be a valid email address and matched confirmed email
			array('email', 'emailIsUnique'),
			array('email', 'email'),
			array('cemail', 'compare', 'compareAttribute' => 'email'),
			array('agreeTnc', 'compare', 'compareValue' => true, 'message' => Yii::t('app', 'Must agree to Terms and conditions')),

			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => Yii::t('app', 'Email'),
			'cemail' => Yii::t('app', 'Retype Email'),
			'fullname' => Yii::t('app', 'Full Name'),
			'toc' => Yii::t('app', 'Terms &amp; Conditions'),
			'agreeTnc' => Yii::t('app', 'I have read and agree to terms and conditions'),
			'verifyCode' => Yii::t('app', 'I am not a robot'),
		);
	}

	public function emailIsUnique($attribute, $params)
	{
		if (!User::isUniqueUsername($this->$attribute)) {
			$this->addError($attribute, Yii::t('app', 'This email has already been taken.'));
		}
	}
}
