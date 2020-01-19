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

class ProfileCompletenessScoreCommand extends ConsoleCommand
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
		while ($i < 5000) {
			$criteria = new CDbCriteria;
			$criteria->condition = "id >=$y AND id < $i+1";
			$organizations = Organization::model()->findall($criteria);
			foreach ($organizations as $organization) {
				$tmp = $organization->score_completeness;

				if ($organization->score_completeness !== '0') {
					continue;
				}

				$organization->save();
			}
			$y = $i;
			$i = $i + 100;
		}
	}
}
