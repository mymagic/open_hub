<?php
return array(
	'layout' => '//layouts/backend',
	'isDeleteDisabled' => false,
    'menuTemplate' => array(
		'index'=>'admin, create',
		'admin'=>'create',
		'create'=>'admin',
		'update'=>'admin, create, view',
		'view'=>'admin, create, update, delete',
	),
	'foreignRefer' => array('key'=>'id', 'title'=>'amount'),
	'admin' => array(
		'list' => array('id','organization_id', 'date_raised', 'vc_name', 'amount', 'round_type_code', 'is_active'),
	),
	'structure' => array(
		'round_type_code' => array
		(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum'=>true, 'enumSelections'=>array(
				'seed'=>'Seed',
				'preSeriesA'=>'Pre Series A',
				'seriesA'=>'Series A',
				'seriesB'=>'Series B', 
				'seriesC'=>'Series C',
				'seriesD'=>'Series D',
				'seriesE'=>'Series E',
				'seriesF'=>'Series F',
				'debt'=>'Debt',
				'grant'=>'Grant',
				'equityCrowdfunding'=>'Equity Crowdfunding',
				'crowdfuning'=>'Crowdfuning',
			),
		),
	),
	// this foreignKey is mainly for crud view generation. model relationship will not use this at the moment
	'foreignKey' => array(
		'organization_id'=>array('relationName'=>'organization', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
		'vcOrganization'=>array('relationName'=>'vc_organization_id', 'model'=>'Organization', 'foreignReferAttribute'=>'title'),
	),
); 
