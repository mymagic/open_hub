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

/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii = dirname(__FILE__) . '/../framework/yii.php';
include_once dirname(__FILE__) . '/../protected/config/phpini.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once $yii;
require_once dirname(__FILE__) . '/../protected/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../protected');
$dotenv->load();

//$config = dirname(__FILE__) . '/protected/config/test.php';
$config = dirname(__FILE__) . '/../protected/config/test.php';

$app = new WebApplication($config);
$app->attachBehavior('WebBehavior', 'application.yeebase.components.behaviors.WebBehavior');
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
