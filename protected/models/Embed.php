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

class Embed extends EmbedBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public static function code2value($code, $attribute = '', $exceptionIfNotFound = false)
	{
		return self::getByCode($code, $attribute, $exceptionIfNotFound);
	}

	public function getByCode($code, $attribute = '', $exceptionIfNotFound = false)
	{
		$cacheId = sprintf('embed.getByCode%s', $code);
		$model = Yii::app()->cache->get($cacheId);
		if ($model === false) {
			$model = Embed::model()->find('t.code=:code', array(':code' => $code));
			Yii::app()->cache->set($cacheId, $model, 30);
		}

		if ($model === null && $exceptionIfNotFound) {
			throw new CHttpException(404, 'The requested embed content does not exist.');
		}
		if ($attribute == '') {
			return $model;
		} else {
			if ($model !== null) {
				return $model->getAttributeDataByLanguage($model, $attribute);
			}
		}

		if ($attribute != '') {
			return '';
		} else {
			return null;
		}
	}

	public function isCodeExists($code)
	{
		$embed = Embed::model()->find('code=:code', array(':code' => $code));
		if ($embed === null) {
			return false;
		}

		return true;
	}

	// will auto initialize module embed, auto create if not exists, else just ignore
	// code should come with prefix with moduleKey infront, eg: boilerplateStart-var1
	// values is array: title_en, text_description_en, html_content_en, text_note,
	// must set: is_title_enabled, is_text_description_enabled, is_html_content_enabled, is_image_main_enabled, is_default
	public static function setEmbed($code, $values)
	{
		if (isset($values['is_title_enabled'])) {
			$values['is_title_enabled'] = intval($values['is_title_enabled']);
		}
		if (isset($values['is_text_description_enabled'])) {
			$values['is_text_description_enabled'] = intval($values['is_text_description_enabled']);
		}
		if (isset($values['is_html_content_enabled'])) {
			$values['is_html_content_enabled'] = intval($values['is_html_content_enabled']);
		}
		if (isset($values['is_image_main_enabled'])) {
			$values['is_image_main_enabled'] = intval($values['is_image_main_enabled']);
		}
		if (isset($values['is_default'])) {
			$values['is_default'] = intval($values['is_default']);
		}

		// new record
		if (!self::isCodeExists($code)) {
			$embed = new Embed();
			$embed->code = $code;
		} else {
			$embed = self::model()->find('code=:code', array(':code' => $code));
		}

		$embed->setAttributes($values);
		$embed->save();

		return $embed;
	}

	public static function deleteEmbed($code)
	{
		$embed = self::model()->find('code=:code', array(':code' => $code));
		if ($embed) {
			return $embed->delete();
		}
	}
}
