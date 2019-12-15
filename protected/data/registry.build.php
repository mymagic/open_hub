<?php
return array(
    'layout' => '//layouts/backend',
	'isDeleteDisabled' => true,
    'foreignRefer' => array('key'=>'code', 'title'=>'code'),
    'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'code', 'the_value', 'date_modified'),
	),
	'structure' => array(
		'code' => array
		(
			'isUnique'=>true,
			'isUUID'=>false,
		),
	),
); 
