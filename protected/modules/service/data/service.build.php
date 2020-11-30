
<?php

return array(
	'isDeleteDisabled' => true,
	'isAllowMeta' => true,
	'moduleCode' => 'service',
	'layout' => 'layouts.backend',
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'slug', 'title', 'text_oneliner', 'is_bookmarkable', 'is_active', 'date_modified'),
	),
	'structure' => array(
		'slug' => array(
			'isUnique' => true,
		),
	),
	'foreignRefer' => array('key' => 'id', 'title' => 'title'),
);
