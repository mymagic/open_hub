<?php

return array(
	'import' => array(
		'application.modules.oS4Growth.models.*',
		'application.modules.oS4Growth.models.neo4j.*',
	),

	'modules' => array(
		'oS4Growth' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.oS4Growth.components.OS4GrowthOrganizationBehavior',
				),
				'Member' => array(
					'class' => 'application.modules.oS4Growth.components.OS4GrowthMemberBehavior',
				),
				/*'Individual'=>array(
					'class'=>'application.modules.oS4Growth.components.OS4GrowthIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.oS4Growth.components.OS4GrowthEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.oS4Growth.components.OS4GrowthResourceBehavior',
				),*/
			)
		),
	),
);
