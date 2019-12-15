<?php

class ProfileCompletenessScoreCommand extends CConsoleCommand
{
    public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * syncCompletenessScore \n updating organization completeness score\n";
		echo "\n";
	}
	
	public function actionSyncCompletenessScore()
	{
		$i = 1;
		$y = 1;
		while($i < 5000)
		{
			$criteria = new CDbCriteria;
			$criteria->condition ="id >=$y AND id < $i+1";
			$organizations = Organization::model()->findall($criteria);
			foreach($organizations as $organization)
			{
				$tmp = $organization->score_completeness;
				
				if($organization->score_completeness !== "0")  continue;
				
				$organization->save();
				
			}
			$y = $i;
			$i = $i+100;
		}
	}
}