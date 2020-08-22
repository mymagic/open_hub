<?php

//
// modules
// modularized load module config
$return['modules']['sys'] = array(
	'class' => 'application.yeebase.modules.sys.SysModule',
);
$return['modules']['i18n'] = array(
	'class' => 'application.yeebase.modules.i18n.I18nModule',
);
$return['modules']['language'] = array(
	'class' => 'application.yeebase.modules.language.LanguageModule',
	'ipFilters' => array('127.0.0.1', '::1'),
);
$return['modules']['egg'] = array(
	'class' => 'application.yeebase.modules.egg.EggModule',
	'ipFilters' => array('127.0.0.1', '::1'),
	'password' => getenv('MODULE_EGG_PASSWORD', 'secret'),
);
$return['modules']['inspinia'] = array(
	'class' => 'application.yeebase.modules.inspinia.InspiniaModule',
	'ipFilters' => array('127.0.0.1', '::1'),
);
$return['modules']['gii'] = array(
	'class' => 'system.gii.GiiModule',
	'password' => getenv('MODULE_GII_PASSWORD', 'secret'),
	 // If removed, Gii defaults to localhost only. Edit carefully to test.
	'ipFilters' => array('127.0.0.1', '::1'),
);
$return['modules']['yee'] = array(
	'class' => 'application.modules.yee.GiiModule',
	'password' => getenv('MODULE_YEE_PASSWORD', 'secret'),
	 // If removed, Gii defaults to localhost only. Edit carefully to test.
	'ipFilters' => array('127.0.0.1', '::1'),
);

if ($return['params']['dev']) {
	$return['modules']['egg']['ipFilters'][] = '*';
	$return['modules']['inspinia']['ipFilters'][] = '*';
	$return['modules']['gii']['ipFilters'][] = '*';
	$return['modules']['yee']['ipFilters'][] = '*';
}

return $return['modules'];
