<?php

class Challenge extends ChallengeBase
{
	public $imageRemote_cover;
	public $imageRemote_header;

	public static function model($class = __CLASS__)
	{
		return parent::model($class);
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
		if (Yii::app()->neo4j->getStatus()) {
			Neo4jChallenge::model($this)->sync();
		}

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
		$return['text_short_description'] = Yii::t('challenge', 'Short Description');
		$return['image_cover'] = Yii::t('challenge', 'header Image');
		$return['image_header'] = Yii::t('challenge', 'Header Image');
		$return['url_video'] = Yii::t('challenge', 'Video URL');
		$return['url_application_form'] = Yii::t('challenge', 'Application URL');
		$return['html_content'] = Yii::t('challenge', 'Content');
		$return['html_deliverable'] = Yii::t('challenge', 'Deliverable');
		$return['html_criteria'] = Yii::t('challenge', 'Criteria');
		$return['html_prize_detail'] = Yii::t('challenge', 'Prize (Detail)');
		$return['text_remark'] = Yii::t('challenge', 'Remark for Admin');
		$return['date_open'] = Yii::t('challenge', 'Start Date');
		$return['date_close'] = Yii::t('challenge', 'End Date');
		$return['is_active'] = Yii::t('challenge', 'Active');
		$return['is_publish'] = Yii::t('challenge', 'Published');
		$return['is_highlight'] = Yii::t('challenge', 'Highlighted');

		return $return;
	}

	public function title2obj($title)
	{
		// exiang: spent 3 hrs on the single quote around title. it's important if you passing data from different collation db table columns and do compare with = (equal). Changed to LIKE for safer comparison
		return Challenge::model()->find('t.title=:title', array(':title' => trim($title)));
	}

	public function isTitleExists($title)
	{
		$exists = self::title2obj($title);
		if ($exists === null) {
			return false;
		}

		return $exists->id;
	}

	// image_cover
	public function getImageCoverUrl()
	{
		return StorageHelper::getUrl($this->image_cover);
	}

	public function getImageCoverThumbUrl($width = 100, $height = 100)
	{
		return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_cover));
	}

	public function getDefaultImageCover()
	{
		return 'uploads/challenge/header.default.jpg';
	}

	public function isDefaultImageCover()
	{
		if ($this->image_cover == $this->getDefaultImageCover()) {
			return true;
		}

		return false;
	}

	// image_header
	public function getImageHeaderUrl()
	{
		return StorageHelper::getUrl($this->image_header);
	}

	public function getImageHeaderThumbUrl($width = 100, $height = 100)
	{
		return StorageHelper::getUrl(ImageHelper::thumb($width, $height, $this->image_header));
	}

	public function getDefaultImageHeader()
	{
		return 'uploads/challenge/header.default.jpg';
	}

	public function isDefaultImageHeader()
	{
		if ($this->image_header == $this->getDefaultImageHeader()) {
			return true;
		}

		return false;
	}
}
