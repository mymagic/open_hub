<?php

return array(
	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
			),
		),

		'urlManager' => array(
			'rules' => array(
			),
		),
	),
	'modules' => array(
		'cv' => array(
			'isFrontendEnabled' => true,
			'isCpanelEnabled' => true,
		),
	),
);
