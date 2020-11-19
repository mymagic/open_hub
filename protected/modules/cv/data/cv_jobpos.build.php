
<?php

return array(
	'isDeleteDisabled' => false,
	'moduleCode' => 'cv',
	'layout' => 'layouts.backend',
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'title', 'cv_jobpos_group_id', 'is_active', 'date_added', 'date_modified'),
	),
	'structure' => array(
		'json_extra' => array('isJson' => true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'json' => array(
		'extra' => array(
		),
	),
	'foreignKey' => array(
		'cv_jobpos_group_id' => array('relationName' => 'cvJobposGroup', 'model' => 'CvJobposGroup', 'foreignReferAttribute' => 'title'),
	),
	'foreignRefer' => array('key' => 'id', 'title' => 'title'),
	'neo4j' => array(
		'attributes' => array(
			'id' => 'string',
			'title' => 'string'
		)
	)
);
