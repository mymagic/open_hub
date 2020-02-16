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

class UserCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * forceResetUserPassword --offset=0\nchange to new random password for all users in database. use with CAUTION!\n";
		echo "\n";
	}

	// 1:55 start ??:?? end for x records 
	public function actionForceResetUserPassword($offset=0)
	{
		$count = 0;
		$criteria = new CDbCriteria;
		$criteria->offset = $offset;
		$users = User::model()->findAll($criteria);

		foreach($users as $user)
		{
			$newPassword = ysUtil::generateRandomPassword();
			$user->password = $newPassword;
			if($user->save()){
				echo sprintf("reset user #%s - '%s' password to '%s' (after hashed: %s)\n", $user->id, $user->username, $newPassword, $user->password);
				$count++;
			}

		}

		echo sprintf("Successfully processed %s users password reset\n", $count);

		Yii::app()->esLog->log(sprintf("called user\forceResetUserPassword"), 'command', array('trigger' => 'UserCommand::actionForceResetUserPassword', 'model' => '', 'action' => '', 'id' => ''), '', array('countProcessed' => $count));
	}
}
