<?php
return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => false,
    'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'foreignRefer' => array('key'=>'id', 'title'=>'amount'),
	'admin' => array(
		'list' => array('id','organization_id', 'year_reported', 'amount', 'source'),
	),
	'structure' => array(
		
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization_id'=>array('relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
	),
); 
