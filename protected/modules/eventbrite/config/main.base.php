<?php

return array(
	'components' => array(
		'request' => array(
			'noValidationRegex' => array(
				'eventbrite/callback*',
			),
		),
	)
);
