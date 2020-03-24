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

class EmailSurveyAfterEventCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * oneDayAfter\nemails one day after event end date.\n * sixMonthsAfter\nemails six months after event end date.";
		echo "\n";
	}

	public function actionOneDayAfter()
	{
		// surveyType: 1Day
		HubEvent::sendSurveyEmailAfterEvent('1Day');

		Yii::app()->esLog->log(sprintf("called emailSurveyAfterEvent\oneDayAfter"), 'command', array('trigger' => 'EmailSurveyAfterEventCommand::actionOneDayAfter', 'model' => '', 'action' => '', 'id' => ''), '', array());
	}

	public function actionSixMonthsAfter()
	{
		// surveyType: 6Months
		// temporary disabled
		//HubEvent::sendSurveyEmailAfterEvent('6Months');

		// Yii::app()->esLog->log(sprintf("called emailSurveyAfterEvent\sixMonthsAfter"), 'command', array('trigger' => 'EmailSurveyAfterEventCommand::actionSixMonthsAfter', 'model' => '', 'action' => '', 'id' => ''), '', array());
	}
}
