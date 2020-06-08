<?php

use Composer\Semver\Comparator;
use Composer\Semver\Semver;

class HUBOpenHUB
{
	public static function getLatestRelease()
	{
		$client = new \Github\Client();

		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HUBOpenHUB', 'getLatestRelease', sha1(json_encode(array('v2', Yii::app()->getModule('openHUB')->githubOrganization, Yii::app()->getModule('openHUB')->githubRepoName))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = $client->api('repo')->releases()->latest(Yii::app()->getModule('openHUB')->githubOrganization, Yii::app()->getModule('openHUB')->githubRepoName);

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
		$versionReleased = HUBOpenHUB::getLatestReleaseVersion();
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
		return sprintf('%s/release/openhub-latest.zip', Yii::app()->getModule('openHUB')->githubReleaseUrl);
	}

	public static function loadDemoData()
	{
		//
		// persona
		$personaAspiring = HUB::getOrCreatePersona('student', array('title' => 'Aspiring Entrepreneurs'));
		$personaStartup = HUB::getOrCreatePersona('startups', array('title' => 'Startups'));
		$personaSe = HUB::getOrCreatePersona('se', array('title' => 'Social Enterprise'));
		$personaCorperate = HUB::getOrCreatePersona('corporate', array('title' => 'Corporate'));
		$personaGovernment = HUB::getOrCreatePersona('government', array('title' => 'Government Ministry / Agencies'));
		$personaInvestor = HUB::getOrCreatePersona('investor', array('title' => 'Investor / VC'));

		//
		// startup stages
		$stageDiscovery = HUB::getOrCreateStartupStage('discovery', array('title' => 'Discovery', 'text_short_description' => 'At Discovery Stage, you learn about ideating your startup. You mostly spent time educating about startup and attending related events.', 'ordering' => '1'));
		$stageValidation = HUB::getOrCreateStartupStage('validation', array('title' => 'Validation', 'text_short_description' => 'At Validation Stage, you learn about Minimum Viable Product & Prototype. You also learn about early customers & iteration.', 'ordering' => '2'));
		$stageProductDevelopment = HUB::getOrCreateStartupStage('product_development', array('title' => 'Product Development', 'text_short_description' => 'At Product Development Stage, you works on developing the product and acquiring early user.', 'ordering' => '3'));
		$stageEfficiency = HUB::getOrCreateStartupStage('efficiency', array('title' => 'Efficiency', 'text_short_description' => 'At Efficiency Stage, you would achieve Product / Market Fit and monetization. You focus on product marketing and user acquisition.', 'ordering' => '4'));
		$stageGrowth = HUB::getOrCreateStartupStage('growth', array('title' => 'Growth', 'text_short_description' => 'At Growth Stage, you are expanding your market or introducing new product lines. You also focus in achieving exponential user growth.', 'ordering' => '5'));
		$stageMature = HUB::getOrCreateStartupStage('mature', array('title' => 'Mature', 'text_short_description' => 'At Mature Stage, you achieve significant revenue and scale to global markets. You also plan for exit strategy and future growth.', 'ordering' => '6'));

		//
		// create organization 'TechCrunch'
		$paramsTechcrunch['organization']['url_website'] = 'https://techcrunch.com/';
		$paramsTechcrunch['organization']['text_short_description'] = 'TechCrunch is an American online publisher focusing on the tech industry. The company specifically reports on the business related to tech, technology news, analysis of emerging trends in tech, and profiling of new tech businesses and products.';
		$paramsTechcrunch['organization']['inputPersonas'] = array($personaCorperate->id);
		$techcrunch = HUBOrganization::getOrCreateOrganization('TechCrunch', $paramsTechcrunch);
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
		$piedPiper = HUBOrganization::getOrCreateOrganization('Pied Piper', $paramsPiedPiper);
		// user access
		$piedPiper->setOrganizationEmail('richard@piedpiper.com');
		$piedPiper->setOrganizationEmail('dinesh@piedpiper.com');
		$piedPiper->setOrganizationEmail('erlich@piedpiper.com', 'reject');
		$piedPiper->setOrganizationEmail('gilfoyle@piedpiper.com', 'pending');
		$piedPiper->setOrganizationEmail('jared@piedpiper.com', 'pending');
		// individual
		$richard = HUBIndividual::getOrCreateIndividual('Richard Hendricks', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'richard@piedpiper.com'));
		$dinesh = HUBIndividual::getOrCreateIndividual('Dinesh Chugtai', array('individual' => array('gender' => 'male'), 'userEmail' => 'dinesh@piedpiper.com'));
		$jared = HUBIndividual::getOrCreateIndividual('Jared Donald Dunn', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'jared@piedpiper.com'));
		$gilfoyle = HUBIndividual::getOrCreateIndividual('Bertram Gilfoyle', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'gilfoyle@piedpiper.com'));
		$erlich = HUBIndividual::getOrCreateIndividual('Erlich Bachman', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'erlich@piedpiper.com'));
		$anton = HUBIndividual::getOrCreateIndividual('Son of Anton', array('individual' => array('country_code' => 'US'), 'userEmail' => 'gilfoyle@piedpiper.com'));
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
		$aviato = HUBOrganization::getOrCreateOrganization('Aviato', $paramsAviato);
		// user access
		$aviato->setOrganizationEmail('erlich@piedpiper.com');
		// individual
		$erlich = HUBIndividual::getOrCreateIndividual('Erlich Bachman', array('individual' => array('gender' => 'male', 'country_code' => 'US'), 'userEmail' => 'erlich@aviato.com'));
		$aviato->addIndividualOrganization($erlich, 'founder');

		//
		// create organization 'Peter Geogory Venture'
		$paramsPeterGregoryVenture['organization']['inputPersonas'] = array($personaInvestor->id);
		$peterGregoryVenture = HUBOrganization::getOrCreateOrganization('Peter Gregory Venture', $paramsPeterGregoryVenture);

		//
		// create organization 'Bizzabo'
		$paramsBizzabo['organization']['inputPersonas'] = array($personaStartup->id);
		$paramsBizzabo['organization']['url_website'] = 'http://www.bizzabo.com';
		$bizzabo = HUBOrganization::getOrCreateOrganization('Bizzabo', $paramsBizzabo);

		//
		// create organization 'Pied Piper Inc'
		$paramsPiedPiperInc['organization']['inputPersonas'] = array($personaStartup->id);
		$paramsPiedPiperInc['organization']['url_website'] = 'http://www.piedpiper.com/';
		$piedPiperInc = HUBOrganization::getOrCreateOrganization('Pied Piper Inc', $paramsPiedPiperInc);
		// user access
		$piedPiperInc->setOrganizationEmail('richard@piedpiper.com');

		//
		// events
		// TechCrunch Disrupt Hackathon
		$techCrunchHackathon = HUBEvent::getOrCreateEvent('TechCrunch Disrupt Hackathon', array('event' => array('url_website' => 'https://techcrunch.com/events/disrupt-sf-2020/', 'text_short_desc' => 'TechCrunch Disrupt is three days of non-stop programming with two big focuses: founders and investors shaping the future of disruptive technology and ideas and startup experts providing insights to entrepreneurs. It\'s where hundreds of startups across a variety of categories tell their stories to the 10,000 attendees from all around the world. It\'s the ultimate Silicon Valley experience where the leaders of the startup world gather to ask questions, make connections and be inspired.', 'is_paid_event' => true, 'at' => 'San Francisco', 'date_started' => strtotime('10 April 2015 09:00:00 PDT'), 'date_ended' => strtotime('12 April 2015 18:00:00 PDT'), 'tag_backend' => 'hackathon, disrupt',
		'inputPersonas' => array($personaAspiring->id, $personaStartup->id),
		'inputStartupStages' => array($stageDiscovery->id, $stageValidation->id, $stageProductDevelopment->id))));
		//-- owner: TechCrunch (owner), Bizzabo (sponsor)
		//-- dinesh@piedpiper.com, erlich@piedpiper.com, gilfoyle@piedpiper.com, 	richard@piedpiper.com

		// RussFest
		$russFest = HUBEvent::getOrCreateEvent('RussFest', array('event' => array('url_website' => 'https://www.russfest.net/', 'text_short_desc' => 'This is gonna be the mother of all festivals!', 'is_paid_event' => true, 'at' => 'Area 51, Nevada', 'full_address' => '2711 US-95, Amargosa Valley, NV 89020, United States', 'date_started' => strtotime('20 May 2020 08:00:00 PDT'), 'date_ended' => strtotime('22 May 2020 00:00:00 PDT'), 'tag_backend' => 'festival, party',
		'inputPersonas' => array($personaAspiring->id, $personaStartup->id),
		'inputStartupStages' => array($stageDiscovery->id, $stageValidation->id, $stageProductDevelopment->id, $stageEfficiency->id, $stageGrowth->id))));
		//-- E-Commerce, Automotive, Engineering & Construction, Information & Communication
		//-- dinesh@piedpiper.com, gilfoyle@piedpiper.com, jared@piedpiper.com, 	richard@piedpiper.com
		//-- Pied Piper
	}
}
