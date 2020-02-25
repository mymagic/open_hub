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

class Admin extends AdminBase
{
	// field created for searching usage
	public $username;
	public $full_name;
	public $is_active;
	public $gender;
	public $mobile_no;

	// magic connect
	public $first_name;
	public $last_name;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function attributeLabels()
	{
		return array(
		'user_id' => Yii::t('app', 'User'),
		'username' => Yii::t('app', 'Email'),
		'date_added' => Yii::t('app', 'Date Added'),
		'date_modified' => Yii::t('app', 'Date Modified'),
		);
	}

	public function rules()
	{
		return array(
			array('user_id', 'required', 'except' => array('create', 'createConnect')),
			array('user_id, date_added, date_modified', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, username, full_name, is_active, date_added, date_modified, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on' => 'search'),

			// create
			array('username, full_name', 'required', 'on' => 'create'),
			array('username', 'unique', 'allowEmpty' => false, 'className' => 'User', 'attributeName' => 'username', 'caseSensitive' => false, 'on' => array('create')),
			array('username', 'email', 'allowEmpty' => false, 'checkMX' => true, 'on' => array('create')),

			// magic connect
			// createConnect
			array('username, first_name, last_name', 'required', 'on' => 'createConnect'),
			array('username', 'unique', 'allowEmpty' => false, 'className' => 'User', 'attributeName' => 'username', 'caseSensitive' => false, 'on' => array('createConnect')),
			array('username', 'email', 'allowEmpty' => false, 'checkMX' => true, 'on' => array('createConnect')),
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;
		$criteria->with = array('user', 'user.profile');
		$criteria->together = true;

		$criteria->compare('user.username', $this->username, true);
		$criteria->compare('user.is_active', $this->is_active, true);
		$criteria->compare('profile.full_name', $this->full_name, true);

		$criteria->compare('t.user_id', $this->user_id, true);
		if (!empty($this->sdate_added) && !empty($this->edate_added)) {
			$sTimestamp = strtotime($this->sdate_added);
			$eTimestamp = strtotime("{$this->edate_added} +1 day");
			$criteria->addCondition(sprintf('t.date_added >= %s AND t.date_added < %s', $sTimestamp, $eTimestamp));
		}
		if (!empty($this->sdate_modified) && !empty($this->edate_modified)) {
			$sTimestamp = strtotime($this->sdate_modified);
			$eTimestamp = strtotime("{$this->edate_modified} +1 day");
			$criteria->addCondition(sprintf('t.date_modified >= %s AND t.date_modified < %s', $sTimestamp, $eTimestamp));
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'user.date_last_login DESC, t.username ASC',
			),
		));
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
		$result = Yii::app()->db->createCommand()->select('admin.user_id as key, user.username as title')->from(array(self::tableName(), 'user'))->where('admin.user_id=user.id')->queryAll();
		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}
			return $newResult;
		}

		return $result;
	}
}
