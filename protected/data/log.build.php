<?php

return array(
	'foreignKey' => array(
		'user_id' => array('relationName' => 'user', 'model' => 'User', 'foreignReferAttribute' => 'username'),
	),
	'admin' => array(
		'list' => array('id', 'user_id', 'ip', 'controller', 'action', 'text_note'),
	)
);
