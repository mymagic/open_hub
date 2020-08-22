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
				'Member' => array(
					'class' => 'application.modules.boilerplateStart.components.BoilerplateStartMemberBehavior',
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
			)
		),
	),
);
