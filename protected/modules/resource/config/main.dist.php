<?php

return array(
	'modules' => array(
		'resource' => array(
			'emailTeam' => 'email@gmail.com'
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
