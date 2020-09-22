<?php

class m200827_142303_usersocial extends CDbMigration
{
	public function up()
	{
		$this->createTable('user_social', [
			'id' => 'pk',
			'username' => 'string NOT NULL',
			'social_provider' => 'string NOT NULL',
			'social_identifier' => 'string NOT NULL',
			'json_social_params' => 'text NOT NULL',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		]);

		$this->alterColumn('user_social', 'username', 'varchar(128) NOT NULL');
		$this->alterColumn('user_social', 'social_provider', 'varchar(32) NOT NULL');
		$this->alterColumn('user_social', 'social_identifier', 'varchar(64) NOT NULL');

		$this->createIndex('user_social', 'user_social', ['username', 'social_provider', 'social_identifier'], true);
		$this->createIndex('user_social-username', 'user_social', 'username', false);

		$this->addForeignKey('fk_user_social-username', 'user_social', 'username', 'user', 'username', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m200827_142303_usersocial does not support migration down.\n";

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
