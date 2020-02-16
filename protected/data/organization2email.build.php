<?php
return array(
	'layout' => 'layouts.backend',
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
		'list' => array('id','organization_id', 'user_email', 'date_added'),
	),
	'structure' => array(
		'status' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('approve'=>'Approve','reject'=>'Reject','pending'=>'Pending'),
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization_id'=>array('relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
		'user_email'=>array('relationName'=>'user', 'model'=>'User', 'foreignReferAttribute'=>'username'),
	),
); 
