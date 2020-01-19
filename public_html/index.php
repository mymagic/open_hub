<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/

// change the following paths if necessary
$yii = dirname(__FILE__) . '/../framework/yii.php';
include_once dirname(__FILE__) . '/../protected/config/phpini.php';
$config = dirname(__FILE__) . '/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

 require_once($yii);
include_once dirname(__FILE__) . '/../protected/config/path.php'; require_once(dirname(__FILE__) .'/../protected/vendor/autoload.php'); require_once(dirname(__FILE__) .'/../protected/components/WebApplication.php');

//$app = Yii::createWebApplication($config);
$app = new WebApplication($config);
$app->attachBehavior('WebBehavior', 'application.yeebase.components.behaviors.WebBehavior');
$app->run();
