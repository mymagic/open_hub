<?php

return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'foreignRefer' => array('key' => 'id', 'title' => 'id'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'meta_structure_id', 'ref_id', 'date_added'),
	),
	'structure' => array(
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		//'legalform_id'=>array( 'relationName'=>'legalform', 'model'=>'Legalform', 'foreignReferAttribute'=>'title'),
	),
);
