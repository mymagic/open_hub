<?php

class m200402_083859_event_owner_role extends CDbMigration
{
	public function up()
	{
		$this->_addColumn('event_owner', 'as_role_code', "varchar(64) NOT NULL DEFAULT 'owner'");
		$this->createIndex('as_role_code', 'event_owner', 'as_role_code', false);
	}

	public function down()
	{
		echo "m200402_083859_event_owner_role does not support migration down.\n";

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

	public function _addColumn($table, $column, $type)
	{
		// Fetch the table schema
		$table_to_check = Yii::app()->db->schema->getTable($table);
		if (!isset($table_to_check->columns[$column])) {
			$this->addColumn($table, $column, $type);
		}
	}
}
