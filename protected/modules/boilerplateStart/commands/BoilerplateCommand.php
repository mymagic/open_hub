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

use Exiang\YsUtil\YsUtil;

class BoilerplateCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "create --name=\"Hello World\" - Create a new module using boilerplateStart as template\n";
		echo "\n";
	}

	public function actionCreate($name)
	{
		$dirName = lcfirst(str_replace(' ', '', ucwords($name)));
		$className = (str_replace(' ', '', ucwords($name)));

		$templatePath = sprintf('%s/boilerplateStart', Yii::getPathOfAlias('modules'));
		$destPath = sprintf('%s/%s', Yii::getPathOfAlias('modules'), $dirName);

		// copy directory recursively
		CFileHelper::createDirectory($destPath);
		CFileHelper::copyDirectory($templatePath, $destPath);

		echo sprintf("New directory created at: %s\n", $destPath);

		// rewrite file
		file_put_contents($destPath . '/readme.md', sprintf('Module %s', ucwords($name)));

		// delete files
		unlink($destPath . '/commands/BoilerplateCommand.php');

		// rename files
		rename($destPath . '/BoilerplateStartModule.php', $destPath . '/' . $className . 'Module.php');
		rename($destPath . '/components/BoilerplateStartOrganizationBehavior.php', $destPath . '/components/' . $className . 'OrganizationBehavior.php');
		rename($destPath . '/components/BoilerplateStartMemberBehavior.php', $destPath . '/components/' . $className . 'MemberBehavior.php');
		rename($destPath . '/controllers/BoilerplateStartController.php', $destPath . '/controllers/' . $className . 'Controller.php');
		rename($destPath . '/models/HubBoilerplateStart.php', $destPath . '/models/Hub' . $className . '.php');
		rename($destPath . '/views/backend/_view-boilerplateStart-advanceSearch.php', $destPath . '/views/backend/_view-' . $dirName . '-advanceSearch.php');

		// scan thru all files and replace string
		$phpFiles = CFileHelper::findFiles($destPath, array('fileTypes' => array('php', 'yaml')));
		foreach ($phpFiles as $phpFile) {
			$buffer = file_get_contents($phpFile);
			// boilerplateStart -> $dirName
			$buffer = str_replace('boilerplateStart', $dirName, $buffer);
			// BoilerplateStart -> $className
			$buffer = str_replace('BoilerplateStart', $className, $buffer);
			// Boilerplate Start -> ucwords($name)
			$buffer = str_replace('Boilerplate Start', ucwords($name), $buffer);
			file_put_contents($phpFile, $buffer);
		}
	}
}
