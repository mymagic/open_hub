<?php

class EventCommand extends CConsoleCommand
{
    public $verbose=false;
    public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * syncRecentEvent\nSync recent event data from bizzabo thru intermediate database, plus minus 2 weeks from now\n";
		echo "  * syncEventRegistration\nSync event registration data from bizzabo thru intermediate database, with limit of latest 10000 records\n";
		echo "\n";
	}
	
	// todo: modularize
	public function actionSyncRecentEvent()
	{
		$dateStart = strtotime('2 weeks ago');
		$dateEnd = strtotime('+2 weeks');

		Yii::app()->esLog->log(sprintf("called event\syncRecentEvent"), 'command', array('trigger'=>'EventCommand::actionSyncRecentEvent', 'model'=>'', 'action'=>'', 'id'=>''), '', array('dateStart'=>$dateStart, 'dateEnd'=>$dateEnd));

		$result = HubBizzabo::syncEventFromBizzabo($dateStart, $dateEnd);
	}
	
	// todo: modularize
	public function actionSyncEventRegistration()
	{
		$limit = 10000;

		Yii::app()->esLog->log(sprintf("called event\syncEventRegistration"), 'command', array('trigger'=>'EventCommand::actionSyncEventRegistration', 'model'=>'', 'action'=>'', 'id'=>''), '', array('limit'=>$limit));

		$result = HubBizzabo::syncEventRegistrationFromBizzabo('', '', $limit);
	}

	public function actionTestEsLog()
	{
		$controller = Yii::app()->controller;
		$controller = new CController('');
		//echo empty(Yii::app()->controller)?"not found":"found";
		$log = $controller->esLog("test esLog in console", 'test', array('trigger'=>'EventCommand::actionTestEsLog', 'model'=>'', 'action'=>'', 'id'=>''));
	}
}