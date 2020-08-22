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

class EventCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "setActiveEventOwner2MasterOrganization - Bulk assign master organizaton to all existing active events\n";
		echo "\n";
	}

	public function actionSetActiveEventOwner2MasterOrganization()
	{
		$masterOrganizationCode = Setting::code2value('organization-master-code');
		if (!empty($masterOrganizationCode)) {
			$masterOrganization = Organization::code2obj($masterOrganizationCode);
		}

		if (empty($masterOrganization)) {
			throw new Exception('Failed to proceed as Master Organization is not set in setting');
		}

		// get all active events
		$events = Event::model()->isActive()->findAll();
		$count = 0;
		$asRoleCode = 'owner';

		// loop thru each of the events
		foreach ($events as $event) {
			// if event don't have owner with the above role code, create and assign to it
			echo $event->title . "\n";

			if (!$event->hasEventOwner($masterOrganization->code, $asRoleCode)) {
				$eventOwner = new EventOwner;
				$eventOwner->organization_code = $masterOrganization->code;
				$eventOwner->event_code = $event->code;
				$eventOwner->as_role_code = $asRoleCode;
				if ($eventOwner->save()) {
					$count++;
				}
			}
		}

		Yii::app()->esLog->log(sprintf("called event\setActiveEventOwner2MasterOrganization"), 'command', array('trigger' => 'EventCommand::actionSetActiveEventOwner2MasterOrganization', 'model' => '', 'action' => '', 'id' => ''), '', array('countAssigned' => $count));
	}
}
