<?php
return array(
	'layout' => 'layouts.backend',
	'moduleCode' => 'event',
	'isAllowMeta' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'organization_code'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'event_code', 'organzation_code', 'department'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
	),
    'foreignKey' => array(
		'event_code'=>array( 'relationName'=>'event', 'model'=>'Event', 'foreignReferAttribute'=>'title'),
		'organization_code'=>array( 'relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
	),
); 
