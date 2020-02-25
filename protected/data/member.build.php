<?php

return array(
	//'foreignRefer' => array('key'=>'id', 'title'=>'username'),
	'foreignKey' => array(
		'user_id' => array('relationName' => 'user', 'model' => 'User', 'foreignReferAttribute' => 'username'),
	),
	'structure' => array(
		'json_extra' => array('isJson' => true),
	),
	'json' => array(
		'extra' => array(
		),
	),
);
