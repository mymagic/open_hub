<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','/path/to/local-folder');

Yii::setPathOfAlias('wwwroot', dirname(__DIR__, 2) . '/public_html');
Yii::setPathOfAlias('uploads', dirname(__DIR__, 2) . '/public_html/uploads');
Yii::setPathOfAlias('static', dirname(__DIR__, 2) . '/public_html/static');
Yii::setPathOfAlias('runtime', dirname(__DIR__) . '/runtime');
Yii::setPathOfAlias('cronRoutine', dirname(__DIR__) . '/runtime/routine');
Yii::setPathOfAlias('cronLog', dirname(__DIR__, 2) . '/_cron/runtime/log');
Yii::setPathOfAlias('data', dirname(__DIR__) . '/data');

Yii::setPathOfAlias('components', dirname(__DIR__) . '/components');
Yii::setPathOfAlias('controllers', dirname(__DIR__) . '/controllers');
Yii::setPathOfAlias('models', dirname(__DIR__) . '/models');
Yii::setPathOfAlias('modules', dirname(__DIR__) . '/modules');
Yii::setPathOfAlias('views', dirname(__DIR__) . '/views');
Yii::setPathOfAlias('messages', dirname(__DIR__) . '/messages');
Yii::setPathOfAlias('overrides', dirname(__DIR__) . '/overrides');
