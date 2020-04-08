<?php

function upgrade_module_1_2($about)
{
	$migration = Yii::app()->db->createCommand();
	$migration->createTable('eventbrite_organization_webhook', [
		'id' => 'pk',
		'organization_code' => 'varchar(64) NOT NULL ',
		'as_role_code' => "varchar(64) NOT NULL DEFAULT 'owner'",
		'eventbrite_account_id' => 'varchar(64) NOT NULL',
		'eventbrite_oauth_secret' => 'varchar(255) NULL',
		'json_extra' => 'text NULL',
		'is_active' => 'tinyint(1) NOT NULL DEFAULT 1',
		'date_added' => 'integer',
		'date_modified' => 'integer',
	]);

	$migration->createIndex('organization_code', 'eventbrite_organization_webhook', 'organization_code', false);
	$migration->createIndex('eventbrite_account_id', 'eventbrite_organization_webhook', 'eventbrite_account_id', false);
	$migration->createIndex('eventbrite_organization_webhook', 'eventbrite_organization_webhook', array('organization_code', 'eventbrite_account_id'), true);

	$migration->addForeignKey('fk_eventbrite_organization_webhook-organization_code', 'eventbrite_organization_webhook', 'organization_code', 'organization', 'code', 'CASCADE', 'CASCADE');

	return "Upgraded to version 1.2\n";
}
