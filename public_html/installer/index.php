<?php

$yii = dirname(__FILE__) . '/../../framework/yii.php';
require_once $yii;
require_once dirname(__FILE__) . '/../../protected/vendor/autoload.php';
$config = array(
    'defaultController' => 'default', 
    'import'=>array(
        'application.models.*',
    )
);
$app = Yii::createWebApplication($config);
$app->run();
