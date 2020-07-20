<?php

use Composer\Semver\Comparator;
use Composer\Semver\Semver;

class HubOpenHub
{
	public static function getLatestRelease()
	{
		$client = new \Github\Client();

		$useCache = Yii::app()->params['cache'];
		$cacheId = sprintf('%s::%s-%s', 'HubOpenHub', 'getLatestRelease', sha1(json_encode(array('v2', Yii::app()->getModule('openHub')->gitHubOrganization, Yii::app()->getModule('openHub')->githubRepoName))));
		$return = Yii::app()->cache->get($cacheId);
		if ($return === false || $useCache === false) {
			$return = $client->api('repo')->releases()->latest(Yii::app()->getModule('openHub')->gitHubOrganization, Yii::app()->getModule('openHub')->githubRepoName);

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
		$versionReleased = self::getLatestReleaseVersion();
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
		set_time_limit(0);

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
		// industry
		// E-Commerce, Automotive, Engineering & Construction, Information & Communication
		$industryEcommerce = HUB::getOrCreateIndustry('ecommerce', array('title' => 'E-Commerce'));
		$industryMedia = HUB::getOrCreateIndustry('media-entertainment', array('title' => 'Media and Entertainment'));
		$industryEntertainment = HUB::getOrCreateIndustry('entertainment', array('title' => 'Entertainment'));
		$industryAutomotive = HUB::getOrCreateIndustry('automotive', array('title' => 'Automotive'));
		$industryIT = HUB::getOrCreateIndustry('information-communication', array('title' => 'Information & Communication'));

		//
		// resource master data
		$resourceCompetition = ResourceCategory::model()->findByAttributes(array('slug' => 'award.competition'));
		$resourceGeoFocusGlobal = ResourceGeofocus::model()->findByAttributes(array('slug' => 'global'));
		$resourceMedia = ResourceCategory::model()->findByAttributes(array('slug' => 'media.media'));

		//
		// create organization 'TechCrunch'
		$paramsTechcrunch['organization']['url_website'] = 'https://techcrunch.com/';
		$paramsTechcrunch['organization']['text_short_description'] = 'TechCrunch is an American online publisher focusing on the tech industry. The company specifically reports on the business related to tech, technology news, analysis of emerging trends in tech, and profiling of new tech businesses and products.';
		$paramsTechcrunch['organization']['inputPersonas'] = array($personaCorperate->id);
		$techcrunch = HubOrganization::getOrCreateOrganization('TechCrunch', $paramsTechcrunch);
		// resource
		$techCrunchDisrupt = Resource::model()->findByAttributes(array('slug' => 'techcrunch-disrupt'));
		if ($techCrunchDisrupt == null) {
			$techCrunchDisrupt = new Resource;
			$techCrunchDisrupt->slug = 'techcrunch-disrupt';
		}
		$techCrunchDisrupt->title = 'Techcrunch Disrupt';
		$techCrunchDisrupt->url_website = 'https://techcrunch.com/events/disrupt-sf-2020/';
		$techCrunchDisrupt->typefor = 'award';
		$techCrunchDisrupt->is_active = 1;
		$techCrunchDisrupt->html_content = 'TechCrunch Disrupt is five days of non-stop online programming with two big focuses: founders and investors shaping the future of disruptive technology and ideas and startup experts providing insights to entrepreneurs. It\'s where hundreds of startups across a variety of categories tell their stories to the 10,000 attendees from all around the world. It\'s the ultimate Silicon Valley experience where the leaders of the startup world gather to ask questions, make connections and be inspired.';
		$techCrunchDisrupt->tag_backend = 'Competition';
		$techCrunchDisrupt->inputPersonas = array($personaAspiring->id, $personaStartup->id, $personaInvestor->id);
		$techCrunchDisrupt->inputStartupStages = array($stageDiscovery->id, $stageValidation->id, $stageProductDevelopment->id, $stageEfficiency->id, $stageGrowth->id, $stageMature->id);
		$techCrunchDisrupt->inputResourceCategories = array($resourceCompetition->id);
		$techCrunchDisrupt->inputResourceGeofocuses = array($resourceGeoFocusGlobal->id);
		$techCrunchDisrupt->inputOrganizations = array($techcrunch->id);
		$techCrunchDisrupt->save(false);

		// Techcrunch
		$techCrunchMedia = Resource::model()->findByAttributes(array('slug' => 'techcrunch'));
		if ($techCrunchMedia == null) {
			$techCrunchMedia = new Resource;
			$techCrunchMedia->slug = 'techcrunch';
		}
		$techCrunchMedia->title = 'Techcrunch Media';
		$techCrunchMedia->url_website = 'https://techcrunch.com/';
		$techCrunchMedia->typefor = 'media';
		$techCrunchMedia->is_active = 1;
		$techCrunchMedia->html_content = 'TechCrunch is an American online publisher focusing on the tech industry. The company specifically reports on the business related to tech, technology news, analysis of emerging trends in tech, and profiling of new tech businesses and products.';
		$techCrunchMedia->tag_backend = 'Online Media';
		$techCrunchMedia->inputPersonas = array($personaAspiring->id, $personaStartup->id, $personaInvestor->id);
		$techCrunchMedia->inputStartupStages = array($stageDiscovery->id, $stageValidation->id, $stageProductDevelopment->id, $stageEfficiency->id, $stageGrowth->id, $stageMature->id);
		$techCrunchMedia->inputResourceCategories = array($resourceMedia->id);
		$techCrunchMedia->inputResourceGeofocuses = array($resourceGeoFocusGlobal->id);
		$techCrunchMedia->inputOrganizations = array($techcrunch->id);
		$techCrunchMedia->save(false);

		//
		// create organization 'Peter Gregory Venture'
		$peterGregoryVenture = HubOrganization::getOrCreateOrganization('Peter Gregory Venture', array('organization' => array(
			'is_active' => 1
		)));

		//
		// create organization 'Bizzabo'
		$bizzabo = HubOrganization::getOrCreateOrganization('Bizzabo', array('organization' => array(
			'is_active' => 1,
			'url_website' => 'http://www.bizzabo.com'
		)));

		//
		// create organization 'Pied Piper Inc'
		$piedPiperInc = HubOrganization::getOrCreateOrganization('Pied Piper Inc', array('organization' => array(
			'is_active' => 1,
			'url_website' => 'http://www.piedpiper.com/'
		)));

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
		$musicApp = Product::model()->findByAttributes(array('title' => 'Pied Piper Music APP', 'organization_id' => $piedPiper->id));
		if ($musicApp == null) {
			$musicApp = new Product;
			$musicApp->origanization_id = $piedPiper->id;
			$musicApp->title = 'Pied Piper Music APP';
		}
		$musicApp->typeof = 'product';
		$musicApp->text_short_description = 'A super app to compress music to save your cloud storage cost';
		$musicApp->is_active = 1;
		$musicApp->save(false);
		// revenue
		$revenue2017 = OrganizationRevenue::model()->findByAttributes(array('organization_id' => $piedPiper->id, 'year_reported' => '2017', 'amount' => '500000.00'));
		if ($revenue2017 == null) {
			$revenue2017 = new Product;
			$revenue2017->origanization_id = $piedPiper->id;
			$revenue2017->year_reported = '2017';
			$revenue2017->amount = '500000.00';
		}
		$revenue2017->source = 'crunchbase';
		$revenue2017->is_active = 1;
		$revenue2017->save(false);

		// fundings
		$fundingRuss = OrganizationFunding::model()->findByAttributes(array('organization_id' => $piedPiper->id, 'amount' => '5000000.00', 'round_type_code' => 'seriesA'));
		if ($fundingRuss == null) {
			$fundingRuss = new OrganizationFunding;
			$fundingRuss->origanization_id = $piedPiper->id;
			$fundingRuss->amount = '500000.00';
			$fundingRuss->round_type_code = 'seriesA';
		}
		$fundingRuss->vc_name = 'Russ Hanneman';
		$fundingRuss->source = 'crunchbase';
		$fundingRuss->date_raised = strtotime('27 April 2015');
		$fundingRuss->is_publicized = 1;
		$fundingRuss->save(false);

		//-- Peter Gregory Venture, 200000.00, Seed, Crunchbase, 2014 Apr 06, 24:00 AM +08:00
		$fundingPeter = OrganizationFunding::model()->findByAttributes(array('organization_id' => $piedPiper->id, 'amount' => '200000.00', 'round_type_code' => 'seed'));
		if ($fundingPeter == null) {
			$fundingPeter = new OrganizationFunding;
			$fundingPeter->origanization_id = $piedPiper->id;
			$fundingPeter->amount = '200000.00';
			$fundingPeter->round_type_code = 'seriesA';
		}
		$fundingPeter->vc_organization_id = $peterGregoryVenture->id;
		$fundingPeter->source = 'crunchbase';
		$fundingPeter->date_raised = strtotime('06 April 2014');
		$fundingPeter->is_publicized = 0;
		$fundingPeter->save(false);

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
		$paramsPiedPiperInc['organization']['is_active'] = true;
		$piedPiperInc = HubOrganization::getOrCreateOrganization('Pied Piper Inc', $paramsPiedPiperInc);
		// user access
		$piedPiperInc->setOrganizationEmail('richard@piedpiper.com');

		//
		// events
		// TechCrunch Disrupt Hackathon
		$techCrunchHackathon = HubEvent::getOrCreateEvent('TechCrunch Disrupt Hackathon', array('event' => array('url_website' => 'https://techcrunch.com/events/disrupt-sf-2020/', 'text_short_desc' => 'TechCrunch Disrupt is three days of non-stop programming with two big focuses: founders and investors shaping the future of disruptive technology and ideas and startup experts providing insights to entrepreneurs. It\'s where hundreds of startups across a variety of categories tell their stories to the 10,000 attendees from all around the world. It\'s the ultimate Silicon Valley experience where the leaders of the startup world gather to ask questions, make connections and be inspired.', 'is_paid_event' => true, 'at' => 'San Francisco', 'date_started' => strtotime('10 April 2015 09:00:00 PDT'), 'date_ended' => strtotime('12 April 2015 18:00:00 PDT'),
		'tag_backend' => 'hackathon, disrupt',
		'inputPersonas' => array($personaAspiring->id, $personaStartup->id),
		'inputStartupStages' => array($stageDiscovery->id, $stageValidation->id, $stageProductDevelopment->id),
		'inputIndustries' => array($industryIT->id))));
		// event_owner
		$eoTechCrunch = EventOwner::model()->findByAttributes(array('organization_code' => $techcrunch->code, 'event_code' => $techCrunchHackathon->code, 'as_role_code' => 'owner'));
		if ($eoTechCrunch == null) {
			$eoTechCrunch = new EventOwner;
			$eoTechCrunch->organization_code = $techcrunch->code;
			$eoTechCrunch->event_code = $techCrunchHackathon->code;
			$eoTechCrunch->as_role_code = 'owner';
		}
		$eoTechCrunch->save(false);
		$eoBizzabo = EventOwner::model()->findByAttributes(array('organization_code' => $bizzabo->code, 'event_code' => $techCrunchHackathon->code, 'as_role_code' => 'sponsor'));
		if ($eoBizzabo == null) {
			$eoBizzabo = new EventOwner;
			$eoBizzabo->organization_code = $techcrunch->code;
			$eoBizzabo->event_code = $techCrunchHackathon->code;
			$eoBizzabo->as_role_code = 'sponsor';
		}
		$eoBizzabo->save(false);
		// event_registration
		HUB::getOrCreateEventRegistration($techCrunchHackathon, 'cg36', array('email' => 'dinesh@piedpiper.com',
		'full_name' => $dinesh->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $dinesh->country_code, 'date_registered' => strtotime('01 March 2015 09:00 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		HUB::getOrCreateEventRegistration($techCrunchHackathon, 'cg34', array('email' => 'richard@piedpiper.com',
		'full_name' => $richard->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $richard->country_code, 'date_registered' => strtotime('01 March 2015 09:00 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		HUB::getOrCreateEventRegistration($techCrunchHackathon, 'cg48', array('email' => 'gilfoyle@piedpiper.com',
		'full_name' => $gilfoyle->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $gilfoyle->country_code, 'date_registered' => strtotime('01 March 2015 09:20 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		HUB::getOrCreateEventRegistration($techCrunchHackathon, 'cg49', array('email' => 'erlich@piedpiper.com', 'full_name' => $erlich->full_name, 'organization' => $piedPiper->title, 'persona' => $personaInvestor->title, 'paid_fee' => 120, 'nationality' => $erlich->country_code, 'date_registered' => strtotime('01 March 2015 09:30 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));

		// RussFest
		$russFest = HubEvent::getOrCreateEvent('RussFest', array('event' => array('url_website' => 'https://www.russfest.net/', 'text_short_desc' => 'This is gonna be the mother of all festivals!', 'is_paid_event' => true, 'at' => 'Area 51, Nevada', 'full_address' => '2711 US-95, Amargosa Valley, NV 89020, United States', 'date_started' => strtotime('20 May 2020 08:00:00 PDT'), 'date_ended' => strtotime('22 May 2020 00:00:00 PDT'), 'tag_backend' => 'festival, party',
		'inputPersonas' => array($personaAspiring->id, $personaStartup->id),
		'inputStartupStages' => array($stageDiscovery->id, $stageValidation->id, $stageProductDevelopment->id, $stageEfficiency->id, $stageGrowth->id),
		'inputIndustries' => array($industryIT->id, $industryEcommerce->id, $industryAutomotive->id))));
		// event_registration
		HUB::getOrCreateEventRegistration($russFest, 'yt4t36', array('email' => 'dinesh@piedpiper.com',
		'full_name' => $dinesh->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $dinesh->country_code, 'date_registered' => strtotime('02 April 2020 09:00 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		HUB::getOrCreateEventRegistration($russFest, 'yt4t33', array('email' => 'richard@piedpiper.com',
		'full_name' => $richard->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $richard->country_code, 'date_registered' => strtotime('03 April 2020 09:00 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		HUB::getOrCreateEventRegistration($russFest, 'yt4t35', array('email' => 'gilfoyle@piedpiper.com',
		'full_name' => $gilfoyle->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $gilfoyle->country_code, 'date_registered' => strtotime('04 April 2020 09:20 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		HUB::getOrCreateEventRegistration($russFest, 'yt4t34', array('email' => 'jared@piedpiper.com',
		'full_name' => $jared->full_name, 'organization' => $piedPiper->title, 'persona' => $personaAspiring->title, 'paid_fee' => 120, 'nationality' => $jared->country_code, 'date_registered' => strtotime('04 April 2020 09:30 PDT'), 'is_attended' => 1, 'event_vendor_code' => 'manual'));
		// event_organization
		$eorgPiedPiper = EventOrganization::model()->findByAttributes(array('organization_id' => $piedPiper->id, 'event_code' => $russFest->code, 'as_role_code' => 'provider'));
		if ($eorgPiedPiper == null) {
			$eorgPiedPiper = new EventOrganization;
			$eorgPiedPiper->organization_id = $piedPiper->id;
			$eorgPiedPiper->event_code = $russFest->code;
			$eorgPiedPiper->as_role_code = 'provider';
		}
		$eorgPiedPiper->save(false);
		// event_registration

		return array('status' => 'success', 'msg' => Yii::t('openHub', 'Successfully loaded Demo data into this installation'), 'data' => array());
	}
}
