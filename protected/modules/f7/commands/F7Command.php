<?php

class F7Command extends ConsoleCommand
{
	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * fixEmptyStartupId --formId=0\n";
		echo "  * \n";
	}

	public function actionFixEmptyStartupId($formId = '')
	{
		// find form_submission with empty startup_id
		$sql = sprintf("SELECT u.username as username, json_value(s.json_data, '$.startup') as startup, json_value(s.json_data, '$.startup_id') as startup_id, s.id, s.json_data FROM form_submission as s JOIN form f ON s.form_code = f.code LEFT JOIN user as u ON u.id=s.user_id WHERE %s AND (JSON_TYPE(JSON_EXTRACT(s.json_data, '$.startup_id')) = 'NULL')", !empty($formId) ? 'f.id=' . $formId : '1=1');

		$command = Yii::app()->db->createCommand($sql);
		$records = $command->queryAll();

		// loop thru each of these
		foreach ($records as $record) {
			echo sprintf("%s - %s\n", $record['username'], $record['id']);
			// find matching organization title
			$params['userEmail'] = $record['username'];
			if (!empty(trim($record['startup']))) {
				try {
					$organization = HubOrganization::getOrCreateOrganization($record['startup'], $params);

					$formSubmission = FormSubmission::model()->findByPk($record['id']);
					$formSubmission->jsonArray_data->startup_id = $organization->id;
					if ($formSubmission->save()) {
						echo "--save\n";
					} else {
						echo "--failed due to unable to save form submission\n";
					}
				} catch (Exception $e) {
					echo sprintf("--failed due to: %s\n", $e->getMessage());
				}
			} else {
				echo "--failed due to empty startup name\n";
			}
		}

		Yii::app()->esLog->log(sprintf("called f7\fixEmptyStartupId"), 'command', array('trigger' => 'F7Command::actionFixEmptyStartupId', 'model' => '', 'action' => '', 'id' => ''), '', array('formId' => $formId));
	}
}
