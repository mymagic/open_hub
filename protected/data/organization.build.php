<?php

return array(
	'layout' => 'layouts.backend',
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
		'list' => array('id', 'title', 'ordering', 'is_active', 'date_added'),
	),
	'structure' => array(
		'code' => array(
			'isUnique' => true,
			'isUUID' => true,
		),
		'image_logo' => array(
			'resize' => '500x500',
			'hints' => 'Image will be automatically resize to 500x500 px.'
		),

		// in order for it to work as expected, this column must have a double database field
		'ordering' => array(
		)
	),
	'spatial' => array(
		'latlong' => array(
			'onChangeLinked' => array('full_address')
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'legalform_id' => array('relationName' => 'legalform', 'model' => 'Legalform', 'foreignReferAttribute' => 'title'),
	),
	'tag' => array(
		'backend' => array(
			'tagTable' => 'tag', 'tagBindingTable' => 'tag2organization', 'modelTableFk' => 'organization_id', 'tagTablePk' => 'id', 'tagTableName' => 'name', 'tagBindingTableTagId' => 'tag_id', 'cacheID' => 'cacheTag2Organization'),
	),
);
