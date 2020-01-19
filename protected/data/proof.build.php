<?php
return array(
	'layout' => 'layouts.backend',
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
		'list' => array('id', 'ref_table', 'datatype', 'user_username', 'date_added'),
	),
	'structure' => array(
		'ref_table' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('organization_funding'=>'Company Funding','organization_revenue'=>'Company Revenue', 'organization_status'=>'Company Status', 'idea_rfp'=>'Idea RFP'),
		),
		'datatype' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('string'=>'String','image'=>'Image', 'file'=>'File'),
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		//'legalform_id'=>array( 'relationName'=>'legalform', 'model'=>'Legalform', 'foreignReferAttribute'=>'title'),
		'user_username'=>array( 'relationName'=>'user', 'model'=>'User', 'foreignReferAttribute'=>'username'),
	),
); 
