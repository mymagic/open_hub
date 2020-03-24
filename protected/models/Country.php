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

class Country extends CountryBase
{
	// override to display country by sorted printable_name
	public function getForeignReferList($isNullable = false, $is4Filter = false)
	{
		$language = Yii::app()->language;

		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('key' => '', 'title' => '');
		}
		$result = Yii::app()->db->createCommand()->select('code as key, printable_name as title')->from(self::tableName())->order('printable_name ASC')->queryAll();
		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function toApi()
	{
		return array(
			'code' => $this->code,
			'name' => $this->name,
			'printableName' => $this->printable_name,
			'iso3' => $this->iso3,
		);
	}
}
