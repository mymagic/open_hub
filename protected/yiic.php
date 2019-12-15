<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../framework/yiic.php';
include_once(dirname(__FILE__).'/config/phpini.php');
$config=dirname(__FILE__).'/config/console.php';

require_once(dirname(__FILE__).'/vendor/autoload.php');
//require_once($yiic);

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once(dirname(__FILE__).'/../framework/yii.php');

// exiang: path need to be reinclude here to make sure those in config works
include_once(dirname(__FILE__).'/config/path.php');
if(isset($config))
{
	$app=Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
	$app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/../framework/cli'));

$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
	$app->commandRunner->addCommands($env);

// add modules command
$modules = YeeModule::getParsableModules();
foreach($modules as $moduleKey=>$moduleParams)
{
	$modulePath = Yii::getPathOfAlias('modules');
	$filePath = sprintf('%s/%s/commands', $modulePath, $moduleKey);
	$app->commandRunner->addCommands($filePath);	
}

$app->run();