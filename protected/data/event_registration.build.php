<?php
return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'moduleCode' => '',
	'isAllowMeta' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'email'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'event_code', 'registration_code', 'email', 'full_name', 'is_attended'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
		//'json_extra'=>array('isJson'=>true),
		'json_original'=>array('isJson'=>true),
		'gender' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('male'=>'Male','female'=>'Female','unknown'=>'Unknown'),
        ),
	),
	'json'=>array(
		'original'=>array(
		),
	),
	
    'foreignKey' => array(
		'event_code'=>array( 'relationName'=>'event', 'model'=>'Event', 'foreignReferAttribute'=>'title'),
	),
); 
