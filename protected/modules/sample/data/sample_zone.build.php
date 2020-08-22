<?php

return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		//'list' => array('id', 'title_en', 'sample_group_id', 'sample_zone_code', 'image_main', 'gender', 'ordering', 'is_active', 'date_posted'),
	),
	'structure' => array(
		'code' => array(
			'isUnique' => true,
		),
	),
	'foreignRefer' => array('key' => 'code', 'title' => 'label'),
);
