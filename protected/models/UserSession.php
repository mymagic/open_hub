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

class UserSession extends UserSessionBase
{
	public static function model($class = __CLASS__){return parent::model($class);}
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}
	
	public function trackLogin($userId, $sessionId)
	{
		//echo $userId;exit;
		// similar session already exists
		$id = UserSession::model()->isSessionExists($userId, $sessionId);
		if(!empty($id))
		{
			// update
			$us = UserSession::model()->findByPk($id);
			$us->date_last_heartbeat = time();
			return $us->save();
		}
		else
		// is new session
		{
			// insert new
			$us = new UserSession;
			$us->user_id = $userId;
			$us->session_code = $sessionId;
			$us->date_login = $us->date_last_heartbeat = time();
			return $us->save();
		}
	}
	
	// return record id if session exists
	public function isSessionExists($userId, $sessionId)
	{
		 $record = $this->find(array
		 (
			'select'=>'id',
			'condition'=>'session_code=:sessionId AND user_id=:userId',
			'params'=>array(':sessionId'=>$sessionId, ':userId'=>$userId))
		);
		
		if($record != null && !empty($record->id))
		{
			return $record->id;
		}
		
		return false;		
	}
	
	// return number of session
	public function isOnlineNow($userId)
	{
		$heartbeatStartTimestamp = strtotime(sprintf('-%s seconds', Yii::app()->session->timeout));
		$sql = sprintf("SELECT COUNT(us.session_code) as total_session FROM user_session as us WHERE us.user_id=%s AND us.date_last_heartbeat>=%s GROUP BY us.user_id", $userId, $heartbeatStartTimestamp);
		return (int) Yii::app()->db->createCommand($sql)->queryScalar();
	}
	
}
