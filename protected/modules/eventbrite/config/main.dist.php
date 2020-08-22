<?php

return array(
	'modules' => array(
		'eventbrite' => array(
			'var1' => '',
			'var2' => '',
		),
	),

	'components' => array(
		'urlManager' => array(
			'rules' => array(
				'<language:(ms|en|zh)>/eventbrite/register' => 'eventbrite/frontend/register',
				'<language:(ms|en|zh)>/eventbrite/register/<id:\d+>' => 'eventbrite/frontend/register',
				'<language:(ms|en|zh)>/eventbrite/registerCheck' => 'eventbrite/frontend/registerCheck',

				'eventbrite/register' => 'eventbrite/frontend/register',
				'eventbrite/register/<id:\d+>' => 'eventbrite/frontend/register',
				'eventbrite/registerCheck' => 'eventbrite/frontend/registerCheck',
				'eventbrite/eventbriteCallback' => 'eventbrite/frontend/eventbriteCallback',
			),
		),
	),
);
