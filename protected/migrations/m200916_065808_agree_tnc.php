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

		$embed = Embed::setEmbed('lost-password', array(
			'is_title_enabled' => true,
			'is_text_description_enabled' => false,
			'is_html_content_enabled' => true,
			'is_image_main_enabled' => false,
			'is_default' => true,
			'title_en' => 'Forgot your password?',
			'html_content_en' => '<p>Dont\' worry, we can recover for you</p><ol>
				<li>Insert your account\'s email.</li>
				<li>You will receive an confirmation email. Follow the instruction in it and click the link to reset password for your account.</li>
				<li>Once reset confirmed, system will auto generate a new password and email to you.</li>
				<li>We strongly suggest you to change password after login.</li>
			</ol>',
		));

		$embed = Embed::setEmbed('member-entryContent', array(
			'is_title_enabled' => true,
			'is_text_description_enabled' => false,
			'is_html_content_enabled' => true,
			'is_image_main_enabled' => false,
			'is_default' => true,
			'title_en' => 'Member Control Panel',
			'html_content_en' => '
			<p>Login or create an account to access member control panel.</p>
			<ul>
				<li>Manage your startup profile</li>
				<li>Activity feed for all events</li>
				<li>Personalized recommendation</li>
			</ul>',
		));
	}

	public function down()
	{
		return Embed::deleteEmbed('signup-tncContent');

		return Embed::deleteEmbed('lost-password');

		return Embed::deleteEmbed('member-entryContent');
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
