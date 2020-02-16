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
        'list' => array('id', 'table_name', 'ref_id', 'date_modified'),
        'sortDefaultOrder' => 't.id DESC',
    ),
    'structure' => array(
        'json_extra' => array('isJson' => true),
    ),
    'json' => array(
        'extra' => array(
        ),
    ),
    'foreignKey' => array(
        'collection_sub_id' => array('relationName' => 'collectionSub', 'model' => 'CollectionSub', 'foreignReferAttribute' => 'id'),
    ),
    'many2many' => array(
    ),
);
