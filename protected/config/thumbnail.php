<?php

$return = array(
	'organization' => array(
		'logo' => array('32x32', '80x80', '320x320'),
	),
	'product_category' => array(
		'cover' => array('32x32', '80x80', '320x320'),
	),
	'event_group' => array(
		'cover' => array('80x80', '32x32')
	),
	'impact' => array(
		'cover' => array('32x32', '80x80', '320x320'),
	),
	'sdg' => array(
		'cover' => array('32x32', '80x80', '320x320'),
	),
	'product' => array(
		'cover' => array('32x32', '80x80', '320x320'),
	),
	'individual' => array(
		'photo' => array('32x32', '80x80', '320x320'),
	),
	'proof' => array(
		'value' => array('32x32', '80x80', '320x320'),
		'datatype_value' => array('32x32', '80x80', '320x320'),
	),
	'setting' => array(
		'value' => array('32x32', '80x80', '320x320'),
		'datatype_value' => array('32x32', '80x80', '320x320'),
	),
	'embed' => array(
		'main_en' => array('32x32', '80x80', '320x320'),
		'main_ms' => array('32x32', '80x80', '320x320'),
		'main_zh' => array('32x32', '80x80', '320x320'),
	),
);

$modules_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
$handle = opendir($modules_dir);
while (false !== ($file = readdir($handle))) {
	if ($file != '.' && $file != '..' && is_dir($modules_dir . $file)) {
		$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'thumbnail.php'));
	}
}
closedir($handle);

return $return;
