<?php

$return = array();

$modules_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
$handle = opendir($modules_dir);
while (false !== ($file = readdir($handle))) {
	if ($file != '.' && $file != '..' && is_dir($modules_dir . $file)) {
		$return = CMap::mergeArray($return, include($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'secureFiles.php'));
	}
}
closedir($handle);

return $return;
