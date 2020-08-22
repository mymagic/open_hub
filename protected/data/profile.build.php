<?php

return array(
	'structure' => array(
		'gender' => array(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('male' => 'Male', 'female' => 'Female'),
		),
		'json_extra' => array('isJson' => true),
	),
	'json' => array(
		'extra' => array(
		),
	),
);
