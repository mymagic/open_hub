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

class Legalform extends LegalformBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function toApi($params='')
	{
		$return = array(
			'id' => $this->id,
			'title' => $this->title,
			'countryCode' => $this->country_code,
			'isActive' => $this->is_active,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
		);
			
		return $return;
	}
}
