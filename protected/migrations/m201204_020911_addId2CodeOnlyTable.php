<?php

class m201204_020911_addId2CodeOnlyTable extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
	}
	*/

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		// drop and rename `event_id` index to `event_code` for `event_owner` table as it is wrongly name, this required droping the foreign key too to beable to drop the index to rename
		$this->dropForeignKey('event_owner_ibfk_1', 'event_owner');
		$this->dropIndex('event_id', 'event_owner');
		$this->createIndex('event_code', 'event_owner', 'event_code', false);
		$this->addForeignKey('fk_event_owner-event_code', 'event_owner', 'event_code', 'event', 'code', 'CASCADE', 'CASCADE');

		// drop and rename `organization_id` index to `organization_code` for `event_owner` table as it is wrongly name, this required droping the foreign key too to beable to drop the index to rename
		$this->dropForeignKey('event_owner_ibfk_2', 'event_owner');
		$this->dropIndex('organization_id', 'event_owner');
		$this->createIndex('organization_code', 'event_owner', 'organization_code', false);
		$this->addForeignKey('fk_event_owner-organization_code', 'event_owner', 'organization_code', 'organization', 'code', 'CASCADE', 'CASCADE');

		// add `organization_id` to `event_owner` table
		$this->_addColumn('event_owner', 'organization_id', 'int(11) NULL AFTER `organization_code`');
		$this->createIndex('organization_id', 'event_owner', 'organization_id', false);
		$this->addForeignKey('fk_event_owner-organization_id', 'event_owner', 'organization_id', 'organization', 'id', 'CASCADE', 'CASCADE');
		// update existing record to set `organization_id` base on current `organization_code`
		$sql = 'UPDATE `event_owner` as t LEFT JOIN `organization` as f ON t.organization_code=f.code SET t.organization_id=f.id';
		$this->execute($sql);

		// add `event_id` to `event_owner` table
		$this->_addColumn('event_owner', 'event_id', 'int(11) NULL AFTER `event_code`');
		$this->createIndex('event_id', 'event_owner', 'event_id', false);
		$this->addForeignKey('fk_event_owner-event_id', 'event_owner', 'event_id', 'event', 'id', 'CASCADE', 'CASCADE');
		// update existing record to set `event_id` base on current `event_code`
		$sql = 'UPDATE `event_owner` as t LEFT JOIN `event` as f ON t.event_code=f.code SET t.event_id=f.id';
		$this->execute($sql);

		// drop and rename `event_group_id` index to `event_group_code` for `event` table as it is wrongly name, this required droping the foreign key too to beable to drop the index to rename
		$this->dropForeignKey('event_ibfk_1', 'event');
		$this->dropIndex('event_group_id', 'event');
		$this->createIndex('event_group_code_2', 'event', 'event_group_code', false);
		$this->addForeignKey('event-event_group_code', 'event', 'event_group_code', 'event_group', 'code', 'CASCADE', 'CASCADE');

		// add `event_group_id` to `event` table
		$this->_addColumn('event', 'event_group_id', 'int(11) NULL AFTER `event_group_code`');
		$this->createIndex('event_group_id', 'event', 'event_group_id', false);
		$this->addForeignKey('fk_event-event_group_id', 'event', 'event_group_id', 'event_group', 'id', 'CASCADE', 'CASCADE');
		// update existing record to set `event_group_id` base on current `event_code`
		$sql = 'UPDATE `event` as t LEFT JOIN `event_group` as f ON t.event_group_code=f.code SET t.event_group_id=f.id';
		$this->execute($sql);

		// add `user_id` to `milestone` table
		$this->_addColumn('milestone', 'user_id', 'int(11) NULL AFTER `username`');
		$this->createIndex('user_id', 'milestone', 'user_id', false);
		$this->addForeignKey('fk_milestone-user_id', 'milestone', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
		// update existing record to set `user_id` base on current `username`
		$sql = 'UPDATE `milestone` as t LEFT JOIN `user` as f ON t.username=f.username SET t.user_id=f.id';
		$this->execute($sql);

		// add `industry_id` to `industry_keyword` table
		$this->_addColumn('industry_keyword', 'industry_id', 'int(11) NULL AFTER `industry_code`');
		$this->createIndex('industry_id', 'industry_keyword', 'industry_id', false);
		$this->addForeignKey('fk_industry_keyword-industry_id', 'industry_keyword', 'industry_id', 'industry', 'id', 'CASCADE', 'CASCADE');
		// update existing record to set `industry_id` base on current `industry_code`
		$sql = 'UPDATE `industry_keyword` as t LEFT JOIN `industry` as f ON t.industry_code=f.code SET t.industry_id=f.id';
		$this->execute($sql);

		// add `organization_id` to `individual_organization` table
		$this->_addColumn('individual_organization', 'organization_id', 'int(11) NULL AFTER `organization_code`');
		$this->createIndex('organization_id', 'individual_organization', 'organization_id', false);
		$this->addForeignKey('fk_individual_organization-organization_id', 'individual_organization', 'organization_id', 'organization', 'id', 'CASCADE', 'CASCADE');
		// update existing record to set `organization_id` base on current `organization_code`
		$sql = 'UPDATE `individual_organization` as t LEFT JOIN `organization` as f ON t.organization_code=f.code SET t.organization_id=f.id';
		$this->execute($sql);
	}

	public function safeDown()
	{
		echo "m201204_020911_addId2CodeOnlyTable does not support migration down.\n";

		return false;
	}

	public function _addColumn($table, $column, $type)
	{
		// Fetch the table schema
		$table_to_check = Yii::app()->db->schema->getTable($table);
		if (!isset($table_to_check->columns[$column])) {
			$this->addColumn($table, $column, $type);
		}
	}
}
