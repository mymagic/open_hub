<?php

class m201116_070657_rename_column_merge_history extends CDbMigration
{
	public function up()
	{
		// admin_code to user_id
		$this->renameColumn('individual_merge_history', 'admin_code', 'user_id');
		$this->renameColumn('organization_merge_history', 'admin_code', 'user_id');
	}

	public function down()
	{
		echo "m201116_070657_rename_column_merge_history does not support migration down.\n";

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
