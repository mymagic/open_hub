<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$return = array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => getenv('HUB_NAME', 'Open Hub'),

	'sourceLanguage' => getenv('SOURCE_LANGUAGE', '00'),
	'language' => getenv('LANGUAGE', 'en'),

	// preloading 'log' component
	'preload' => array('log'),

	'localeDataPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'i18n/data',

	// autoloading model and component classes
	'import' => array(
		'application.vendor.*',
		'application.helpers.*',
		'application.models.*',
		'application.components.*',
		'application.models.hub.*',
		'application.models.neo4j.*',
		'system.collections.*',

		// yeebase
		'application.yeebase.models.*',
		'application.yeebase.components.*',
		'application.yeebase.components.FirePHPCore.*',
		'application.yeebase.extensions.*',
		'application.yeebase.extensions.ECSVExport.*',
		'application.yeebase.extensions.taggable-behavior.*',
		'application.yeebase.extensions.ysUtil.*',
		'application.yeebase.extensions.feed.*',
		//'application.yeebase.extensions.widgets.hybridAuth.*',
		'application.yeebase.extensions.image.Image',

		// app

		// overrides
		'application.overrides.helpers.*',
		'application.overrides.models.*',
		'application.overrides.models.hub.*',
		'application.overrides.components.*',
		'application.overrides.components.widgets.*',
		'application.overrides.extensions.*',
	),

	'commandMap' => array(
		/*'site'=>array(
		   'class'=>'application.overrides.controllers.SiteController',
		),*/
	),

	// application components
	'components' => array(
		'request' => array(
			'class' => 'HttpRequest',
			'hostInfo' => getenv('REQUEST_HOST_INFO', 'http://openhubd.mymagic.my'),
			'baseUrl' => '',
			'scriptUrl' => '',
			'noValidationRoutes' => require(dirname(__FILE__) . '/csrfExcludeRegular.php'),
			// using fnmatch
			'noValidationRegex' => require(dirname(__FILE__) . '/csrfExcludeRegex.php'),
		),

		'urlManager' => array(
			'class' => 'application.yeebase.components.UrlManager',
			'urlFormat' => 'path',
			'showScriptName' => false,
		),
		// uncomment the following to use a MySQL database
		'db' => array(
			'connectionString' => sprintf('mysql:host=%s;port=%d;dbname=%s', getenv('DB_HOST', 'mariadb'), getenv('DB_PORT', '3306'), getenv('DB_DATABASE', 'default')),
			'emulatePrepare' => true,
			'username' => getenv('DB_USERNAME', 'default'),
			'password' => getenv('DB_PASSWORD', 'secret'),
			'charset' => 'utf8',
			'initSQLs' => array("set time_zone='+00:00';"),
			'emulatePrepare' => true,
			'pdoClass' => 'NestedPDO',
		),
		'cache' => array(
			'class' => getenv('CACHE_DRIVER', 'CFileCache'),
		),
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),
		'image' => array(
		  'class' => 'application.yeebase.extensions.image.CImageComponent',
			// GD or ImageMagick
			'driver' => getenv('IMAGE_DRIVER', 'GD'),
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
			),
		),
		'esLog' => array(
			'class' => 'application.yeebase.components.EsLog',
			'esLogRegion' => '',
			'enableEsLog' => true,
			'esLogIndexCode' => 'log-default',
			'esLogEndpoint' => '',
			'esLogKey' => '',
			'esLogSecret' => '',
			'esTestVar' => '123',
		),
		'neo4j' => array(
			'enable' => filter_var(getenv('NEO4J_ENABLE', false), FILTER_VALIDATE_BOOLEAN),
			'class' => 'application.extensions.neo4j.NeoEntity',
			'neoConnectionString' => sprintf('%s://%s:%s@%s:%d', getenv('NEO4J_PROTOCOL', 'http'), getenv('NEO4J_USERNAME', 'neo4j'), getenv('NEO4J_PASSWORD', 'neo4j'), getenv('NEO4J_HOST', 'neo4j'), getenv('NEO4J_PORT', '7474'))
		),
		'file' => array(
			'class' => 'application.yeebase.extensions.file.CFile',
		),
		's3' => array(
			'class' => 'application.yeebase.extensions.s3.ES3',
			'aKey' => getenv('S3_ACCESS_KEY', 'key'),
			'sKey' => getenv('S3_SECRET_KEY', 'key'),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => require(dirname(__FILE__) . '/params.php'),
);

$return['modules'] = require dirname(__FILE__) . '/module.php';

$modules_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
$handle = opendir($modules_dir);
while (false !== ($file = readdir($handle))) {
	if ($file != '.' && $file != '..' && is_dir($modules_dir . $file)) {
		$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'base.php'));
		$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'console.base.php'));
		$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'console.php'));
	}
}
closedir($handle);

$return['components']['urlManager']['rules'] = CMap::mergeArray($return['components']['urlManager']['rules'], require(dirname(__FILE__) . '/route.php'));

if ($return['components']['cache']['class'] == 'CRedisCache') {
	$return['components']['cache']['hostname'] = getenv('CACHE_HOSTNAME', 'redis');
	$return['components']['cache']['port'] = getenv('CACHE_PORT', '6379');
}
// echo '<pre>';print_r($return);exit;

// override
$overrideMainFilePath = sprintf('%s/config/console.php', Yii::getPathOfAlias('overrides'));
if (file_exists($overrideMainFilePath)) {
	$overrideMain = include $overrideMainFilePath;
	$return = CMap::mergeArray($return, $overrideMain);
}

return $return;
