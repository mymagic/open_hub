<?php

class Neo4jCommand extends ConsoleCommand
{
	public $verbose = false;

	public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * sync \nSync Neo4j with current DB\n";
	}

	public function actionSync()
	{
		Neo4jPersona::model()->dbSync();
		echo "\nPersona synced\n";
		Neo4jIndustry::model()->dbSync();
		echo "\nIndustry synced\n";
		Neo4jStartupStage::model()->dbSync();
		echo "\nStartupStage synced\n";
		Neo4jSdg::model()->dbSync();
		echo "\nSdg synced\n";
		Neo4jCluster::model()->dbSync();
		echo "\nCluster synced\n";
		Neo4jChallenge::model()->dbSync();
		echo "\nChallenge synced\n";
		Neo4jEvent::model()->dbSync();
		echo "\nEvent synced\n";
		Neo4jInterest::model()->dbSync();
		echo "\nInterest synced\n";
		Neo4jResource::model()->dbSync();
		echo "\nResource synced\n";
	}
}
