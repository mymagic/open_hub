<?php

class m200412_092423_access extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('access', [
			'id' => 'pk',
			'code' => 'string NOT NULL',
			'title' => 'string NOT NULL',
			'module' => 'string DEFAULT NULL',
			'controller' => 'string NOT NULL',
			'action' => 'string NOT NULL',
			'is_active' => 'integer NOT NULL',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		]);

		$this->alterColumn('access', 'code', 'varchar(100) NOT NULL');
		$this->alterColumn('access', 'title', 'varchar(100) NOT NULL');
		$this->alterColumn('access', 'module', 'varchar(50) DEFAULT NULL');
		$this->alterColumn('access', 'controller', 'varchar(50) NOT NULL');
		$this->alterColumn('access', 'action', 'varchar(50) NOT NULL');

		$this->createIndex('accesscode', 'access', 'code', true);
		$this->createIndex('accesstitle', 'access', 'title', true);
		$this->createIndex('accessroute', 'access', ['module', 'controller', 'action'], true);
	}

	public function down()
	{
		echo "m200412_092423_table_access does not support migration down.\n";

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
