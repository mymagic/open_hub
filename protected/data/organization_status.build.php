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
	'foreignRefer' => array('key'=>'id', 'title'=>'status'),
	'admin' => array(
		'list' => array('id','organization_id', 'date_reported', 'status', 'source'),
	),
	'structure' => array(
		'status' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('active'=>'Active','inactive'=>'Inactive', 'exited'=>'Exited'),
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization_id'=>array('relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
	),
); 
