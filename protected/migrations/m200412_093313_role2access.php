<?php

class m200412_093313_role2access extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('role2access', [
			'role_id' => 'integer NOT NULL',
			'access_id' => 'integer NOT NULL'
		]);

		$this->createIndex('role2access', 'role2access', ['role_id', 'access_id'], true);

		$this->addForeignKey('fk_role2access-role_id', 'role2access', 'role_id', 'role', 'id', 'NO ACTION', 'NO ACTION');
		$this->addForeignKey('fk_role2access-access_id', 'role2access', 'access_id', 'access', 'id', 'NO ACTION', 'NO ACTION');
	}

	public function down()
	{
		echo "m200412_093313_role2access does not support migration down.\n";

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
