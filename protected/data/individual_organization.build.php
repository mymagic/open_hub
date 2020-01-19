<?php
return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'moduleCode' => '',
	'isAllowMeta' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'organization_code'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view, delete',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'individual_id', 'organization_code', 'as_role_code', 'job_position'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
		
	),
	'json'=>array(
		
	),
	
    'foreignKey' => array(
		'individual_id'=>array( 'relationName'=>'individual', 'model'=>'Individual', 'foreignReferAttribute'=>'full_name'),
		'organization_code'=>array( 'relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
	),
); 
