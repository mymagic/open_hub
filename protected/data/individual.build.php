<?php
return array(
	'layout' => '//layouts/backend',
	'isDeleteDisabled' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'full_name'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id','full_name', 'is_active', 'date_added'),
	),
	'structure' => array(
		'image_photo' => array
		(
			'resize'=>'500x500', 
			'hints'=>'Image will be automatically resize to 500x500 px.'
		),
		'gender' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('male'=>'Male','female'=>'Female'),
        ),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'state_code'=>array( 'relationName'=>'individual2Emails', 'model'=>'Individual2Email', 'foreignReferAttribute'=>'individual_id'),
	),

	'many2many'=>array(
		'persona'=>array('className'=>'Persona', 'relationName'=>'personas', 'relationTable'=>'persona2individual',
		'linkClassName'=>'Persona2Individual', ),
	),

	'tag'=>array(
		'backend'=>array(
			'tagTable'=>'tag', 'tagBindingTable'=>'tag2individual', 'modelTableFk'=>'individual_id', 'tagTablePk'=>'id', 'tagTableName'=>'name', 'tagBindingTableTagId'=>'tag_id', 'cacheID'=>'cacheTag2Individual'),
	),
); 
