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

class WebModule extends CWebModule
{
	public $modelBehaviors;

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			if (Yii::app()->params['dev'] == true) {
				Yii::app()->assetManager->forceCopy = true;
			}

			// this method is called before any module controller action is performed
			// you may place customized code here

			return true;
		} else {
			return false;
		}
	}

	public function setupSetting($code, $value, $extra = null)
	{
		// setting exists, dont change value
		if (Setting::isCodeExists($code)) {
			return true;
		} else {
			// setting not exists, create one
			$setting = new Setting;
			$setting->code = $code;
			$setting->value = $value;
			$setting->datatype = (!empty($extra) && !empty($extra['datatype'])) ? $extra['datatype'] : 'string';
			$setting->datatype_value = (!empty($extra) && !empty($extra['datatype_value'])) ? $extra['datatype_value'] : '';
			$setting->note = (!empty($extra) && !empty($extra['note'])) ? $extra['note'] : '';

			return $setting->save();
		}
	}
}
