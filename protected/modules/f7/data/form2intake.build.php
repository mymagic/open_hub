<?php

return array(
	'layout' => '//layouts/backend',
	'isDeleteDisabled' => false,
	'foreignRefer' => array('key' => 'id', 'title' => 'id'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'intake_id', 'form_id', 'is_primary', 'is_active', 'ordering'),
	),
	'structure' => array(
		'json_extra' => array('isJson' => true),
	),
	'json' => array(
		'extra' => array(
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'intake_id' => array('relationName' => 'intake', 'model' => 'Intake', 'foreignReferAttribute' => 'title'),

		'form_id' => array('relationName' => 'form', 'model' => 'Form', 'foreignReferAttribute' => 'title'),
	),
);
