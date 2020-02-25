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

class HubSeolytic
{
	public static function getMatchingSeolytic($urlPath)
	{
		$seolytics = Seolytic::model()->findAll(array('condition' => 'is_active=1', 'order' => 'ordering ASC'));
		if (!empty($seolytics)) {
			foreach ($seolytics as $seolytic) {
				//echo sprintf('%s vs %s', $seolytic->path_pattern, $urlPath);exit;
				$matches = array();
				preg_match($seolytic->path_pattern, $urlPath, $matches);
				//print_r($matches);exit;
				if (!empty($matches)) {
					return $seolytic;
				}
			}
		}

		return null;
	}
}
