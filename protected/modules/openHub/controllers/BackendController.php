<?php

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
				'actions' => array('index', 'upgrade', 'outputUpgrade'),
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

	public function actionUpgrade($confirm = 0)
	{
		set_timeout_limit(0);

		$key = YsUtil::generateUUID();
		Yii::app()->user->setState('keyUpgrade', $key);

		$upgradeInfo = HubOpenHub::getUpgradeInfo();

		if ($confirm) {
			$pathProtected = dirname(Yii::getPathOfAlias('runtime'), 1);
			$pathOutput = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'exec' . DIRECTORY_SEPARATOR . $key . '.OpenHub-BackendController-actionUpgrade.txt';
			$command = sprintf('php %s/yiic openhub upgrade --key=%s', $pathProtected, $key);
			YeeBase::runPOpen($command, $pathOutput, false);
		}

		$this->render(
			'upgrade',
			$upgradeInfo
		);
	}

	public function actionOutputUpgrade($key)
	{
		$pathOutput = Yii::getPathOfAlias('runtime') . DIRECTORY_SEPARATOR . 'exec' . DIRECTORY_SEPARATOR . $key . '.OpenHubCommand-actionUpgrade.txt';

		echo file_get_contents($pathOutput);
	}
}
