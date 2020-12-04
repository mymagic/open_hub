<?php

function upgrade_module_1_5($about)
{
	$return = '';

	$migration = Yii::app()->db->createCommand();

	//
	$return .= "Add column `form_id` to `form_submission` table\n";

	$migration->addColumn('form_submission', 'form_id', 'INT( 11 ) NULL AFTER `form_code`');
	$migration->createIndex('form_id', 'form_submission', 'form_id', false);
	$migration->addForeignKey('fk_form_submission-form_id', 'form_submission', 'form_id', 'form', 'id', 'CASCADE', 'CASCADE');

	// update existing record to set `form_id` base on current `form_code`
	$sql = 'UPDATE `form_submission` as s LEFT JOIN `form` as f ON f.code=s.form_code SET s.form_id=f.id';
	Yii::app()->db->createCommand($sql)->execute();

	$return .= "Upgraded to version 1.5\n";

	return $return;
}
