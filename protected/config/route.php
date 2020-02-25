<?php

//return array();

return array(
	// these route settings come in last after module

	//
	// shortcut
	'connectLogin' => 'site/connectLogin',
	'connectCallback' => 'site/connectCallback',
	'login' => 'site/login',
	'logout' => 'site/logout',
	'booking' => 'site/booking',

	//
	// base
	// these 2 line somehow need to be at very top of others or else it will caused issues in gridview when use with filter & pagination
	/* 'posts/<tag:.*?>'=>'post/index', */
	'<language:(ms|en|zh)>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
	'<controller:\w+>/<action:\w+>' => '<controller>/<action>',

	'<language:(ms|en|zh)>/' => 'site/index',
	'<language:(ms|en|zh)>/site/page/<view:\w+>' => 'site/page',
	'<language:(ms|en|zh)>/<controller:\w+>/<id:\d+>' => '<controller>/view',
	'<language:(ms|en|zh)>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
	'<language:(ms|en|zh)>/<controller:\w+>/<action:\w+>/*' => '<controller>/<action>',
	'<language:(ms|en|zh)>/<module:\w+>/<controller:\w+>/<action:\w+>/*' => '<module>/<controller>/<action>',

	'<language:(ms|en|zh)>/sampleGroup' => 'sampleGroup/index',
	'<language:(ms|en|zh)>/sampleGroup' => 'sampleGroup',
	'<language:(ms|en|zh)>/sampleZone' => 'sampleZone/index',
	'<language:(ms|en|zh)>/sampleZone' => 'sampleZone',
	'<language:(ms|en|zh)>/sample' => 'sample/index',
	'<language:(ms|en|zh)>/sample' => 'sample',

	'site/page/<view:\w+>' => 'site/page',
	'<controller:\w+>/<id:\d+>' => '<controller>/view',
	'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',

	'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
);
