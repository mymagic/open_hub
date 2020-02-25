<?php

return array(
	'layout' => 'layouts.backend',
	'isDeleteDisabled' => true,
	'moduleCode' => '',
	'isAllowMeta' => true,
	'foreignRefer' => array('key' => 'id', 'title' => 'organization_id'),
	'menuTemplate' => array(
		'index' => 'admin, create',
		'admin' => 'create',
		'create' => 'admin',
		'update' => 'admin, create, view, delete',
		'view' => 'admin, create, update, delete',
	),
	'admin' => array(
		'list' => array('id', 'event_code', 'event_vendor_code', 'organization_id', 'as_role_code'),
		'sortDefaultOrder' => 't.id DESC',
	),
	'structure' => array(
	),
	'json' => array(
	),

	'foreignKey' => array(
		'event_code' => array('relationName' => 'event', 'model' => 'Event', 'foreignReferAttribute' => 'title'),
		'organization_id' => array('relationName' => 'organization', 'model' => 'Organization', 'foreignReferAttribute' => 'title'),
	),
);
