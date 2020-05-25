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

	/*
	Array
	(
		[url] => https://api.github.com/repos/mymagic/open_hub/releases/26803730
		[assets_url] => https://api.github.com/repos/mymagic/open_hub/releases/26803730/assets
		[upload_url] => https://uploads.github.com/repos/mymagic/open_hub/releases/26803730/assets{?name,label}
		[html_url] => https://github.com/mymagic/open_hub/releases/tag/v0.5.213
		[id] => 26803730
		[node_id] => MDc6UmVsZWFzZTI2ODAzNzMw
		[tag_name] => v0.5.213
		[target_commitish] => master
		[name] => Version 0.5.213
		[draft] =>
		[author] => Array
			(
				[login] => exiang
				[id] => 5336690
				[node_id] => MDQ6VXNlcjUzMzY2OTA=
				[avatar_url] => https://avatars2.githubusercontent.com/u/5336690?v=4
				[gravatar_id] =>
				[url] => https://api.github.com/users/exiang
				[html_url] => https://github.com/exiang
				[followers_url] => https://api.github.com/users/exiang/followers
				[following_url] => https://api.github.com/users/exiang/following{/other_user}
				[gists_url] => https://api.github.com/users/exiang/gists{/gist_id}
				[starred_url] => https://api.github.com/users/exiang/starred{/owner}{/repo}
				[subscriptions_url] => https://api.github.com/users/exiang/subscriptions
				[organizations_url] => https://api.github.com/users/exiang/orgs
				[repos_url] => https://api.github.com/users/exiang/repos
				[events_url] => https://api.github.com/users/exiang/events{/privacy}
				[received_events_url] => https://api.github.com/users/exiang/received_events
				[type] => User
				[site_admin] =>
			)

		[prerelease] =>
		[created_at] => 2020-05-22T15:30:50Z
		[published_at] => 2020-05-22T15:33:20Z
		[assets] => Array
			(
			)

		[tarball_url] => https://api.github.com/repos/mymagic/open_hub/tarball/v0.5.213
		[zipball_url] => https://api.github.com/repos/mymagic/open_hub/zipball/v0.5.213
		[body] => - added MODULE_DISABLE_NONE_CORE to [.env] and configurations
	- added package intervention/httpauth from [composer] to safeguard WAPI with basic auth
	)
	*/
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

	public static function getUrlLatestRelease()
	{
		return sprintf('%s/release/openhub-latest.zip', Yii::app()->getModule('openHub')->githubReleaseUrl);
	}
}
