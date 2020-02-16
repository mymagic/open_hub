<?php
return array(
	'layout' => 'layouts.backend',
	'foreignRefer' => array('key'=>'id', 'title'=>'title'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'industry_code', 'title', 'date_added'),
	),
	'structure' => array(
	),
    // this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'industry_code'=>array( 'relationName'=>'industry', 'model'=>'Industry', 'foreignReferAttribute'=>'title'),
	),
    
	
); 
