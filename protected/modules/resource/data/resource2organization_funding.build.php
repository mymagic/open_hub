<?php
return array(
	'layout' => '//layouts/backend',
	'isDeleteDisabled' => false,
	'foreignRefer' => array('key'=>'id', 'title'=>'id'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id','resource_id', 'organization_funding_id', 'as_role_code'),
	),
	'structure' => array(
		
	),
	'json'=>array(
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'resource_id'=>array('relationName'=>'resource', 'model'=>'Resource', 'foreignReferAttribute'=>'title'),
        
        'organization_funding_id'=>array('relationName'=>'organizationFunding', 'model'=>'OrganizationFunding', 'foreignReferAttribute'=>'id'),
	),
); 
