<?php

return array(
	'import' => array(
		'application.modules.sample.models.*',
	),

	'modules' => array(
		'sample' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.sample.components.SampleOrganizationBehavior',
				),
			),
		),
	),
);
