<?php

function upgrade_module_1_2($about)
{
	$migration = Yii::app()->db->createCommand();
	$migration->addColumn('form', 'json_event_mapping', 'longtext NULL');

	return "Upgraded to version 1.2\n";
}
