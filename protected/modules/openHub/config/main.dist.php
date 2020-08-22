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
		'openHub' => array(
			'githubOrganization' => 'mymagic',
			'githubRepoName' => 'open_hub',
		),
	),
);
