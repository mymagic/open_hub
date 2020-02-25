<?php

class SearchForm extends CFormModel
{
	public $email;
	public $fullName;
	public $mobileNo;
	public $organization;
	public $keyword;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// email has to be a valid email address
			array('email', 'email'),
			array('email, fullName, mobileNo, organization, keyword', 'safe')
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
			'fullName' => Yii::t('app', 'Full Name'),
			'mobileNo' => Yii::t('app', 'Mobile Number'),
			'organization' => Yii::t('app', 'Organization'),
			'keyword' => Yii::t('app', 'Keyword'),
		);
	}
}
