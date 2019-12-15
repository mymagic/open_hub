<?php
return array(
	'layout' => '//layouts/backend',
	'foreignRefer' => array('key'=>'code', 'title'=>'title'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'code', 'title', 'country_code'),
	),
	'structure' => array(
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'country_code'=>array( 'relationName'=>'country', 'model'=>'Country', 'foreignReferAttribute'=>'printable_name'),
	),
); 
