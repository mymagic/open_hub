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
$yiic = dirname(__FILE__) . '/../framework/yiic.php';
include_once dirname(__FILE__) . '/config/phpini.php';
$overridePhpIniFilePath = dirname(__FILE__) . '/overrides/config/phpini.php';
if (file_exists($overridePhpIniFilePath)) {
	include $overridePhpIniFilePath;
}

require_once dirname(__FILE__) . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../protected');
$dotenv->load();

$config = dirname(__FILE__) . '/config/console.php';

//require_once($yiic);

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once dirname(__FILE__) . '/../framework/yii.php';

// exiang: path need to be reinclude here to make sure those in config works
include_once dirname(__FILE__) . '/config/path.php';
if (isset($config)) {
	$app = Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH . '/cli/commands');
} else {
	$app = Yii::createConsoleApplication(array('basePath' => dirname(__FILE__) . '/../framework/cli'));
}

$env = @getenv('YII_CONSOLE_COMMANDS');
if (!empty($env)) {
	$app->commandRunner->addCommands($env);
}

// add modules commands
$modules = YeeModule::getActiveParsableModules();
foreach ($modules as $moduleKey => $moduleParams) {
	$modulePath = Yii::getPathOfAlias('modules');
	$filePath = sprintf('%s/%s/commands', $modulePath, $moduleKey);
	$app->commandRunner->addCommands($filePath);
}

// add override commands
$overridePath = Yii::getPathOfAlias('overrides');
$filePath = sprintf('%s/commands', $overridePath);
$app->commandRunner->addCommands($filePath);

$app->run();

function envKeySplit($array)
{
	$lists = explode(';', $array);
	foreach ($lists as $list) {
		list($k, $v) = explode(':', $list);
		$final[$k] = $v;
	}

	return $final;
}
