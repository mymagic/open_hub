<?php

class Comment extends CommentBase
{
	public static function model($class = __CLASS__)
	{
		return parent::model($class);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'commentUpvotes' => array(self::HAS_MANY, 'CommentUpvote', 'comment_id'),
			'countCommentUpvotes' => array(self::STAT, 'CommentUpvote', 'comment_id'),
		);
	}

	public function init()
	{
		// custom code here
		// ...

		parent::init();

		// return void
	}

	public function beforeValidate()
	{
		// custom code here
		// ...

		return parent::beforeValidate();
	}

	public function afterValidate()
	{
		// custom code here
		// ...

		return parent::afterValidate();
	}

	protected function beforeSave()
	{
		// custom code here
		// ...

		return parent::beforeSave();
	}

	protected function afterSave()
	{
		// custom code here
		// ...

		return parent::afterSave();
	}

	protected function beforeFind()
	{
		// custom code here
		// ...

		parent::beforeFind();

		// return void
	}

	protected function afterFind()
	{
		// custom code here
		// ...

		parent::afterFind();

		// return void
	}

	public function attributeLabels()
	{
		$return = parent::attributeLabels();

		// custom code here
		// $return['title'] = Yii::t('app', 'Custom Name');

		return $return;
	}

	public function hasUserUpvote($userId)
	{
		foreach ($this->commentUpvotes as $upvote) {
			if ($upvote->user_id == $userId) {
				return true;
			}
		}

		return false;
	}

	public function countByObjectKey($objectKey)
	{
		return Comment::model()->countByAttributes(array(
			'object_key' => $objectKey
		));
	}
}
