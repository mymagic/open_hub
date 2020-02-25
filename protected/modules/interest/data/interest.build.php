<?php

return array(
	'layout' => '/layouts/backend',
	'moduleCode' => 'interest',
	'isAllowMeta' => false,
	'isDeleteDisabled' => false,
	'foreignRefer' => array('key' => 'id'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view, delete',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'user_id', 'is_active', 'date_modified'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
		'user_id' => array('isHiddenInForm' => true),
		'json_extra' => array('isJson' => true),
	),
	'json' => array(
		'extra' => array(),
	),
	'foreignKey' => array(
		'user_id' => array('relationName' => 'user', 'model' => 'User', 'foreignReferAttribute' => 'username'),
	),
	'many2many' => array(
		// target industry
		'industry' => array('className' => 'Industry', 'relationName' => 'industries', 'relationTable' => 'interest_user2industry'),
		'sdg' => array('className' => 'Sdg', 'relationName' => 'sdgs', 'relationTable' => 'interest_user2sdg'),
		'cluster' => array('className' => 'Cluster', 'relationName' => 'clusters', 'relationTable' => 'interest_user2cluster'),
		'startupStage' => array('className' => 'StartupStage', 'relationName' => 'startupStages', 'relationTable' => 'interest_user2startup_stage'),
	)
);
