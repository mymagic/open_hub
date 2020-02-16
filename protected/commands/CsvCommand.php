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

class CsvCommand extends ConsoleCommand
{
	public $verbose = false;

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
