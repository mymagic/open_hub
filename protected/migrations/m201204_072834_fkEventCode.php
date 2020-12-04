<?php

class m201204_072834_fkEventCode extends CDbMigration
{
	/*
	public function up()
	{
	}

	public function down()
	{

	}
	*/

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addForeignKey('fk_event_organization-event_code', 'event_organization', 'event_code', 'event', 'code', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		echo "m201204_072834_fkEventCode does not support migration down.\n";

		return false;
	}
}
