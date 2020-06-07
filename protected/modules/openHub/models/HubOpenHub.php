<?php

use Composer\Semver\Comparator;
use Composer\Semver\Semver;

class HubOpenHub
{
	public static function getLatestRelease()
	{
		$client = new \Github\Client();

		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HubOpenHub', 'getLatestRelease', sha1(json_encode(array('v2', Yii::app()->getModule('openHub')->githubOrganization, Yii::app()->getModule('openHub')->githubRepoName))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = $client->api('repo')->releases()->latest(Yii::app()->getModule('openHub')->githubOrganization, Yii::app()->getModule('openHub')->githubRepoName);

			// cache for 5min
			Yii::app()->cache->set($cacheId, $return, 300);
		}

		return $return;
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
	public static function getUpgradeInfo()
	{
		$versionRunning = YeeBase::getVersionWithoutBuild();
		$versionReleased = HubOpenHub::getLatestReleaseVersion();
		$canUpgrade = Comparator::greaterThan($versionReleased, $versionRunning);

		return array(
			'versionRunning' => $versionRunning,
			'versionReleased' => $versionReleased,
			'canUpgrade' => $canUpgrade,
			'latestRelease' => self::getLatestRelease()
		);
	}

	public static function getUrlLatestRelease()
	{
		return sprintf('%s/release/openhub-latest.zip', Yii::app()->getModule('openHub')->githubReleaseUrl);
	}

	public static function loadDemoData()
	{
		$personaCorperate = Hub::getOrCreatePersona('Corporate', array('slug' => 'corporate'));
		$personaStartup = Hub::getOrCreatePersona('Startups', array('slug' => 'startups'));
		$personaInvestor = Hub::getOrCreatePersona('Investor / VC', array('slug' => 'investor'));

		//
		// create organization 'TechCrunch'
		$paramsTechcrunch['organization']['url_website'] = 'https://techcrunch.com/';
		$paramsTechcrunch['organization']['text_short_description'] = 'TechCrunch is an American online publisher focusing on the tech industry. The company specifically reports on the business related to tech, technology news, analysis of emerging trends in tech, and profiling of new tech businesses and products.';
		$paramsTechcrunch['organization']['inputPersonas'] = array($personaCorperate->id);
		$techcrunch = HubOrganization::getOrCreateOrganization('TechCrunch', $paramsTechcrunch);
		// resource
		// Techcrunch Disrupt
		//-- techcrunch-disrupt, https://techcrunch.com/events/disrupt-sf-2020/, Award, TechCrunch Disrupt is five days of non-stop online programming with two big focuses: founders and investors shaping the future of disruptive technology and ideas and startup experts providing insights to entrepreneurs. It's where hundreds of startups across a variety of categories tell their stories to the 10,000 attendees from all around the world. It's the ultimate Silicon Valley experience where the leaders of the startup world gather to ask questions, make connections and be inspired.
		//-- Aspiring Entrepreneurs, Startups, Investor / VC
		//-- Discovery, Validation, Development, Efficiency, Growth, Mature
		//-- Competition
		//-- Malaysia, Global

		// Techcrunch
		//-- techcrunch, 	https://techcrunch.com/, Media,TechCrunch is an American online publisher focusing on the tech industry. The company specifically reports on the business related to tech, technology news, analysis of emerging trends in tech, and profiling of new tech businesses and products.
		//-- Aspiring Entrepreneurs, Startups, Investor / VC
		//-- Discovery, Validation, Development, Efficiency, Growth, Mature
		//-- Media
		//-- Malaysia, Global

		//
		// create organization 'Pied Piper'
		$paramsPiedPiper['organization']['url_website'] = 'http://www.piedpiper.com/';
		$paramsPiedPiper['organization']['email_contact'] = 'hello@piedpiper.com';
		$paramsPiedPiper['organization']['year_founded'] = '2014';
		$paramsPiedPiper['organization']['full_address'] = '2 New Montgomery St, San Francisco, CA 94105, United States';
		$paramsPiedPiper['organization']['text_oneliner'] = 'Pied Piper is a multi-platform technology based on a proprietary universal compression algorithm that approach the theoretical limit of loseless compression.';
		$paramsPiedPiper['organization']['text_short_description'] = "In its original incarnation, Pied Piper was a songwriter-originted music app that made it easier for songwriters to determine if their work infringed on other's copyright. And frankly, we still think that wasn't a terrible idea, and we were kind of looking forward to doing it, because who doesn't like music, right?\n\n
		However, based on user feedback that was suboptimal and on occasion downright mean, we are now currently pivoting to a SaaS model to create a new \"Compression Cloud\" solution that covers a far wider user base. This new strategy brings us a clearer path to monetization and helps us even avoid the crappy licensing models for Lempel-Ziv-Welch in .gif files (among others). Because Lord knows, there aren't enough compressed .gif files in the world that have cats making faces with rap lyrics underneath them.\n\n
		But it is safe to say, we intend to deploy an integrated, multi-platform functionality of all conceivable applications of the algorithm, that we hope will make the world abetter place through compression services across diversified market segment.";
		$paramsPiedPiper['organization']['tag_backend'] = 'compression, saas';
		$paramsPiedPiper['organization']['inputPersonas'] = array($personaStartup->id);
		$piedPiper = HubOrganization::getOrCreateOrganization('Pied Piper', $paramsPiedPiper);
		// user access
		$piedPiper->setOrganizationEmail('richard@piedpiper.com');
		$piedPiper->setOrganizationEmail('dinesh@piedpiper.com');
		$piedPiper->setOrganizationEmail('erlich@piedpiper.com', 'reject');
		$piedPiper->setOrganizationEmail('gilfoyle@piedpiper.com', 'pending');
		$piedPiper->setOrganizationEmail('jared@piedpiper.com', 'pending');
		// individual
		$richard = HubIndividual::getOrCreateIndividual('Richard Hendricks', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'richard@piedpiper.com'));
		$dinesh = HubIndividual::getOrCreateIndividual('Dinesh Chugtai', array('individual' => array('gender' => 'male'), 'userEmail' => 'dinesh@piedpiper.com'));
		$jared = HubIndividual::getOrCreateIndividual('Jared Donald Dunn', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'jared@piedpiper.com'));
		$gilfoyle = HubIndividual::getOrCreateIndividual('Bertram Gilfoyle', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'gilfoyle@piedpiper.com'));
		$erlich = HubIndividual::getOrCreateIndividual('Erlich Bachman', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'erlich@piedpiper.com'));
		$anton = HubIndividual::getOrCreateIndividual('Son of Anton', array('individual' => array('country_code' => 'US'), 'userEmail' => 'gilfoyle@piedpiper.com'));
		$piedPiper->addIndividualOrganization($richard, 'founder', array('job_position' => 'CEO'));
		$piedPiper->addIndividualOrganization($jared, 'cofounder', array('job_position' => 'COO'));
		$piedPiper->addIndividualOrganization($dinesh, 'cofounder', array('job_position' => 'Lead Engineer'));
		$piedPiper->addIndividualOrganization($erlich, 'founder', array('job_position' => 'Chief PR Officer & Chief Evangelism Officer'));
		// product
		// -- Pied Piper Music APP, A super app to compress music to save your cloud storage cost
		// fundings
		//-- Peter Gregory Venture, 200000.00, Seed, Crunchbase, 2014 Apr 06, 24:00 AM +08:00
		//-- Russ Hanneman, 5000000.00, Series A, crunchbase, 2015 Apr 27, 24:00 AM +08:00
		// revenue
		//-- 2017, 500000.00, crunchbase

		//
		// create organization 'Aviato'
		$paramsAviato['organization']['inputPersonas'] = array($personaStartup->id);
		$paramsAviato['organization']['url_website'] = 'http://www.aviato.com';
		$paramsAviato['organization']['year_founded'] = '2012';
		$paramsAviato['organization']['text_oneliner'] = 'Aviato is a software aggregation program that takes all the information from social media.';
		$aviato = HubOrganization::getOrCreateOrganization('Aviato', $paramsAviato);
		// user access
		$aviato->setOrganizationEmail('erlich@piedpiper.com');
		// individual
		$erlich = HubIndividual::getOrCreateIndividual('Erlich Bachman', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'erlich@aviato.com'));
		$aviato->addIndividualOrganization($erlich, 'founder');

		//
		// create organization 'Peter Geogory Venture'
		$paramsPeterGregoryVenture['organization']['inputPersonas'] = array($personaInvestor->id);
		$peterGregoryVenture = HubOrganization::getOrCreateOrganization('Peter Gregory Venture', $paramsPeterGregoryVenture);

		//
		// create organization 'Bizzabo'
		$paramsBizzabo['organization']['inputPersonas'] = array($personaStartup->id);
		$paramsBizzabo['organization']['url_website'] = 'http://www.bizzabo.com';
		$bizzabo = HubOrganization::getOrCreateOrganization('Bizzabo', $paramsBizzabo);

		//
		// create organization 'Pied Piper Inc'
		$paramsPiedPiperInc['organization']['inputPersonas'] = array($personaStartup->id);
		$paramsPiedPiperInc['organization']['url_website'] = 'http://www.piedpiper.com/';
		$piedPiperInc = HubOrganization::getOrCreateOrganization('Pied Piper Inc', $paramsPiedPiperInc);
		// user access
		$piedPiperInc->setOrganizationEmail('richard@piedpiper.com');

		//
		// events
		// TechCrunch Disrupt Hackathon
		//-- https://techcrunch.com/events/disrupt-sf-2020/, TechCrunch Disrupt is three days of non-stop programming with two big focuses: founders and investors shaping the future of disruptive technology and ideas and startup experts providing insights to entrepreneurs. It's where hundreds of startups across a variety of categories tell their stories to the 10,000 attendees from all around the world. It's the ultimate Silicon Valley experience where the leaders of the startup world gather to ask questions, make connections and be inspired.,2015 Apr 10, 24:00 AM +08:00 - 2015 Apr 10, 24:00 AM +08:00, is paid, 	San Francisco
		//-- owner: TechCrunch (owner), Bizzabo (sponsor)
		//-- dinesh@piedpiper.com, erlich@piedpiper.com, gilfoyle@piedpiper.com, 	richard@piedpiper.com
		//-- Discovery, Validation, Development
		//-- Aspiring Entrepreneurs, Startups
		//--tags: hackathon

		// RussFest
		//-- Area 51, Nevada, This is gonna be the mother of all festivals!, https://www.russfest.net/, 2020 May 20, 24:00 AM +08:00 - 	2020 May 22, 24:00 AM +08:00, manual
		//-- E-Commerce, Automotive, Engineering & Construction, Information & Communication
		//-- Aspiring Entrepreneurs, Startups
		//-- Discovery, Validation, Development, Efficiency, Growth
		//-- dinesh@piedpiper.com, gilfoyle@piedpiper.com, jared@piedpiper.com, 	richard@piedpiper.com
		//-- Pied Piper
	}
}
