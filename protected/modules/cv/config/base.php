<?php

return array(
	'import' => array(
		'application.modules.cv.models.*',
		'application.modules.cv.models.neo4j.*',
	),

	'modules' => array(
		'cv' => array(
			'var1' => '',
			'var2' => '',
			'isFrontendEnabled' => true,
			'isCpanelEnabled' => true,
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.cv.components.CvOrganizationBehavior',
				),
				'User' => array(
					'class' => 'application.modules.cv.components.CvUserBehavior',
				),
				/*'Individual'=>array(
					'class'=>'application.modules.cv.components.CvIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.cv.components.CvEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.cv.components.CvResourceBehavior',
				),*/
			)
		),
	),
);
