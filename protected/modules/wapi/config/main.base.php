<?php

$return = array(
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
			),
		),
	),
);

$parsed = parse_url(getenv('BASE_API_URL'));
$key = sprintf('%s://%s/<controller:\w+>/<action:\w+>/*',$parsed['scheme'], $parsed['host']);
$return['components']['urlManager']['rules'][$key] = 'wapi/<controller>/<action>';

return $return;
