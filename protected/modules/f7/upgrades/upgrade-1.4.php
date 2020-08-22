<?php

function upgrade_module_1_4($about)
{
	$migration = Yii::app()->db->createCommand();
	$migration->addColumn('form', 'json_extra', 'longtext NULL');
	$migration->addColumn('form_submission', 'json_extra', 'longtext NULL');
	$migration->addColumn('form_submission', 'process_by', 'varchar(128) NULL');
	$migration->addColumn('form_submission', 'date_processed', 'integer(11) NULL');

	return "Upgraded to version 1.4\n";
}
