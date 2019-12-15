<?php

class AddOrgIDToFormSubmissionCommand extends CConsoleCommand
{
    public $verbose=false;
    public function actionIndex()
	{
		echo "Available command:\n";
        echo "  * start\nAdds org id to the form submissions json data field based on the org name.\n";
        echo "\n";
	}
	
	public function actionStart()
	{
        $submissions = FormSubmission::model()->findAll();
        foreach($submissions as $submission)
        {
            $jsonData = $submission->json_data;
            if (empty($jsonData))
            {
                echo sprintf('->json_data was empty for submission with id %s\n', $submission->id);
                continue;
            }

            $arrData = json_decode($jsonData, true);

            if(array_key_exists('startup_id', $arrData))
                continue;

            $org = Organization::title2obj($arrData['startup']);

            if (empty($org))
                echo sprintf('->organization was not found for submission with id %s\n', $submission->id);

            $arrData['startup_id'] = empty($org) ? "" : $org->id;
            $submission->jsonArray_data = $arrData;
            $submission->save();
        }
	}

}