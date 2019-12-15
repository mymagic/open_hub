<?php

return array(
    'layout' => '//layouts/backend',
    'menuTemplate' => array(
        'index' => 'admin, create',
        'admin' => 'create',
        'create' => 'admin',
        'update' => 'admin, create, view',
        'view' => 'admin, create, update, delete',
    ),
    'foreignRefer' => array('key' => 'id', 'title' => 'title_en'),
    'admin' => array(
        'list' => array('id', 'path_pattern', 'title_en', 'is_active', 'ordering'),
    ),
    'structure' => array(
        // in order for it to work as expected, this column must have a double database field
        'ordering' => array(
        ),
        'json_meta' => array('isJson' => true),
        'json_extra' => array('isJson' => true),
    ),
    // this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
    'foreignKey' => array(
    ),
    'json' => array(
        'extra' => array(
        ),
        'meta' => array(
        ),
    ),
);
