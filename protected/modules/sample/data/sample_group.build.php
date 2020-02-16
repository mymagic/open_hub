<?php
return array(
	'isDeleteDisabled' => true,
	'layout' => 'layouts.backend',
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'title_en', 'date_added', 'date_modified'),
	),
	'structure' => array(

	),
	'foreignRefer' => array('key'=>'id', 'title'=>'title_en'),
); 
