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

class HubRegistry
{
	public static function get($code)
	{
		$model = Registry::model()->code2obj($code);
		if ($model === null) {
			throw new CHttpException(404, 'The requested registry does not exist.');
		}

		return $model;
	}

	public static function set($code, $value)
	{
		if (Registry::isCodeExists($code)) {
			$registry = self::get($code);
		} else {
			$registry = new Registry;
		}

		$registry->code = $code;
		$registry->the_value = $value;

		return $registry->save();
	}
}
