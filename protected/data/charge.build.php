<?php

return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'charge_to', 'title', 'amount', 'date_expired', 'status', 'is_active'),
	),
	'structure' => array(
		'code' => array(
			'isUnique' => true,
			'isUUID' => true,
		),
		// 'new','pending','paid','cancel','expired'
		'status' => array(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('new' => 'New', 'pending' => 'Pending', 'paid' => 'Paid', 'cancel' => 'Cancel', 'expired' => 'Expired'),
		),
		'charge_to' => array(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('organization' => 'Organization', 'email' => 'User Email'),
		),
		'json_extra' => array('isJson' => true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		//'sample_group_id'=>array( 'relationName'=>'sampleGroup', 'model'=>'SampleGroup', 'foreignReferAttribute'=>'title_en'),
		//'sample_zone_code'=>array( 'relationName'=>'sampleZone', 'model'=>'SampleZone', 'foreignReferAttribute'=>'label'),
	),
	'json' => array(
		'extra' => array(
		)
	),
);
