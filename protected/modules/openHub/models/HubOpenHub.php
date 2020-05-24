<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

use Composer\Semver\Comparator;
use Composer\Semver\Semver;

class HubOpenHub
{
	public static function getLatestRelease()
	{
		$client = new \Github\Client();
		$result = $client->api('repo')->releases()->latest(Yii::app()->getModule('openHub')->githubOrganization, Yii::app()->getModule('openHub')->githubRepoName);

		return $result;
	}

	public static function getLatestReleaseVersion()
	{
		$result = self::getLatestRelease();

		return str_replace(array('-', ' ', 'v', 'version'), '', strtolower($result['tag_name']));
	}

	public static function getUpdateInfo()
	{
		$versionRunning = Yii::app()->controller->getVersionWithoutBuild();
		$versionReleased = HubOpenHub::getLatestReleaseVersion();
		$canUpdate = Comparator::greaterThan($versionReleased, $versionRunning);

		return array(
			'versionRunning' => $versionRunning,
			'versionReleased' => $versionReleased,
			'canUpdate' => $canUpdate,
			'latestRelease' => self::getLatestRelease()
		);
	}
}
