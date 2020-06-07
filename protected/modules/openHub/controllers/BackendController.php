<?php

use Exiang\YsUtil\YsUtil;

class BackendController extends Controller
{
	// customParse is for cpanelNavOrganizationInformation to pass in organization ID
	//public $customParse = '';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions' => array('index', 'upgrade', 'doUpgrade', 'loadDemoDataConfirmed'),
				'users' => array('@'),
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->layout = 'backend';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionUpgrade()
	{
		set_time_limit(0);

		Yii::app()->user->setState('keyUpgrade', YsUtil::generateUUID());
		$upgradeInfo = HubOpenHub::getUpgradeInfo();
		$this->render(
			'upgrade',
			$upgradeInfo
		);
	}

	public function actionDoUpgrade($key)
	{
		set_time_limit(0);

		$pathProtected = dirname(Yii::getPathOfAlias('runtime'), 1);
		// $pathOutput = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'exec' . DIRECTORY_SEPARATOR . $key . '.OpenHub-BackendController-actionUpgrade.txt';
		$command = sprintf('php %s/yiic openhub upgrade --key=%s', $pathProtected, $key);
		//$command = sprintf('php %s/yiic openhub downloadLatestRelease', $pathProtected);

		ob_end_clean();
		if (ob_get_level() > 0) {
			exit("That's why!" . ob_get_level());
		}

		ob_end_flush();
		ini_set('output_buffering', '0');
		ob_implicit_flush(true);
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		$proc = popen($command, 'r');
		while (!feof($proc)) {
			$this->echoEvent(fread($proc, 4096));
		}
		pclose($proc);
	}

	public function echoEvent($string)
	{
		echo 'data: ' . implode("\ndata: ", explode("\n", $string)) . "\n\n";
	}

	public function actionLoadDemoDataConfirmed()
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
		$paramsPiedPiper['organization']['inputPersonas'] = array($personaStartup->id);
		$piedPiper = HubOrganization::getOrCreateOrganization('Pied Piper', $paramsPiedPiper);
		// user access
		$piedPiper->setOrganizationEmail('richard@piedpiper.com');
		$piedPiper->setOrganizationEmail('dinesh@piedpiper.com');
		$piedPiper->setOrganizationEmail('erlich@piedpiper.com');
		$piedPiper->setOrganizationEmail('gilfoyle@piedpiper.com', 'pending');
		$piedPiper->setOrganizationEmail('jared@piedpiper.com', 'pending');
		// individual
		$richard = HubIndividual::getOrCreateIndividual('Richard Hendricks', array('gender' => 'male', 'country_code' => 'US', 'userEmail' => 'richard@piedpiper.com'));
		$jared = HubIndividual::getOrCreateIndividual('Jared Donald Dunn', array('gender' => 'male', 'country_code' => 'US', 'userEmail' => 'jared@piedpiper.com'));
		$dinesh = HubIndividual::getOrCreateIndividual('Dinesh Chugtai', array('gender' => 'male', 'country_code' => 'US', 'userEmail' => 'dinesh@piedpiper.com'));
		$gilfoyle = HubIndividual::getOrCreateIndividual('Bertram Gilfoyle', array('gender' => 'male', 'country_code' => 'US', 'userEmail' => 'gilfoyle@piedpiper.com'));
		$erlich = HubIndividual::getOrCreateIndividual('Erlich Bachman', array('gender' => 'male', 'country_code' => 'US', 'userEmail' => 'erlich@piedpiper.com'));
		$anton = HubIndividual::getOrCreateIndividual('Son of Anton', array('country_code' => 'US', 'userEmail' => 'gilfoyle@piedpiper.com'));
		$piedPiper->addIndividualOrganization($richard, 'founder', array('job_position' => 'CEO'));
		$piedPiper->addIndividualOrganization($jared, 'cofounder', array('job_position' => 'COO'));
		$piedPiper->addIndividualOrganization($dinesh, 'cofounder', array('job_position' => 'Lead Engineer'));
		$piedPiper->addIndividualOrganization($erlich, 'founder', array('job_position' => 'Chief PR Officer & Chief Evangelism Officer'));

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
		$erlich = HubIndividual::getOrCreateIndividual('Erlich Bachman', array('gender' => 'male', 'country_code' => 'US', 'userEmail' => 'erlich@aviato.com'));
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
	}
}
