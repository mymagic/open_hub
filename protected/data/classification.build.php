<?php

return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => false,
	'foreignRefer' => array('key' => 'id', 'title' => 'title_en'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'slug', 'title_en', 'is_active', 'date_added'),
	),
	'structure' => array(
		'code' => array(
			'isUnique' => true,
			'isUUID' => true,
		),
		'slug' => array(
			'isUnique' => true,
			'isUUID' => false,
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		//'state_code'=>array( 'relationName'=>'state', 'model'=>'State', 'foreignReferAttribute'=>'title'),
	),
);
