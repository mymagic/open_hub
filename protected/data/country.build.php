<?php

return array(
	'layout' => 'layouts.backend',
	'foreignRefer' => array('key' => 'code', 'title' => 'printable_name'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'code', 'printable_name'),
	),
	'structure' => array(
		'code' => array(
			'isUnique' => true,
		),
	),
);
