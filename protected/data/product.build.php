<?php
return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'foreignRefer' => array('key'=>'id', 'title'=>'title'),
	'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update',
	),
	'admin' => array(
		'list' => array('id','title', 'typeof','is_active', 'date_added'),
	),
	'structure' => array(
        'typeof' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array('service'=>'Service','product'=>'Product'),
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization_id'=>array( 'relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
		'product_category_id'=>array( 'relationName'=>'productCategory', 'model'=>'ProductCategory', 'foreignReferAttribute'=>'title'),
	),
); 
