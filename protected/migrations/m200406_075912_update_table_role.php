<?php

class m200406_075912_update_table_role extends CDbMigration
{
	public function up()
	{
		$this->_addColumn('role', 'is_access_backend', 'tinyint(1) NOT NULL DEFAULT 0 AFTER `title`');
		$this->_addColumn('role', 'is_access_sensitive_data', 'tinyint(1) NOT NULL DEFAULT 0 AFTER `is_access_backend`');
		$this->_addColumn('role', 'is_active', 'tinyint(1) NOT NULL DEFAULT 1 AFTER `is_access_sensitive_data`');

		$this->createIndex('is_access_backend', 'role', 'is_access_backend', false);
		$this->createIndex('is_access_sensitive_data', 'role', 'is_access_sensitive_data', false);
		$this->createIndex('is_active', 'role', 'is_active', false);
	}

	public function down()
	{
		echo "m200406_075912_update_table_role does not support migration down.\n";

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
	//*/

	public function _addColumn($table, $column, $type)
	{
		// Fetch the table schema
		$table_to_check = Yii::app()->db->schema->getTable($table);
		if (!isset($table_to_check->columns[$column])) {
			$this->addColumn($table, $column, $type);
		}
	}
}
