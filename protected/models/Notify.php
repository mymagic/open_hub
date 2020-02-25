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

class Notify extends NotifyBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'required'),
			array('sender_id, receiver_id, is_sent, is_read, date_sent, date_read, date_added, date_modified', 'numerical', 'integerOnly' => true),
			array('message', 'length', 'max' => 500),
			array('priority', 'length', 'max' => 1),
			array('sender_type, receiver_type', 'length', 'max' => 24),
			array('json_payload', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, message, json_payload, priority, sender_type, sender_id, receiver_type, receiver_id, is_sent, is_read, date_sent, date_read, json_extra, date_added, date_modified, sdate_sent, edate_sent, sdate_read, edate_read, sdate_added, edate_added, sdate_modified, edate_modified, title, content, hasEmail, hasPush, hasSms, sentEmail, sentPush, sentSms, receiverFullName, receiverEmail, receiverMobileNo, receiverDeviceId, receiverDeviceToken, receiverDeviceType', 'safe', 'on' => 'search'),
		);
	}

	public function getMsg()
	{
		if (ysUtil::isJson($this->message)) {
			$jsonArray_message = json_decode($this->message);

			return $jsonArray_message->msg;
		}

		return $this->message;
	}

	public function toApi()
	{
		return array(
			'id' => $this->id,
			'title' => $this->title,
			'message' => $this->message,
			'content' => $this->content,
			'hasSms' => boolval($this->hasSms),
			'hasEmail' => boolval($this->hasEmail),
			'hasPush' => boolval($this->hasPush),
			'sentSms' => boolval($this->sentSms),
			'sentEmail' => boolval($this->sentEmail),
			'sentPush' => boolval($this->sentPush),
			'priority' => intval($this->priority),
			'senderType' => $this->sender_type,
			'senderId' => $this->sender_id,
			'receiverType' => $this->receiver_type,
			'receiverId' => $this->receiver_id,
			'receiverFullName' => $this->receiverFullName,
			'receiverEmail' => $this->receiverEmail,
			'receiverMobileNo' => $this->receiverMobileNo,
			'receiverDeviceId' => $this->receiverDeviceId,
			'receiverDeviceToken' => $this->receiverDeviceToken,
			'receiverDeviceType' => $this->receiverDeviceType,
			'isSent' => boolval($this->is_sent),
			'isRead' => boolval($this->is_read),
			'dateSent' => $this->date_sent,
			'dateRead' => $this->date_read,
			'dateAdded' => $this->date_added,
			'dateModified' => $this->date_modified,
			'jsonPayload' => $this->jsonArray_payload,
		);
	}

	protected function afterFind()
	{
		$this->jsonArray_extra = json_decode($this->json_extra);
		$this->title = $this->jsonArray_extra->title;
		$this->content = $this->jsonArray_extra->content;
		$this->hasEmail = $this->jsonArray_extra->hasEmail;
		$this->hasPush = $this->jsonArray_extra->hasPush;
		$this->hasSms = $this->jsonArray_extra->hasSms;
		$this->sentEmail = $this->jsonArray_extra->sentEmail;
		$this->sentPush = $this->jsonArray_extra->sentPush;
		$this->sentSms = $this->jsonArray_extra->sentSms;
		$this->receiverFullName = $this->jsonArray_extra->receiverFullName;
		$this->receiverEmail = $this->jsonArray_extra->receiverEmail;
		$this->receiverMobileNo = $this->jsonArray_extra->receiverMobileNo;
		$this->receiverDeviceId = $this->jsonArray_extra->receiverDeviceId;
		$this->receiverDeviceToken = $this->jsonArray_extra->receiverDeviceToken;
		$this->receiverDeviceType = $this->jsonArray_extra->receiverDeviceType;

		$this->jsonArray_payload = json_decode($this->json_payload);

		parent::afterFind();
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if ($this->hasSms && !$this->sentSms) {
				$this->is_sent = 0;
			}
			if ($this->hasEmail && !$this->sentEmail) {
				$this->is_sent = 0;
			}
			if ($this->hasPush && !$this->sentPush) {
				$this->is_sent = 0;
			}

			$this->is_sent = $this->hasSentAll();

			if (!empty($this->date_sent)) {
				if (!is_numeric($this->date_sent)) {
					$this->date_sent = strtotime($this->date_sent);
				}
			}
			if (!empty($this->date_read)) {
				if (!is_numeric($this->date_read)) {
					$this->date_read = strtotime($this->date_read);
				}
			}

			// auto deal with date added and date modified
			if ($this->isNewRecord) {
				$this->date_added = $this->date_modified = time();
			} else {
				$this->date_modified = time();
			}

			// json
			$this->jsonArray_extra->title = $this->title;
			$this->jsonArray_extra->content = $this->content;
			$this->jsonArray_extra->hasEmail = $this->hasEmail;
			$this->jsonArray_extra->hasPush = $this->hasPush;
			$this->jsonArray_extra->hasSms = $this->hasSms;
			$this->jsonArray_extra->sentEmail = $this->sentEmail;
			$this->jsonArray_extra->sentPush = $this->sentPush;
			$this->jsonArray_extra->sentSms = $this->sentSms;
			$this->jsonArray_extra->receiverFullName = $this->receiverFullName;
			$this->jsonArray_extra->receiverEmail = $this->receiverEmail;
			$this->jsonArray_extra->receiverMobileNo = $this->receiverMobileNo;
			$this->jsonArray_extra->receiverDeviceId = $this->receiverDeviceId;
			$this->jsonArray_extra->receiverDeviceToken = $this->receiverDeviceToken;
			$this->jsonArray_extra->receiverDeviceType = $this->receiverDeviceType;
			$this->json_extra = json_encode($this->jsonArray_extra);
			if ($this->json_extra == 'null') {
				$this->json_extra = null;
			}

			$this->json_payload = json_encode($this->jsonArray_payload);
			if ($this->json_payload == 'null') {
				$this->json_payload = null;
			}

			return true;
		} else {
			return false;
		}
	}

	public function hasSentAll()
	{
		$isSent = 0;

		$hasSms = $this->hasSms;
		$hasEmail = $this->hasEmail;
		$hasPush = $this->hasPush;

		$sentSms = $this->sentSms;
		$sentEmail = $this->sentEmail;
		$sentPush = $this->sentPush;

		$tmp = 0;
		$fufill = $hasSms + $hasEmail + $hasPush;
		if ($hasSms && $sentSms) {
			$tmp++;
		}
		if ($hasEmail && $sentEmail) {
			$tmp++;
		}
		if ($hasPush && $sentPush) {
			$tmp++;
		}
		if ($fufill == $tmp) {
			$isSent = 1;
		}

		return $isSent;
	}
}
