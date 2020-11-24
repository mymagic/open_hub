
<?php

return array(
	'isDeleteDisabled' => true,
	'isAllowMeta' => true,
	'moduleCode' => 'cv',
	'layout' => 'layouts.backend',
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'slug', 'display_name', 'visibility', 'is_active', 'date_modified'),
	),
	'structure' => array(
		'slug' => array(
			'isUnique' => true,
		),
		'latlong_address' => array('isSpatial' => true),
		'image_avatar' => array(
			'resize' => '320x240',
			'hints' => 'Image will be automatically resize to 320x240 px.'
		),
		'visibility' => array(
			// define enum here, so generator can support database system that dont even support this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('public' => 'Public', 'protected' => 'Protected', 'private' => 'Private'),
		),
		'json_extra' => array('isJson' => true),
		'json_social' => array('isJson' => true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'json' => array(
		'extra' => array(
		),
		'social' => array(
		),
	),
	'spatial' => array(
		'latlong_address_residential' => array(
			'onChangeLinked' => array('text_address_residential')
		),
	),
	'foreignKey' => array(
		'user_id' => array('relationName' => 'user', 'model' => 'User', 'foreignReferAttribute' => 'username'),
		'cv_jobpos_id' => array('relationName' => 'cvJobpos', 'model' => 'CvJobpos', 'foreignReferAttribute' => 'title'),
		'state_code' => array('relationName' => 'state', 'model' => 'State', 'foreignReferAttribute' => 'title'),
		'country_code' => array('relationName' => 'country', 'model' => 'Country', 'foreignReferAttribute' => 'printable_name'),
		//'high_academy_experience_id' => array('relationName' => 'highestAcademyExperience', 'model' => 'CvExperience', 'foreignReferAttribute' => 'title'),
	),
	'foreignRefer' => array('key' => 'id', 'title' => 'display_name'),
	'neo4j' => array(
		'attributes' => array(
			'id' => 'string',
			'display_name' => 'string'
		)
	)
);
