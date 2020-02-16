<?php

return array(
    'layout' => '/layouts/backend',
    'moduleCode' => 'challenge',
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
        'list' => array('id', 'title', 'owner_organization_id', 'date_open', 'date_close', 'is_active', 'is_published', 'is_featured', 'status', 'date_modified'),
        'sortDefaultOrder' => 't.id DESC',
    ),
    'structure' => array(
        'process_by' => array('isHiddenInForm'=>true),
        'date_process' => array('isHiddenInForm'=>true),
        'date_submit' => array('isHiddenInForm'=>true),
        'creator_user_id' => array('isHiddenInForm'=>true),
        'owner_organization_id' => array('isHiddenInForm'=>true),
        'status' => array('isHiddenInForm'=>true),
        // 'new','pending','processing','reject','approved','completed'
        'status' => array(
            // define enum here, so generator can support database system that dont even supprot this data type such as sqlite
            'isEnum' => true, 'enumSelections' => array('new' => 'New', 'pending' => 'Pending', 'processing' => 'Processing', 'reject' => 'Reject', 'approved' => 'Approved', 'completed' => 'Completed'),
        ),
        'json_extra' => array('isJson' => true),
    ),
    'json' => array(
        'extra' => array(
        ),
    ),
    'foreignKey' => array(
        'owner_organization_id' => array('relationName' => 'ownerOrganization', 'model' => 'Organization', 'foreignReferAttribute' => 'title'),
        'creator_user_id' => array('relationName' => 'creatorUser', 'model' => 'User', 'foreignReferAttribute' => 'username'),
        'process_by' => array('relationName' => 'processUser', 'model' => 'User', 'foreignReferAttribute' => 'username'),
    ),
    'many2many' => array(
        // target industry
        'industry' => array('className' => 'Industry', 'relationName' => 'industries', 'relationTable' => 'industry2challenge'),
    ),
    'tag' => array(
        'backend' => array(
            'tagTable' => 'tag', 'tagBindingTable' => 'tag2challenge', 'modelTableFk' => 'challenge_id', 'tagTablePk' => 'id', 'tagTableName' => 'name', 'tagBindingTableTagId' => 'tag_id', 'cacheID' => 'cacheTag2Challenge', ),
    ),
    'neo4j' => array (
        'attributes' => array(
            'id' => 'string',
            'title' => 'string',
            'is_active' => 'boolean',
            'is_publish' => 'boolean',
            'is_highlight' => 'boolean',
            'date_open' => 'int',
            'date_close' => 'int'
        )
    )
);
