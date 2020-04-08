<?php

return array(
	'import' => array(
		'application.modules.challenge.models.*',
		'application.modules.challenge.models.neo4j.*',
	),

	'modules' => array(
		'challenge' => array(
			'var1' => '',
			'var2' => '',
			'isAutoApproveNewPost' => false,
			'f7TemplateFormSlug' => 'magic-activate-template',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.challenge.components.ChallengeOrganizationBehavior',
				),
			),
		),
	),
);
