<?php

class CsvCommand extends CConsoleCommand
{
    public $verbose=false;
    public function actionIndex()
	{
		echo "Available command:\n";
        echo "importOrganization <PATH_TO_CSV> - Import Organizations from CSV\n";
        echo "importOrganizationEvent <PATH_TO_CSV> - Import Organizations Event from CSV\n";
        echo "importOrganizationStatus <PATH_TO_CSV> - Import Organizations Status from CSV\n";
        echo "importImportOrganizationFunding <PATH_TO_CSV> - Import Organizations Funding from CSV\n";
        echo "importImportOrganizationRevenue <PATH_TO_CSV> - Import Organizations Revenue from CSV\n";
        echo "\n";
	}
	
    public function actionImportOrganization($csvfile)
	{
        $result = Csv::importOrgCSV($csvfile);        
    }

    public function actionImportOrganizationEvent($csvfile)
    {
        $result = Csv::importEventOrgCSV($csvfile);
    }

    public function actionImportOrganizationStatus($csvfile)
    {
        $result = Csv::importOrgStatusCSV($csvfile);
    }

    public function actionImportOrganizationFunding($csvfile)
    {
        $result = Csv::importOrgFundingCSV($csvfile);
    }

    public function actionImportOrganizationRevenue($csvfile)
    {
        $result = Csv::importOrgRevenueCSV($csvfile);
    }
    
}