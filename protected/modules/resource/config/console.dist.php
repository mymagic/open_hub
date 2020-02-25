<?php

return array(
	'import' => array(
		'application.modules.resource.models.*',
		'application.modules.resource.models.neo4j.*',
	),

	'modules' => array(
		'resource' => array(
			'emailTeam' => 'exiang83+tech@gmail.com'
		),
	),

	'components' => array(
		'urlManager' => array(
			'rules' => array(
				//
				// resource
				'resource/<slug>' => 'resource/frontend/viewBySlug',
				'resource/<id:\d+>' => 'resource/frontend/view',
				'resource/by/<id:\d+>' => 'resource/frontend/organization',
				'<language:(ms|en|zh)>/resource/<slug>' => 'resource/frontend/viewBySlug',
				'<language:(ms|en|zh)>/resource/<id:\d+>' => 'resource/frontend/view',
				'<language:(ms|en|zh)>/resource/by/<id:\d+>' => 'resource/frontend/organization',
				'<language:(ms|en|zh)>/resource' => 'resource/frontend/index',
			),
		),
	),
);
