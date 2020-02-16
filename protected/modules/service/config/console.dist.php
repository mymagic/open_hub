<?php

return array(
	'import' => array(
		'application.modules.service.models.*',
	),

	'modules' => array(
		'service' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.service.components.ServiceOrganizationBehavior',
				),
				/*'Individual'=>array(
					'class'=>'application.modules.service.components.ServiceIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.service.components.ServiceEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.service.components.ServiceResourceBehavior',
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
