<?php

class OpenHubCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "downloadLatestRelease - download latest release package\n";
		echo "upgrade - upgrade to latest release package\n";
		echo "\n";
	}

	public function actionDownloadLatestRelease()
	{
		$filename = 'openhub-latest.zip';
		// download from
		$downloadFilePath = sprintf('%s/release/%s', Yii::app()->getModule('openHub')->githubReleaseUrl, $filename);
		// save to
		$pathZipFile = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . $filename;

		echo sprintf("Downloading latest release from '%s'...\n", $downloadFilePath);

		$handle = fopen($downloadFilePath, 'rb');
		if (false === $handle) {
			exit("Failed to open stream to URL\n");
		}

		$contents = '';
		$downloaded = 0;

		while (!feof($handle)) {
			$contents .= fread($handle, 8192);
			echo ysUtil::formatByte(strlen($contents)) . "\n";
		}
		fclose($handle);

		if (file_put_contents($pathZipFile, $contents)) {
			echo "Download completed\n";
		}
	}

	public function actionUpgrade()
	{
		$filename = 'openhub-latest.zip';
		$buffer = '';

		// protected path to execute yiic
		$pathProtected = dirname(Yii::getPathOfAlias('runtime'), 1);
		$pathOutput = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'exec' . DIRECTORY_SEPARATOR . 'OpenHubCommand-actionUpgrade.txt';

		// path to extrac zip package to
		$pathBase = dirname($pathProtected, 1);

		// path to download zip package to
		$pathZipFile = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . $filename;

		// check directory path is default and not modified
		if (is_dir($pathBase . DIRECTORY_SEPARATOR . 'protected') && is_dir($pathBase . DIRECTORY_SEPARATOR . 'public_html') && is_dir($pathBase . DIRECTORY_SEPARATOR . 'framework')) {
			// clear output
			file_put_contents($pathOutput, '');

			// download zip and place in runtime/download
			file_put_contents($pathOutput, "\n\nDownload package\n", FILE_APPEND);
			$command = sprintf('php %s/yiic openhub downloadLatestRelease', $pathProtected);
			$result = YeeBase::runPOpen($command, $pathOutput, false);

			if ($result['status'] == 'success') {
				$zip = new ZipArchive;
				$res = $zip->open($pathZipFile);
				if ($res === true) {
					// extract zip
					file_put_contents($pathOutput, "\n\nExtracting package\n", FILE_APPEND);
					$zip->extractTo($pathBase);
					$zip->close();

					// deleted downloaded files
					unlink($pathZipFile);

					// run system migration
					file_put_contents($pathOutput, "\n\nRun System Migration\n", FILE_APPEND);
					$command = sprintf('php %s/yiic migrate up', $pathProtected);
					$result = YeeBase::runPOpen($command, $pathOutput, false);

					// run languages message scan
					file_put_contents($pathOutput, "\n\nRun Language Message Scan\n", FILE_APPEND);
					$command = sprintf('php %s/yiic message %s/config/message.php', $pathProtected, $pathProtected);
					$result = YeeBase::runPOpen($command, $pathOutput, false);

					// finally, output everything
					$buffer = file_get_contents($pathOutput);
				} else {
					$buffer = sprintf("Failed, code:\n", $res);
				}
			}
		} else {
			$buffer = 'Failed, auto update can not proceed as you had modified default directory path';
		}

		echo $buffer;
		exit;
	}
}
