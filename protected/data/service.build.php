<?php
return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'title'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id','slug', 'title','is_bookmarkable', 'is_active'),
	),
	'structure' => array(
		'slug' => array
		(
			'isUnique'=>true,
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment

); 
