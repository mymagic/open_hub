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

class HubMember
{
	// todo
	// username is email
	public static function createMember($username, $fullname)
	{
		// check if user not exists, then create user and profile
		// create member
	}

	public function getSystemActFeed($dateStart, $dateEnd, $page=1, $forceRefresh = 0)
	{
		$limit = 30;
		$status = 'fail';
		$msg = 'Unknown error';

		$timestampStart = strtotime($dateStart);
		$timestampEnd = strtotime($dateEnd) + (24 * 60 * 60);

		// date range can not be more than 60 days
		if (floor(($timestampEnd - $timestampStart) / (60 * 60 * 24)) > 60) {
			$msg = 'Max date range cannot more than 60 days';
		} else {
			$data = null;
			$sql = sprintf('SELECT * FROM member WHERE date_modified>=%s AND date_modified<%s ORDER BY date_modified DESC LIMIT %s, %s', $timestampStart, $timestampEnd, ($page-1)*$limit, $limit);
			$data = Member::model()->findAllBySql($sql);

			$status = 'success';
			$msg = '';
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}
}
