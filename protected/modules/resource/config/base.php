<?php

return array(
	'import' => array(
		'application.modules.resource.models.*',
		'application.modules.resource.models.neo4j.*',
	),

	'modules' => array(
		'resource' => array(
			'emailTeam' => 'email@gmail.com',
			'allowUserAddResource' => 'true',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.resource.components.ResourceOrganizationBehavior',
				),
			)
		),
	),
);
