<?php

return array(
	'foreignRefer' => array('key' => 'id', 'title' => 'username'),
	'structure' => array(
		'signup_type' => array(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('default' => 'Default', 'facebook' => 'Facebook', 'google' => 'Google', 'admin' => 'Admin'),
		),
	),
);
