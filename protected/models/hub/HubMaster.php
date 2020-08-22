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

class HubMaster
{
	public static function getAllActiveIndustries()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActiveIndustries', sha1(json_encode(array('v3'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = Industry::model()->isActive()->findAll(array('order' => 'title ASC'));
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActiveLegalForms($countryCode = 'MY')
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllLegalForms', sha1(json_encode(array('v3', $countryCode))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = Legalform::model()->isActive()->findAll(array('condition' => sprintf("country_code='%s'", $countryCode), 'order' => 'title ASC'));
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActiveProductCategories()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActiveProductCategories', sha1(json_encode(array('v3'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = ProductCategory::model()->isActive()->findAll(array('order' => 'ordering ASC'));
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActiveImpacts()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActiveImpacts', sha1(json_encode(array('v1'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = Impact::model()->isActive()->findAll();
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActiveClusters()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActiveClusters', sha1(json_encode(array('v1'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = Cluster::model()->isActive()->findAll(array('order' => 'ordering ASC'));
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActivePersonas()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActivePersonas', sha1(json_encode(array('v1'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = Persona::model()->isActive()->findAll();
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActiveStartupStages()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActiveStartupStages', sha1(json_encode(array('v1'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = StartupStage::model()->isActive()->findAll(array('order' => 'ordering ASC'));
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}

	public static function getAllActiveSdgs()
	{
		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUB', 'getAllActiveSdgs', sha1(json_encode(array('v1'))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = Sdg::model()->isActive()->findAll(array('order' => 'title ASC'));
			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
	}
}
