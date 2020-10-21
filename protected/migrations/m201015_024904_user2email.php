<?php

class m201015_024904_user2email extends CDbMigration
{
	public function up()
	{
		$this->createTable('user2email', array(
			'id' => 'pk',
			'user_id' => 'integer NOT NULL',
			'user_email' => 'string NOT NULL',
			'is_verify' => 'boolean NOT NULL DEFAULT 0',
			'verification_key' => 'string NULL',
			'delete_key' => 'string NULL',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$this->alterColumn('user2email', 'user_email', 'varchar(128) NOT NULL');

		$this->createIndex('is_verify', 'user2email', 'is_verify', false);
		$this->createIndex('user2email-user_id-user_email', 'user2email', array('user_id', 'user_email'), true);

		$this->addForeignKey('fk_user2email-user_id', 'user2email', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m201015_024904_user2email does not support migration down.\n";

		return false;
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
