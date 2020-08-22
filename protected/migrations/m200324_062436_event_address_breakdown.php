<?php

class m200324_062436_event_address_breakdown extends CDbMigration
{
	public function up()
	{
		$this->_addColumn('event', 'address_line1', 'varchar(128) NULL');
		$this->_addColumn('event', 'address_line2', 'varchar(128) NULL');
		$this->_addColumn('event', 'address_zip', 'varchar(16) NULL');
		$this->_addColumn('event', 'address_city', 'varchar(128) NULL');
		$this->_addColumn('event', 'address_state', 'varchar(128) NULL');

		$this->createIndex('address_state', 'event', 'address_state', false);
		$this->createIndex('address_city', 'event', 'address_city', false);
		$this->createIndex('address_zip', 'event', 'address_zip', false);
	}

	public function down()
	{
		echo "m200324_062436_event_address_breakdown does not support migration down.\n";

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
