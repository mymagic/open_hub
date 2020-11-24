<?php

return array(
	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
			),
		),

		'urlManager' => array(
			'rules' => array(
				'cv/cpanel' => 'cv/cpanel',
				'cv/frontend' => 'cv/frontend',
				'cv/backend' => 'cv/backend',
				'cv/cv' => 'cv/cv',
				'cv/cvExperience' => 'cv/cvExperience',
				'cv/cvJobpos' => 'cv/cvJobpos',
				'cv/cvJobposGroup' => 'cv/cvJobposGroup',
				'cv/cvPortfolio' => 'cv/cvPortfolio',
				'cv/<slug:\w+>' => 'cv/frontend/portfolio',
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
