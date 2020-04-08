<?php

return array(
	'layout' => 'layouts.backend',
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'organization_code', 'eventbrite_account_id', 'as_role_code', 'is_active', 'date_modified'),
	),
	'structure' => array(
		'json_extra' => array('isJson' => true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization' => array('relationName' => 'organization', 'model' => 'Organization', 'foreignReferAttribute' => 'title'),
	),
	'json' => array(
		'extra' => array(
			'xxx' => array('label' => 'XXX'),
			'yyy' => array('label' => 'YYY'),
		)
	),
	'foreignRefer' => array('key' => 'id', 'title' => 'eventbrite_account_id'),
);
