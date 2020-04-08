<?php

return array(
	'import' => array(
		'application.modules.f7.models.*',
	),

	'modules' => array(
		'f7' => array(
			'modelBehaviors' => array(
				'Organization' => array(
					'class' => 'application.modules.f7.components.F7OrganizationBehavior',
				),
				'Member' => array(
					'class' => 'application.modules.f7.components.F7MemberBehavior',
				)
			),
		),
	),
);
