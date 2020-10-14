<?php

class m201009_075213_classification extends CDbMigration
{
	public function up()
	{
		$this->createTable('classification', array(
			'id' => 'pk',
			'slug' => 'string NOT NULL',
			'code' => 'string NOT NULL',
			'title_en' => 'string NOT NULL',
			'title_ms' => 'string NOT NULL',
			'text_short_description_en' => 'text NULL',
			'text_short_description_ms' => 'text NULL',
			'is_active' => 'boolean NOT NULL DEFAULT 1',
			'date_added' => 'integer',
			'date_modified' => 'integer',
		));

		$this->alterColumn('classification', 'code', 'varchar(64) NOT NULL');
		$this->alterColumn('classification', 'title_en', 'varchar(100) NOT NULL');
		$this->alterColumn('classification', 'title_ms', 'varchar(100) NOT NULL');

		$this->createIndex('slug', 'classification', 'slug', true);
		$this->createIndex('code', 'classification', 'code', true);
		$this->createIndex('is_active', 'classification', 'is_active', false);

		$this->createTable('classification2organization', array(
			'classification_id' => 'integer NOT NULL',
			'organization_id' => 'integer NOT NULL',
		));

		// createIndex(string $name, string $table, string|array $columns, boolean $unique=false)
		$this->createIndex('classification_id', 'classification2organization', 'classification_id', false);
		// createIndex(string $name, string $table, string|array $columns, boolean $unique=false)
		$this->createIndex('organization_id', 'classification2organization', 'organization_id', false);
		// createIndex(string $name, string $table, string|array $columns, boolean $unique=false)
		$this->createIndex('classification2organization', 'classification2organization', array('classification_id', 'organization_id'), true);

		// addForeignKey(string $name, string $table, string|array $columns, string $refTable, string|array $refColumns, string $delete=NULL, string $update=NULL)
		$this->addForeignKey('fk_classification2organization-classification_id', 'classification2organization', 'classification_id', 'classification', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_classification2organization-organization_id', 'classification2organization', 'organization_id', 'organization', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m201009_075213_classification does not support migration down.\n";

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
