<?php
return array(
	'layout' => '//layouts/backend',
	'isDeleteDisabled' => false,
	'foreignRefer' => array('key'=>'id', 'title'=>'title'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'title', 'preset_code', 'is_star', 'date_modified'),
	),
	'structure' => array(
		'username' => array('isHiddenInForm'=>true),
		'json_target'=>array('isJson'=>true),
		'json_value'=>array('isJson'=>true),
		'json_extra'=>array('isJson'=>true),
    ),
    'json'=>array(
		'target'=>array(
		),
		'value'=>array(
		),
		'extra'=>array(
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization_id'=>array( 'relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
		'username'=>array( 'relationName'=>'username', 'model'=>'User', 'foreignReferAttribute'=>'username'),
	),
); 
