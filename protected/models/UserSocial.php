<?php

class UserSocial extends UserSocialBase
{
	public $jsonArray_socialParams;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'username'),
		);
	}

	protected function afterFind()
	{
		$this->jsonArray_socialParams = json_decode($this->json_social_params);

		parent::afterFind();
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
		$result = Yii::app()->db->createCommand()->select("id as key, CONCAT_WS('-', username, social_provider, social_identifier) as title")->from(self::tableName())->queryAll();
		if ($is4Filter) {
			$newResult = array();
			foreach ($result as $r) {
				$newResult[$r['key']] = $r['title'];
			}
			return $newResult;
		}

		return $result;
	}

	public static function getObjByProviderId($username, $socialProvider, $socialIdentifier)
	{
		$userSocial = self::model()->find('t.username=:username AND t.social_provider=:socialProvider AND t.social_identifier=:socialIdentifier', array(':username' => $username, ':socialProvider' => $socialProvider, ':socialIdentifier' => $socialIdentifier));
		if (!empty($userSocial)) {
			return $userSocial;
		}
	}
}
