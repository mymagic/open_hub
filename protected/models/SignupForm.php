<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SignupForm extends CFormModel
{
	public $email;
	public $cemail;
	
	//public $tocContent;
	//public $agreetoc;
	
	public $verifyCode;

	public function init()
	{
		parent::init();
		//$this->tocContent = file_get_contents(Yii::getPathOfAlias('static').'/toc.htm');
	}
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			////array('email, cemail, agreetoc', 'required'),
			array('email, cemail, verifyCode', 'required'),
			// email has to be a valid email address and matched confirmed email
			array('email', 'emailIsUnique'),
			array('email', 'email'),
			array('cemail', 'compare', 'compareAttribute'=>'email'),
			// nickname from 5-12 characters, must only contains alphabetic value
			//array('nickname', 'length', 'min'=>5, 'max'=>12),
			//array('nickname', 'match', 'pattern'=>'/^([a-z0-9_-])+$/', 'message'=>Yii::t('app', '{attribute} only accept valid character set like a-z, 0-9, - and _')),
			// must check
			////array('agreetoc', 'required', 'requiredValue'=>1, 'message'=>"You must have read and agree to the terms and conditions to proceed."),
			//array('gender, address_line2, town', 'safe'),
			
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
			'cemail' => Yii::t('app','Confirm Email'),
			//'nickname' => Yii::t('app','Nick Name'),
			//'toc' => Yii::t('app','Terms &amp; Conditions'),
			//'agreetoc' => Yii::t('app','I have read and agree to terms and conditions'),
			'verifyCode'=> Yii::t('app','I am not a robot'),
		);
	}
	
	public function emailIsUnique($attribute, $params)
	{
		if(!User::isUniqueUsername($this->$attribute))
		{
			$this->addError($attribute, Yii::t('app', 'This email has already been taken.'));
		}
	}
}