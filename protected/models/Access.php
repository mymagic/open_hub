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

	/**
	 * @param string $module
	 * @param string $controler controller file name
	 * @param mixed $actions string/array of action
	 * @param mixed $roles string/array of role (available roles: superAdmin, developer, admin, roleManager, adminManager, contentManager, memberManager, reportManager, ecosystem)
	 *
	 * @return boolean
	 **/
	public function setAccessRole($module, $controller, $actions, $roles)
	{
		if (empty($controller)) {
			return false;
		}

		if (!is_array($actions)) {
			$actions = [$actions];
		}

		if (!is_array($roles)) {
			$roles = [$roles];
		}

		$controller_id = preg_replace('/controller/i', '', $controller, 1);
		$controller_id = lcfirst($controller_id);

		$actions = array_filter($actions);
		$roles = array_filter($roles);

		if (!empty($actions)) {
			foreach ($actions as $action) {
				$route = [$module, $controller_id, $action];
				$route = array_filter($route);
				$route = implode('/', $route);

				$access_id = self::isCodeExists($route, '');
				if ($access_id === false) {
					$mAccess = new Access;
					$mAccess->code = $route;
					$mAccess->title = $route;
					$mAccess->module = !empty($module) ? $module : null;
					$mAccess->controller = $controller_id;
					$mAccess->action = $action;
					$mAccess->is_active = 1;
					$mAccess->save();

					$access_id = $mAccess->id;
				}

				if (!empty($access_id) && !empty($roles)) {
					foreach ($roles as $role) {
						$role_id = Role::code2id($role);
						if (!empty($role_id)) {
							// check if record already exist
							$mRole2Access = Role2Access::model()->findByAttributes(['role_id' => $role_id, 'access_id' => $access_id]);
							if ($mRole2Access === null) {
								$mRole2Access = new Role2Access;
								$mRole2Access->role_id = $role_id;
								$mRole2Access->access_id = $access_id;
								$mRole2Access->save();
							}
						}
					}
				}
			}
		}

		return true;
	}

	protected function afterSave()
	{
		HUB::clearCache();

		return parent::afterSave();
	}
}
