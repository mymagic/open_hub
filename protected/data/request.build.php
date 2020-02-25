<?php

return array(
	'layout' => 'layouts.backend',
	'moduleCode' => '',
	'isAllowMeta' => true,
	'foreignRefer' => array('key' => 'id', 'title' => 'title'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'user_id', 'type_code', 'title', 'is_active', 'status', 'date_added', 'date_modified'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
		'status' => array(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			// 'new','pending','processing','success','cancel','fail'
			'isEnum' => true, 'enumSelections' => array(
				'new' => 'New',
				'pending' => 'Pending',
				'processing' => 'Processing',
				'success' => 'Success',
				'cancel' => 'Cancel',
				'fail' => 'Fail',
			),
		),
		'json_extra' => array('isJson' => true),
		'json_data' => array('isJson' => true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'json' => array(
		'extra' => array(
		),
		'data' => array(
		),
	),
	'spatial' => array(
	),
	'foreignKey' => array(
		'user_id' => array('relationName' => 'user', 'model' => 'User', 'foreignReferAttribute' => 'username'),
	),
);
