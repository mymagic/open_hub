<?php

return array(
	'import' => array(
		'application.modules.eventbrite.models.*',
	),

	'modules' => array(
		'eventbrite' => array(
			'var1' => '',
			'var2' => '',
			'oauthSecret' => '',
			'organizationId' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.eventbrite.components.EventbriteOrganizationBehavior',
				),
				/*'Individual'=>array(
					'class'=>'application.modules.boilerplateStart.components.BoilerplateStartIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.boilerplateStart.components.BoilerplateStartEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.boilerplateStart.components.BoilerplateStartResourceBehavior',
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
			'rules' => array(
				'<language:(ms|en|zh)>/eventbrite/register' => 'eventbrite/frontend/register',
				'<language:(ms|en|zh)>/eventbrite/register/<id:\d+>' => 'eventbrite/frontend/register',
				'<language:(ms|en|zh)>/eventbrite/registerCheck' => 'eventbrite/frontend/registerCheck',

				'eventbrite/register' => 'eventbrite/frontend/register',
				'eventbrite/register/<id:\d+>' => 'eventbrite/frontend/register',
				'eventbrite/registerCheck' => 'eventbrite/frontend/registerCheck',
				'eventbrite/eventbriteCallback' => 'eventbrite/frontend/eventbriteCallback',
			),
		),
	),
);
