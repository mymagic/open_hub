<?php

return array(
	'import' => array(
		'application.modules.journey.models.*',
	),

	'modules' => array(
		'journey' => array(
			'emailTeam' => '',
			'modelBehaviors' => array(
				'Member' => array(
					'class' => 'application.modules.journey.components.JourneyMemberBehavior',
				),
			)
		),
	),
);
