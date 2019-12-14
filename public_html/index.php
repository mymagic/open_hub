<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
include_once(dirname(__FILE__).'/../protected/config/phpini.php');
$config=dirname(__FILE__).'/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
include_once(dirname(__FILE__).'/../protected/config/path.php');
require_once(dirname(__FILE__).'/../protected/vendor/autoload.php');
$app = Yii::createWebApplication($config); 
$app->attachBehavior('WebBehavior','application.yeebase.components.behaviors.WebBehavior'); 
$app->run();

