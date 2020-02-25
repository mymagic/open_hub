<?php

return array(
	'import' => array(
		'application.modules.eventbrite.models.*',
	),

	'modules' => array(
		'boilerplateStart' => array(
			'var1' => '',
			'var2' => '',
			'oauthSecret' => '',
			'organizationId' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.eventbrite.components.EventbriteOrganizationBehavior',
				),
				/*'Individual'=>array(
					'class'=>'application.modules.eventbrite.components.IndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.eventbrite.components.EventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.eventbrite.components.ResourceBehavior',
				),*/
			),
		),
	),

	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
				'eventbrite/callback*',
			),
		),

		'urlManager' => array(
			'rules' => array(),
		),
	),
);
