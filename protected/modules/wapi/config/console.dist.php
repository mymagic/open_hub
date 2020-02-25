<?php

return array(
	'import' => array(
		'application.modules.wapi.models.*',
	),

	'modules' => array(
		'wapi' => array(
		),
	),

	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
				'wapi/v1/*',
			),
		),

		'urlManager' => array(
			'rules' => array(
				//
				// wapi
				'swagger/getApiDef/<code:\w+>.<format\w+>' => 'wapi/swagger/getApiDef',
				'http://api-hubd.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'https://api-hubd.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'http://api-hub.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'https://api-hub.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'http://api-hub7.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'https://api-hub7.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'http://api-central7.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'https://api-central7.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'http://api-central.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
				'https://api-central.mymagic.my/<controller:\w+>/<action:\w+>/*' => 'wapi/<controller>/<action>',
			),
		),
	),
);
