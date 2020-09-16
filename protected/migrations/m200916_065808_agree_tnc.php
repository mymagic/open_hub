<?php

class m200916_065808_agree_tnc extends CDbMigration
{
	public function up()
	{
		$embed = Embed::setEmbed('signup-tncContent', array(
			'is_title_enabled' => true,
			'is_text_description_enabled' => false,
			'is_html_content_enabled' => true,
			'is_image_main_enabled' => false,
			'is_default' => true,
			'title_en' => 'Terms and Conditions',
			'html_content_en' => 'Hello Admin, please remember to update this terms and condition content inside Embed \ <b>#signup-tncContent</b>',
		));
	}

	public function down()
	{
		return Embed::deleteEmbed('signup-tncContent');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
