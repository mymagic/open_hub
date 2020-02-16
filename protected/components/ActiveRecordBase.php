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

/**
 * Active Record base functions
 *
 * @author exiang
 * @link http://yeesiang.com
 */
class ActiveRecordBase extends ActiveRecord
{
	public function getDataProvider($criteria = null, $pagination = null)
	{
		if ((is_array($criteria)) || ($criteria instanceof CDbCriteria)) {
			$this->getDbCriteria()->mergeWith($criteria);
		}
		$pagination = CMap::mergeArray(array('pageSize' => 10), (array) $pagination);

		return new CActiveDataProvider(__CLASS__, array(
			'criteria' => $this->getDbCriteria(),
			'pagination' => $pagination
		));
	}
}
