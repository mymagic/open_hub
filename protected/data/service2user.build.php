<?php
return array(
	'layout' => '//layouts/backend',
	'isDeleteDisabled' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'user_email'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('service_id', 'user_id'),
	),
	'structure' => array(
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'service_id'=>array('relationName'=>'service', 'model'=>'Service', 'foreignReferAttribute'=>'title'),
		'user_id'=>array('relationName'=>'user', 'model'=>'User', 'foreignReferAttribute'=>'username'),
	),
); 
