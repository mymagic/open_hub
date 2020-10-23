
<?php

return array(
	'isDeleteDisabled' => true,
	'isAllowMeta' => true,
	'moduleCode' => 'cv',
	'layout' => 'layouts.backend',
	'foreignRefer' => array('key' => 'id', 'title' => 'title'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'genre', 'title', 'is_active', 'date_modified'),
	),
	'structure' => array(
		'genre' => array(
			// define enum here, so generator can support database system that dont even support this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('job' => 'Job', 'study' => 'Study', 'project' => 'Project', 'others' => 'Others'),
		),
		'latlong_address' => array('isSpatial' => true),
		'month_start' => array(
			// define enum here, so generator can support database system that dont even support this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'),
		),
		'month_end' => array(
			// define enum here, so generator can support database system that dont even support this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'),
		),
		'json_extra' => array('isJson' => true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'json' => array(
		'extra' => array(
		),
	),
	'spatial' => array(
		'latlong_address' => array(
			'onChangeLinked' => array('full_address')
		),
	),
	'foreignKey' => array(
		'cv_portfolio_id' => array('relationName' => 'cvPortfolio', 'model' => 'CvPortfolio', 'foreignReferAttribute' => 'display_name'),
		'state_code' => array('relationName' => 'state', 'model' => 'State', 'foreignReferAttribute' => 'title'),
		'country_code' => array('relationName' => 'country', 'model' => 'Country', 'foreignReferAttribute' => 'printable_name'),
	),
);
