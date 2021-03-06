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

	public function getSystemActFeed($dateStart, $dateEnd, $page = 1, $forceRefresh = 0)
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
			$sql = sprintf('SELECT * FROM member WHERE date_modified>=%s AND date_modified<%s ORDER BY date_modified DESC LIMIT %s, %s', $timestampStart, $timestampEnd, ($page - 1) * $limit, $limit);
			$data = Member::model()->findAllBySql($sql);

			$status = 'success';
			$msg = '';
		}

		return array('status' => $status, 'msg' => $msg, 'data' => $data);
	}

	// get individual thru email
	// only the verified one is return
	public function getIndividuals($member)
	{
		return HubIndividual::getIndividualsByEmail($member->username);
	}

	// get organization thru email
	// only approved organizations are return
	public function getOrganizations($member)
	{
		return HubOrganization::getUserActiveOrganizations($member->username);
	}

	public static function getUser2Email($id)
	{
		$model = User2Email::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested data does not exist.');
		}

		return $model;
	}

	public static function getUser2EmailUserId($userId, $userEmail)
	{
		$model = User2Email::model()->findByAttributes(array('user_id' => $userId, 'user_email' => $userEmail));
		if ($model === null) {
			throw new CHttpException(404, 'The requested data does not exist.');
		}

		return $model->id;
	}

	public static function getUser2Emails($userId, $pagi = '')
	{
		$pagi['auto'] = isset($pagi['auto']) ? $pagi['auto'] : false;
		$pagi['currentPage'] = isset($pagi['currentPage']) ? $pagi['currentPage'] : 0;
		$pagi['pageSize'] = isset($pagi['pageSize']) ? $pagi['pageSize'] : 10;

		$criteria = new CDbCriteria();
		$criteria->compare('user_id', $userId);

		if ($pagi['auto'] == false) {
			$pagination = array('pageSize' => $pagi['pageSize'], 'currentPage' => $pagi['currentPage'], 'validateCurrentPage' => false);
		}

		$dataProvider = new CActiveDataProvider('User2Email', array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.date_added DESC'),
			'pagination' => $pagination,
		));

		return array(
			'model' => $dataProvider->getData(),
			'dataProvider' => $dataProvider,
			'totalItemCount' => intval($dataProvider->totalItemCount),
			'pages' => $dataProvider->pagination,
		);
	}
}
