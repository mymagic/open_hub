<?php

return array(
	'foreignRefer' => array('key' => 'code', 'title' => 'code'),
	'admin' => array(
		'list' => array('id', 'code', 'value', 'datatype', 'note', 'date_modified'),
	),
	'structure' => array(
		'datatype' => array(
			// define enum here, so generator can support database system that dont even supprot this data type such as sqlite
			'isEnum' => true, 'enumSelections' => array('boolean' => 'Boolean', 'integer' => 'Integer', 'float' => 'Float', 'string' => 'String', 'text' => 'Text', 'html' => 'Html', 'array' => 'Array', 'date' => 'Date', 'image' => 'Image'),
		),
	),
);
