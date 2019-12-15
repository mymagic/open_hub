<?php
return array(
	'layout' => '//layouts/backend',
	'moduleCode' => '',
	'isAllowMeta' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'title'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'slug', 'title', 'image_cover', 'date_started', 'is_active'),
		'sortDefaultOrder' => 't.title ASC',
	),
	'structure' => array(
        'code' => array
		(
            'isUnique'=>true,
            'isUUID'=>true,
        ),
        'slug' => array
		(
			'isUnique'=>true,
        ),
		'json_extra'=>array('isJson'=>true),
	),
    // this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
    'json'=>array(
		'extra'=>array(
		),
    ),
); 
