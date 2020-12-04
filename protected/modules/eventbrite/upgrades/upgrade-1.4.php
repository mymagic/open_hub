<?php

function upgrade_module_1_4($about)
{
	$return = '';

	$migration = Yii::app()->db->createCommand();
	$return .= "Add column `organization_id` to `eventbrite_organization_webhook` table\n";

	$migration->addColumn('eventbrite_organization_webhook', 'organization_id', 'int(11) NULL AFTER `organization_code`');
	$migration->createIndex('organization_id', 'eventbrite_organization_webhook', 'organization_id', false);
	$migration->addForeignKey('fk_eventbrite_organization_webhook-organization_id', 'eventbrite_organization_webhook', 'organization_id', 'organization', 'id', 'CASCADE', 'CASCADE');

	// update existing record to set `organization_id` base on current `sample_zone_code`
	$sql = 'UPDATE `eventbrite_organization_webhook` as t LEFT JOIN `organization` as f ON t.organization_code=f.code SET t.organization_id=f.id';
	Yii::app()->db->createCommand($sql)->execute();

	$return .= "Upgraded to version 1.4\n";

	return $return;
}
