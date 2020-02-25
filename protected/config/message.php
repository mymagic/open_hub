<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
	'sourcePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
	'languages' => array('en', 'ms', 'zh'),
	'fileTypes' => array('php'),
	'overwrite' => true,
	'removeOld' => true,
	'sort' => 'new',
	'exclude' => array(
		'.svn',
		'.gitignore',
		'.DS_Store',
		'yiilite.php',
		'yiit.php',
		'/i18n/data',
		'/messages',
		'/vendors',
		'/web/js',
		'/yeebase',
		'/vendor',
	),
);
