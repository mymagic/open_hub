<?php

return array(
	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
			),
		),

		'urlManager' => array(
			'rules' => array(
				'<language:(ms|en|zh)>/sampleGroup' => 'sample/sampleGroup',
				'<language:(ms|en|zh)>/sampleZone' => 'sampleZone',
				'<language:(ms|en|zh)>/sample' => 'sample/sample',
			),
		),
	),
);
