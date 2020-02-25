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
				/*'Individual'=>array(
					'class'=>'application.modules.challenge.components.ChallengeIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.challenge.components.ChallengeEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.challenge.components.ChallengeResourceBehavior',
				),*/
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

	'params' => array(
		'thumbnails' => array(
			'challenge' => array(
				'cover' => array('32x32', '80x80', '320x320'),
				'header' => array('32x32', '80x80', '320x320'),
			)
		),
	)
);
