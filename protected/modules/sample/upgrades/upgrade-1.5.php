<?php

function upgrade_module_1_5($about)
{
	$return = '';

	$migration = Yii::app()->db->createCommand();
	$return .= "Add column `sample_zone_id` to `sample` table\n";

	$migration->addColumn('sample', 'sample_zone_id', 'int(11) NULL AFTER `sample_zone_code`');
	$migration->createIndex('sample_zone_id', 'sample', 'sample_zone_id', false);
	$migration->addForeignKey('fk_sample-sample_zone_id', 'sample', 'sample_zone_id', 'sample_zone', 'id', 'CASCADE', 'CASCADE');

	// update existing record to set `sample_zone_id` base on current `sample_zone_code`
	$sql = 'UPDATE `sample` as t LEFT JOIN `sample_zone` as f ON t.sample_zone_code=f.code SET t.sample_zone_id=f.id';
	Yii::app()->db->createCommand($sql)->execute();

	$return .= "Upgraded to version 1.5\n";

	return $return;
}
