<?php

class F7Command extends ConsoleCommand
{
	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * syncToEvent\n";
	}

	public function actionSyncToEvent()
	{
		HubForm::SyncSubmissionsToEvent();
	}
}
