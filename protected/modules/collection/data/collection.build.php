<?php

return array(
	'layout' => '/layouts/backend',
	'moduleCode' => 'collection',
	'isAllowMeta' => true,
	'isDeleteDisabled' => false,
	'foreignRefer' => array('key' => 'id', 'title' => 'title'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view, delete',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'title', 'creator_user_id', 'is_active', 'date_modified'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
		'creator_user_id' => array('isHiddenInForm' => true),
		'json_extra' => array('isJson' => true),
	),
	'json' => array(
		'extra' => array(
		),
	),
	'foreignKey' => array(
		'creator_user_id' => array('relationName' => 'creatorUser', 'model' => 'User', 'foreignReferAttribute' => 'username'),
	),
	'many2many' => array(
	),
	'tag' => array(
		'backend' => array(
			'tagTable' => 'tag', 'tagBindingTable' => 'tag2collection', 'modelTableFk' => 'collection_id', 'tagTablePk' => 'id', 'tagTableName' => 'name', 'tagBindingTableTagId' => 'tag_id', 'cacheID' => 'cacheTag2Collection', ),
	),
);
