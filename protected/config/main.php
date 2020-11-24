<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$return = array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => getenv('HUB_NAME', 'Open Hub'),
	'theme' => getenv('THEME', 'inspinia'), // inspinia, bootstrap3

	'sourceLanguage' => getenv('SOURCE_LANGUAGE', '00'),
	'language' => getenv('LANGUAGE', 'en'),

	// preloading 'log' component
	'preload' => array('log'),

	'localeDataPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'i18n/data',

	// ys: disable this as it will caused issue in event stream cli to web browser
	// enable gzip output content
	//'onBeginRequest' => create_function('$event', 'return ob_start("ob_gzhandler");'),
	//'onEndRequest' => create_function('$event', 'return ob_end_flush();'),

	// autoloading model and component classes
	'import' => array(
		'application.vendor.*',
		'application.helpers.*',
		'application.models.*',
		'application.models.hub.*',
		'application.models.neo4j.*',
		'application.components.*',
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
		'application.overrides.extensions.*',
	),

	'controllerMap' => array(
		/*'site'=>array(
		   'class'=>'application.overrides.controllers.SiteController',
		),*/
	),

	'behaviors' => array(
		'ApplicationConfigBehavior',

		array('class' => 'application.yeebase.extensions.CorsBehavior',
			// route cant be fully wildcard, need at least a specific controller
			'route' => array('api/*', 'api/', 'api/getRandomProfiles'),
			'allowOrigin' => '*'
		),
	),

	// application components
	'components' => array(
		'session' => array(
			'timeout' => 7200, // in seconds
		),
		'request' => array(
			'class' => 'HttpRequest',
			// need exact match to action level
			'noValidationRoutes' => require(dirname(__FILE__) . '/csrfExcludeRegular.php'),
			// using fnmatch
			'noValidationRegex' => require(dirname(__FILE__) . '/csrfExcludeRegex.php'),
			'enableCsrfValidation' => filter_var(getenv('ENABLE_CSRF_VALIDATION', true), FILTER_VALIDATE_BOOLEAN),
			'enableCookieValidation' => filter_var(getenv('ENABLE_COOKIE_VALIDATION', true), FILTER_VALIDATE_BOOLEAN),
			'csrfCookie' => array(
				'domain' => getenv('CSRF_COOKIE', '.mymagic.my'),
			),
		),
		'user' => array(
			// enable cookie-based authentication
			'class' => 'WebUser',
			'allowAutoLogin' => true,
			'authTimeout' => 7200,
			'loginUrl' => array('/site/login'),
		),
		'urlManager' => array(
			'class' => 'application.yeebase.components.UrlManager',
			'urlFormat' => 'path',
			'showScriptName' => false,
		),
		// uncomment the following to use a MySQL database
		'db' => array(
			'connectionString' => sprintf('mysql:host=%s;port=%d;dbname=%s', getenv('DB_HOST', 'localhost'), getenv('DB_PORT', '3306'), getenv('DB_DATABASE', 'default')),
			'emulatePrepare' => true, // must set to true or findAll() with params will give error
			'username' => getenv('DB_USERNAME', 'default'),
			'password' => getenv('DB_PASSWORD', 'secret'),
			'charset' => 'utf8',
			'initSQLs' => array("set time_zone='+00:00';"),
			'enableParamLogging' => filter_var(getenv('ENABLE_PROFILE_LOG', false), FILTER_VALIDATE_BOOLEAN),
			'enableProfiling' => filter_var(getenv('ENABLE_PROFILE_LOG', false), FILTER_VALIDATE_BOOLEAN),
			'pdoClass' => 'NestedPDO',
			'schemaCachingDuration' => getenv('DB_SCHEMA_CACHE_DURATION', '0'),
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
				'module' => array(
					'class' => 'CFileLogRoute',
					'levels' => 'trace, error, warning, info',
					'logFile' => 'module',
					'categories' => 'module.*'
				),
				'paypal' => array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, info',
					'logFile' => 'paypal',
					'categories' => 'paypal.*'
				),
				'all' => array(
					'class' => 'CFileLogRoute',
					'levels' => 'trace, info, warning',
					'logFile' => 'all.log',
				),
				'error' => array(
					'class' => 'CFileLogRoute',
					'levels' => 'error',
					'logFile' => 'error.log',
				),
				'db' => array(
					'class' => 'application.yeebase.extensions.ys.ProfileFileLogRoute',
					'levels' => 'profile',
					'report' => 'callstack',
					'logFile' => 'db.log',
				),
				'profile' => array(
					'class' => 'CProfileLogRoute',
					'report' => 'summary',
					'enabled' => filter_var(getenv('ENABLE_PROFILE_LOG', false), FILTER_VALIDATE_BOOLEAN)
				)
			),
		),
		'esLog' => array(
			'class' => 'application.yeebase.components.EsLog',
			'esLogRegion' => getenv('ESLOG_REGION', ''),
			'enableEsLog' => filter_var(getenv('ESLOG_ENABLE', false), FILTER_VALIDATE_BOOLEAN),
			'esLogIndexCode' => getenv('ESLOG_INDEX_CODE', 'log-default'),
			'esLogEndpoint' => getenv('ESLOG_ENDPOINT', ''),
			'esLogKey' => getenv('ESLOG_KEY', ''),
			'esLogSecret' => getenv('ESLOG_SECRET', ''),
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
		'ePdf' => array(
			'class' => 'application.yeebase.extensions.yii-pdf.EYiiPdf',
			'params' => array(
				'mpdf' => array(
					'librarySourcePath' => 'application.vendor.mpdf.*',
					'constants' => array(
						'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
					),
					'class' => 'Mpdf', // the literal class filename to be loaded from the vendors folder
					'defaultParams' => array( // More info: http://mpdf1.com/manual/index.php?tid=184
						'mode' => '', //  This parameter specifies the mode of the new document.
						'format' => 'A4', // format A4, A5, ...
						'default_font_size' => 0, // Sets the default document font size in points (pt)
						'default_font' => '', // Sets the default font-family for the new document.
						'mgl' => 15, // margin_left. Sets the page margins for the new document.
						'mgr' => 15, // margin_right
						'mgt' => 16, // margin_top
						'mgb' => 16, // margin_bottom
						'mgh' => 9, // margin_header
						'mgf' => 9, // margin_footer
						'orientation' => 'P', // landscape or portrait orientation
					)
				),
				'HTML2PDF' => array(
					'librarySourcePath' => 'application.vendor.html2pdf.*',
					'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
					'defaultParams' => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
						'orientation' => 'P', // landscape or portrait orientation
						'format' => 'A4', // format A4, A5, ...
						'language' => 'en', // language: fr, en, it ...
						'unicode' => true, // TRUE means clustering the input text IS unicode (default = true)
						'encoding' => 'UTF-8', // charset encoding; Default is UTF-8
						'marges' => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
					)
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => require(dirname(__FILE__) . '/params.php'),
);

$return['modules'] = require dirname(__FILE__) . '/module.php';
if (!array_key_exists('moduleDisableNoneCore', $return['params']) || (array_key_exists('moduleDisableNoneCore', $return['params']) && $return['params']['moduleDisableNoneCore'] == false)) {
	$modules_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
	$handle = opendir($modules_dir);
	while (false !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..' && is_dir($modules_dir . $file) && file_exists($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php')) {
			//$startTime = Yii::getLogger()->getExecutionTime();

			$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'base.php'));
			$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.base.php'));
			$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php'));

			//$endTime = Yii::getLogger()->getExecutionTime();

			//echo sprintf('<p>%0.5f - %s</p>',$endTime-$startTime, $modules_dir.$file);
		}
	}
	closedir($handle);
}

$return['components']['urlManager']['rules'] = CMap::mergeArray($return['components']['urlManager']['rules'], require(dirname(__FILE__) . '/route.php'));

// domain specific override
$domainSettings = include_once sprintf('%s/config/domain.php', Yii::getPathOfAlias('overrides'));
if (!empty($domainSettings) && is_array($domainSettings)) {
	if (array_key_exists($_SERVER['SERVER_NAME'], $domainSettings)) {
		$return = CMap::mergeArray($return, $domainSettings[$_SERVER['SERVER_NAME']]);
	}
}

if ($return['components']['cache']['class'] == 'CRedisCache') {
	$return['components']['cache']['hostname'] = getenv('CACHE_HOSTNAME', 'redis');
	$return['components']['cache']['port'] = getenv('CACHE_PORT', '6379');
}

// override
$overrideMainFilePath = sprintf('%s/config/main.php', Yii::getPathOfAlias('overrides'));
if (file_exists($overrideMainFilePath)) {
	$overrideMain = include_once $overrideMainFilePath;
	$return = CMap::mergeArray($return, $overrideMain);
}

// hybridAuth
if ($return['params']['authAdapter'] == 'local') {
	$return['components']['hybridAuth'] = array(
		'class' => 'application.yeebase.extensions.HybridAuth.CHybridAuth',
		'vendorPath' => Yii::getPathOfAlias('vendor'),
		'enabled' => true, // enable or disable this component
		'config' => array(
			 'base_url' => 'https://' . $_SERVER['HTTP_HOST'] . '/hauth/endpoint',
		),
	); //end hybridAuth

	if (!empty(getenv('GOOGLE_HAUTH_ID')) && !empty(getenv('GOOGLE_HAUTH_SECRET'))) {
		$return['components']['hybridAuth']['config']['providers']['Google'] = array(
			'enabled' => true,
			'keys' => array('id' => getenv('GOOGLE_HAUTH_ID'), 'secret' => getenv('GOOGLE_HAUTH_SECRET')),
			'scope' => 'https://www.googleapis.com/auth/userinfo.profile ' . // optional
				'https://www.googleapis.com/auth/userinfo.email', // optional
		);
	}

	if (!empty(getenv('FB_APP_ID')) && !empty(getenv('FB_APP_SECRET'))) {
		$return['components']['hybridAuth']['config']['providers']['Facebook'] = array(
			'enabled' => true,
			'keys' => array('id' => getenv('FB_APP_ID'), 'secret' => getenv('FB_APP_SECRET')),
			'scope' => 'email, public_profile',
			'trustForwarded' => true,
		);
	}
}

return $return;
