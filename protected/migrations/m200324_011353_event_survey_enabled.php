<?php

class m200324_011353_event_survey_enabled extends CDbMigration
{
	public function up()
	{
		$this->_addColumn('event', 'is_survey_enabled', 'tinyint(1) DEFAULT 1');
		$this->createIndex('is_survey_enabled', 'event', 'is_survey_enabled', false);
	}

	public function down()
	{
		echo "m200324_011353_event_survey_enabled does not support migration down.\n";

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
