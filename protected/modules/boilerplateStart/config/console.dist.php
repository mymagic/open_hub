<?php

return array(
	'import' => array(
		'application.modules.boilerplateStart.models.*',
		'application.modules.boilerplateStart.models.neo4j.*',
	),

	'modules' => array(
		'boilerplateStart' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.boilerplateStart.components.BoilerplateStartOrganizationBehavior',
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
			),
		),

		'urlManager' => array(
			'rules' => array(
			),
		),
	),
);
