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

class RequestCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * processUserDataDownloadRequest\nprocess all pending user data download requests\n";
		echo "\n";
	}

	public function actionProcessUserDataDownloadRequest()
	{
		$count = 0;
		$requests = HUB::getAllPendingDataDownloadRequest();
		try {
			foreach ($requests as $request) {
				$result = HUB::processUserDataDownloadRequest($request->id);
				if ($result->status == 'success') {
					$count++;
				}
			}
		} catch (Exception $e) {
			echo 'Exception captured: ' . $e->getMessage();
		}

		echo sprintf("Successfully processed %s request(s) to generate user data download pack\n", $count);

		Yii::app()->esLog->log(sprintf("called request\processUserDataDownloadRequest"), 'command', array('trigger' => 'RequestCommand::actionProcessUserDataDownloadRequest', 'model' => '', 'action' => '', 'id' => ''), '', array('countRequests' => $count));
	}

	public function actionTest()
	{
		//echo Yii::app()->createAbsoluteUrl('user/view');

		//$output = CConsoleCommand::renderFile('/request/_test.php', $data, true);
		//$output = Yii::app()->renderPartial('/request/_test');
		//$output = $this->renderPartial('/request/_test');
		//$output = self::renderFile('/request/_test');
		//works! $output = self::renderFile('views/request/_test.php');
		//works! $output = HUB::renderPartial('/request/_test');
		//echo $output;

		$username = 'exiang83@gmail.com';
		$format = 'html';

		$user = HUB::getUserByUsername($username);
		$tmp = HUB::createUserDataDownload($user, $format);
		print_r($tmp);
	}
}
