<?php

// cr /var/www/open_hub/protected/tests
// ../vendor/bin/phpunit unit/HUBTest.php

// change the following paths if necessary
$yiit = dirname(__FILE__) . '/../../framework/yiit.php';
include_once dirname(__FILE__) . '/../config/phpini.php';

require_once $yiit;
require_once dirname(__FILE__) . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
//require_once(dirname(__FILE__).'/WebTestCase.php');

$config = dirname(__FILE__) . '/../config/test.php';
include_once dirname(__FILE__) . '/../config/path.php';
require_once dirname(__FILE__) . '/../components/WebApplication.php';

$_SERVER['SCRIPT_FILENAME'] = 'index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = 'index.php';

Yii::createWebApplication($config);

// exiang: enable this caused error below:
// PHP Fatal error:  Uncaught CHttpException: Unable to resolve the request "index.php". in /var/www/open_hub/framework/web/CWebApplication.php:286
/*$app = new WebApplication($config);
$app->attachBehavior('WebBehavior', 'application.yeebase.components.behaviors.WebBehavior');
$app->run();*/

function envKeySplit($array)
{
	$lists = explode(';', $array);
	foreach ($lists as $list) {
		list($k, $v) = explode(':', $list);
		$final[$k] = $v;
	}

	return $final;
}
