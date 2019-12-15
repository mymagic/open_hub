<?php

class EmailSurveyAfterEventCommand extends CConsoleCommand
{
    public $verbose=false;
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

		Yii::app()->esLog->log(sprintf("called emailSurveyAfterEvent\oneDayAfter"), 'command', array('trigger'=>'EmailSurveyAfterEventCommand::actionOneDayAfter', 'model'=>'', 'action'=>'', 'id'=>''), '', array());
    }
    
    public function actionSixMonthsAfter()
	{
		// surveyType: 6Months
		// temporary disabled
		//HubEvent::sendSurveyEmailAfterEvent('6Months');

		Yii::app()->esLog->log(sprintf("called emailSurveyAfterEvent\sixMonthsAfter"), 'command', array('trigger'=>'EmailSurveyAfterEventCommand::actionSixMonthsAfter', 'model'=>'', 'action'=>'', 'id'=>''), '', array());
	}
}