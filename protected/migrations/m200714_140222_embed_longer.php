<?php

class m200714_140222_embed_longer extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('embed', 'code', 'VARCHAR(128)');
		$this->alterColumn('embed', 'html_content_en', 'LONGTEXT NULL');
		$this->alterColumn('embed', 'html_content_ms', 'LONGTEXT NULL');
		$this->alterColumn('embed', 'html_content_zh', 'LONGTEXT NULL');
	}

	public function down()
	{
		echo "m200714_140222_embed_longer does not support migration down.\n";

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
