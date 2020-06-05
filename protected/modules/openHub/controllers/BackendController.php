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

		// create organization 'TechCrunch'
		$paramsTechcrunch['organization']['url_website'] = 'https://techcrunch.com/';
		$paramsTechcrunch['organization']['text_short_description'] = 'TechCrunch is an American online publisher focusing on the tech industry. The company specifically reports on the business related to tech, technology news, analysis of emerging trends in tech, and profiling of new tech businesses and products.';
		$paramsTechcrunch['organization']['inputPersonas'] = array($personaCorperate);
		$techcrunch = HubOrganization::getOrCreateOrganization('TechCrunch', $paramsTechcrunch);
	}
}
