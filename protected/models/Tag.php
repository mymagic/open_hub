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

class Tag extends TagBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function getForeignReferList($isNullable = false, $is4Filter = false)
	{
		$language = Yii::app()->language;

		if ($is4Filter) {
			$isNullable = false;
		}
		if ($isNullable) {
			$result[] = array('key' => '', 'title' => '');
		}
		$result = Yii::app()->db->createCommand()->select('id as key, name as title')->from(self::tableName())->queryAll();
		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}

			return $newResult;
		}

		return $result;
	}

	public function searchAdvance($keyword)
	{
		$this->unsetAttributes();

		$this->name = $keyword;

		$tmp = $this->search(array('compareOperator' => 'OR'));
		$tmp->sort->defaultOrder = 't.name ASC';

		return $tmp;
	}
}
