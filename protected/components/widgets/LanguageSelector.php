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

class LanguageSelector extends CWidget
{
	public function run()
	{
		$currentLang = Yii::app()->language;
		$languages = Yii::app()->params->languages;
		$this->render('languageSelector', array('currentLang' => $currentLang, 'languages' => $languages));
	}

	public function translateLanguageCode($lang)
	{
		$languages = Yii::app()->params['languages'];
		if (in_array($lang, array_keys($languages))) {
			return $languages[$lang];
		}

		return $lang;
	}
}
