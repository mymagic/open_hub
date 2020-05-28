<?php

use Exiang\YsUtil\YsUtil;

class OpenHubCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "downloadLatestRelease --saveAs=/var/www/open_hub/protected/runtime/download/key.openhub-latest.zip - download latest release package\n";
		echo "upgrade --key=UUID --force=true - upgrade to latest release package\n";
		echo "\n";
	}

	public function actionDownloadLatestRelease($saveAs = '')
	{
		$filename = 'openhub-latest.zip';

		// download from
		$downloadFilePath = sprintf('%s/release/%s', Yii::app()->getModule('openHub')->githubReleaseUrl, $filename);
		// save to
		if (empty($saveAs)) {
			$pathZipFile = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . $filename;
		} else {
			$pathZipFile = $saveAs;
		}

		echo sprintf("Downloading latest release from '%s'...\n", $downloadFilePath);

		$handle = fopen($downloadFilePath, 'rb');
		if (false === $handle) {
			exit("Failed to open stream to URL\n");
		}

		$contents = '';
		$downloaded = 0;

		while (!feof($handle)) {
			$contents .= fread($handle, 8192);
			$length = strlen($contents);
			if ($length - $downloaded > 1024 * 1024) {
				$downloaded = $length;
				echo YsUtil::formatByte($length) . '... ';
			}
		}
		fclose($handle);

		echo YsUtil::formatByte($length) . "\n";
		echo sprintf("\nWriting to '%s'...\n", $pathZipFile);
		if (file_put_contents($pathZipFile, $contents)) {
			echo "Download completed\n";
		}
	}

	public function actionUpgrade($key = '', $force = false)
	{
		$filename = 'openhub-latest.zip';
		if (empty($key)) {
			$key = YsUtil::generateUUID();
		}

		// check latest release version, stop if
		$upgradeInfo = HubOpenHub::getUpgradeInfo();
		if (!$upgradeInfo['canUpgrade'] && $force == false) {
			echo "\nYour current installation is the latest\n";
			exit;
		}

		// protected path to execute yiic
		$pathProtected = dirname(Yii::getPathOfAlias('runtime'), 1);
		$pathOutput = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'exec' . DIRECTORY_SEPARATOR . $key . '.OpenHubCommand-actionUpgrade.txt';

		// path to extrac zip package to
		$pathBase = dirname($pathProtected, 1);

		// path to download zip package to
		$pathZipFile = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . $key . '.' . $filename;

		// check directory path is default and not modified
		if (is_dir($pathBase . DIRECTORY_SEPARATOR . 'protected') && is_dir($pathBase . DIRECTORY_SEPARATOR . 'public_html') && is_dir($pathBase . DIRECTORY_SEPARATOR . 'framework')) {
			// clear output
			file_put_contents($pathOutput, '');

			// download zip and place in runtime/download
			echo "\n\nDownload package\n";
			file_put_contents($pathOutput, "\n\nDownload package\n", FILE_APPEND);
			$command = sprintf('php %s/yiic openhub downloadLatestRelease --saveAs=%s', $pathProtected, $pathZipFile);
			$result = YeeBase::runPOpen($command, $pathOutput, false, true);

			if ($result['status'] == 'success') {
				$zip = new ZipArchive;
				$res = $zip->open($pathZipFile);
				if ($res === true) {
					// extract zip
					echo "\n\nExtracting package\n";
					file_put_contents($pathOutput, "\n\nExtracting package\n", FILE_APPEND);
					// $zip->extractTo($pathBase);
					$zip->close();

					// deleted downloaded files
					//unlink($pathZipFile);

					// run system migration
					echo "\n\nRun System Migration\n";
					file_put_contents($pathOutput, "\n\nRun System Migration\n", FILE_APPEND);
					$command = sprintf('php %s/yiic migrate up', $pathProtected);
					$result = YeeBase::runPOpen($command, $pathOutput, false, true);

					// run languages scan to refresh translation message
					echo "\n\nRun Language Scan to refresh translation message\n";
					file_put_contents($pathOutput, "\n\nRun Language Scan to refresh translation message\n", FILE_APPEND);
					$command = sprintf('php %s/yiic message %s/config/message.php', $pathProtected, $pathProtected);
					$result = YeeBase::runPOpen($command, $pathOutput, false, true);

					// finally, output everything
					echo "\n\nSYSTEM UPGRADED SUCCESSFULLY\n";
					file_put_contents($pathOutput, "\n\nSYSTEM UPGRADED SUCCESSFULLY\n", FILE_APPEND);
					//echo file_get_contents($pathOutput);
				} else {
					echo sprintf("Failed, code:\n", $res);
				}
			}
		} else {
			echo 'Failed, auto update can not proceed as you had modified default directory path';
		}
	}
}
