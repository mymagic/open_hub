<?php

class Sample extends SampleBase
{
	public static function model($class = __CLASS__){return parent::model($class);}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, title_en, text_short_description_en, date_posted', 'required'),
			array('sample_group_id, age, date_posted, is_active, is_public, is_member, is_admin, date_added, date_modified', 'numerical', 'integerOnly'=>true),
			array('ordering', 'numerical'),
			array('code, sample_zone_code', 'length', 'max'=>32),
			array('title_en, title_ms, title_zh', 'length', 'max'=>100),
			array('text_short_description_en, text_short_description_ms, text_short_description_zh, image_main, file_backup', 'length', 'max'=>255),
			array('price_main', 'length', 'max'=>10),
			array('gender', 'length', 'max'=>6),
			array('html_content_en, html_content_ms, html_content_zh, csv_keyword', 'safe'),
			array('imageFile_main', 'file', 'types'=>'jpg, jpeg, png, gif', 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, sample_group_id, sample_zone_code, title_en, title_ms, title_zh, text_short_description_en, text_short_description_ms, text_short_description_zh, html_content_en, html_content_ms, html_content_zh, image_main, file_backup, price_main, gender, age, csv_keyword, ordering, date_posted, is_active, is_public, is_member, is_admin, date_added, date_modified, sdate_posted, edate_posted, sdate_added, edate_added, sdate_modified, edate_modified', 'safe', 'on'=>'search'),
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
}
