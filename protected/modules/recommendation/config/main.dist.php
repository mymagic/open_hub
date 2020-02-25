<?php

return array(
	'import' => array(
		'application.modules.recommendation.models.*',
		'application.modules.recommendation.models.neo4j.*',
	),

	'modules' => array(
		'recommendation' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.recommendation.components.RecommendationOrganizationBehavior',
				),
				/*'Individual'=>array(
					'class'=>'application.modules.recommendation.components.RecommendationIndividualBehavior',
				),
				'Event'=>array(
					'class'=>'application.modules.recommendation.components.RecommendationEventBehavior',
				),
				'Resource'=>array(
					'class'=>'application.modules.recommendation.components.RecommendationResourceBehavior',
				),*/
			)
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
