<?php

return array(
	'layout' => '/layouts/backend',
	'moduleCode' => 'collection',
	'isAllowMeta' => true,
	'isDeleteDisabled' => true,
	'foreignRefer' => array('key' => 'id', 'title' => 'title'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view',
		'view' => 'admin, create, update',
	),
	'admin' => array(
		'list' => array('id', 'title', 'collection_id', 'date_modified'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
		'collection_id' => array('isHiddenInForm' => true),
		'json_extra' => array('isJson' => true),
	),
	'json' => array(
		'extra' => array(
		),
	),
	'foreignKey' => array(
		'collection_id' => array('relationName' => 'collection', 'model' => 'Collection', 'foreignReferAttribute' => 'id'),
	),
	'many2many' => array(
	),
);
