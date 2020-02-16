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

// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser
{
	// Store model to not repeat query.
	private $_model;
	public $loginUrl = '';
	public $language;

	public function init()
	{
		$this->language = Yii::app()->language;
		parent::init();
	}

	// Load user model.
	protected function loadUser($id = null)
	{
		if ($this->_model === null) {
			if ($id !== null) {
				$this->_model = User::model()->findByPk($id);
			}
		}

		return $this->_model;
	}
}
