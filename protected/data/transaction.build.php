<?php
return array(
	'layout' => '//layouts/backend',
	'menuTemplate' => array(
		'index'=>'admin',
		'create'=>'admin',
		'update'=>'admin, view',
		'view'=>'admin',
	),
	'admin' => array(
		'list' => array('id', 'vendor', 'txnid', 'amount', 'ref_id', 'status', 'date_modified'),
	),
	'structure' => array(
		'json_payload'=>array('isJson'=>true),
		'json_extra'=>array('isJson'=>true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
	),
	'json'=>array(
		'extra'=>array(
		),
		'payload'=>array(
		)
	),
); 
