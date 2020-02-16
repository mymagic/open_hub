<?php

return array(
	'import' => array(
		'application.modules.interest.models.*',
		'application.modules.interest.models.neo4j.*',
	),

	'modules' => array(
		'interest' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
			),
		),
	),

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
);
