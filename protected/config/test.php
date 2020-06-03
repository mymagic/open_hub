<?php

$return = CMap::mergeArray(
	require(dirname(__FILE__) . '/main.php'),
	array(
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager',
			),
			// uncomment the following to provide test database connection
			'db' => array(
				'connectionString' => sprintf('mysql:host=%s;port=%d;dbname=%s', getenv('TEST_DB_HOST', 'localhost'), getenv('TEST_DB_PORT', '3306'), getenv('TEST_DB_DATABASE', 'test')),
				'username' => getenv('TEST_DB_USERNAME', 'default'),
				'password' => getenv('TEST_DB_PASSWORD', 'secret'),
				'charset' => 'utf8',
			),
		),
	)
);

// $return['modules'] = array();
// $return['components']['urlManager']['rules'] = array();

return $return;
