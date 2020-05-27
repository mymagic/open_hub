<?php

class m200527_041930_cpanel_deactivateAccountMessage extends CDbMigration
{
	public function up()
	{
		$htmlContent = '
		<b>We are sad to see you leave. Before you go, please read this carefully</b>
		<p>By completing this process, your account will be terminated and deleted which will cause all content including your activity feed with us to be PERMANENTLY erased. The termination of your account will take effect immediately. Your account will be inaccessible once the termination is complete.</p>
		<p>There is no way we can revert this process.</p>
		<p>You will receive an email update from our team which will include a copy of your information within 1 hour. Be sure to check your spam inbox if you do not receive any email from us within 12 hours from the termination of your account. </p>
		<p>We are sorry to see you go. Please let us know if it was something we did that is causing you to leave us. As we continuously strive to improve our services, your feedback is valuable to us.</p>
		';

		$embed = Embed::setEmbed('cpanel-deleteAccountMessage', array(
			'is_title_enabled' => true,
			'is_text_description_enabled' => false,
			'is_html_content_enabled' => true,
			'is_image_main_enabled' => false,
			'is_default' => true,
			'title_en' => 'Terminate Account',
			'html_content_en' => $htmlContent,
		));

		if ($embed->validate() && !empty($embed->id)) {
			return true;
		}

		return false;
	}

	public function down()
	{
		return Embed::deleteEmbed('cpanel-deleteAccountMessage');
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
