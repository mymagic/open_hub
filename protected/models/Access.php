<?php

class Access extends AccessBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('code', 'validateCode', 'on' => array('create', 'update'));

		return $rules;
	}

	public function code2id($code)
	{
		$model = self::model()->find('t.code=:code', array(':code' => $code));
		if (!empty($model)) {
			return $model->id;
		}
	}

	public function beforeValidate()
	{
		$code = [];
		if (!empty($this->module)) {
			$code[] = $this->module;
		}

		if (!empty($this->controller)) {
			$code[] = $this->controller;
		}

		if (!empty($this->action)) {
			$code[] = $this->action;
		}

		$this->code = implode('/', $code);

		return parent::beforeValidate();
	}

	public function code2obj($code, $id)
	{
		// exiang: spent 3 hrs on the single quote around title. it's important if you passing data from different collation db table columns and do compare with = (equal). Changed to LIKE for safer comparison
		$criteria = new CDbCriteria;
		$condition = 't.code=:code';
		$params = array(':code' => trim($code));
		if (!empty($id)) {
			$condition .= ' AND t.id != :id';
			$params[':id'] = $id;
		}
		$criteria->condition = $condition;
		$criteria->params = $params;

		return self::model()->find($criteria);
	}

	public function isCodeExists($code, $id)
	{
		$exists = self::code2obj($code, $id);
		if ($exists === null) {
			return false;
		}

		return $exists->id;
	}

	public function validateCode($attributes, $params)
	{
		if ($this->isCodeExists($this->code, ($this->isNewRecord ? null : $this->id)) !== false) {
			$errorMessage = !empty($params['message']) ? $params['message'] : sprintf('Access with identical settings already exists, you are not allowed to create duplicate.');
			$this->addError($attributes, $errorMessage);
		}
	}
}
