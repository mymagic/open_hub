<?php
return array(
	'layout' => 'layouts.backend',
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'title_en', 'sample_group_id', 'sample_zone_code', 'image_main', 'gender', 'ordering', 'is_active', 'date_posted'),
	),
	'structure' => array(
		'code' => array
		(
			'isUnique'=>true,
		),
		'gender' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('male'=>'Male','female'=>'Female','secret'=>'Secret'),
		),
		'image_main' => array
		(
			'resize'=>'320x240', 
			'hints'=>'Image will be automatically resize to 320x240 px.'
		),
		// in order for it to work as expected, this column must have a double database field
		'ordering' => array
		(
		),
		'json_extra'=>array('isJson'=>true),
		'csv_keyword'=>array('isCsv'=>true),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'sample_group_id'=>array( 'relationName'=>'sampleGroup', 'model'=>'SampleGroup', 'foreignReferAttribute'=>'title_en'),
		'sample_zone_code'=>array( 'relationName'=>'sampleZone', 'model'=>'SampleZone', 'foreignReferAttribute'=>'label'),
	),
	'json'=>array(
		'extra'=>array(
			'xxx'=>array('label'=>'XXX'),
			'yyy'=>array('label'=>'YYY'),
		)
	),
	'tag'=>array(
		'skillsets'=>array(
			'tagTable'=>'tag', 'tagBindingTable'=>'tag2sample', 'modelTableFk'=>'sample_id', 'tagTablePk'=>'id', 'tagTableName'=>'name', 'tagBindingTableTagId'=>'tag_id', 'cacheID'=>'cacheTagSample'),
	),
	'csv'=>array('csv_keyword'),
); 
