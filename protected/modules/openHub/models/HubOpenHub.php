<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

class HubOpenHub
{
	public static function getLatestRelease()
	{
		$client = new \Github\Client();
		$result = $client->api('repo')->releases()->latest(Yii::app()->getModule('openHub')->githubOrganization, Yii::app()->getModule('openHub')->githubRepoName);

		return $result;
	}
}
