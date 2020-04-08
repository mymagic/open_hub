<?php

return array(
	'import' => array(
		'application.modules.collection.models.*',
	),

	'modules' => array(
		'collection' => array(
			'var1' => '',
			'var2' => '',
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.collection.components.CollectionOrganizationBehavior',
				),
				'User' => array(
					'class' => 'application.modules.collection.components.CollectionUserBehavior',
				),
			),
		),
	),
);
