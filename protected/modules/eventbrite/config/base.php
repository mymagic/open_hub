<?php

return array(
	'import' => array(
		'application.modules.eventbrite.models.*',
		'application.modules.bumi.models.*',
	),

	'modules' => array(
		'eventbrite' => array(
			'var1' => '',
			'var2' => '',
			'oauthSecret' => '',
			'organizationId' => '',
			'modelBehaviors' => array(
				/*'Organization'=>array(
					'class'=>'application.modules.eventbrite.components.EventbriteOrganizationBehavior',
				),
				'Individual'=>array(
					'class'=>'application.modules.eventbrite.components.BoilerplateStartIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.eventbrite.components.BoilerplateStartEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.eventbrite.components.BoilerplateStartResourceBehavior',
				),*/
			),
		),
	),
);
