<?php

class CpanelController extends Controller
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
				'actions' => array('index'),
				'users' => array('*'),
			),
			array(
				'allow',
				'actions' => array('portfolio', 'experience'),
				'users' => array('@'),
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

		$this->layout = 'cpanel';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('app', 'My CV');
		$this->cpanelMenuInterface = 'cpanelNavCV';
		$this->activeMenuCpanel = 'list';
		$this->layoutParams['containerFluid'] = false;
		$this->layoutParams['enableGlobalSearchBox'] = false;
	}

	public function actionIndex()
	{
		$this->redirect(array('portfolio'));
	}

	public function actionPortfolio()
	{
		$this->activeMenuCpanel = 'portfolio';
		$user = User::model()->findByPk(Yii::app()->user->id);

		$model = HubCv::getOrCreateCvPortfolio($user);
		if (isset($_POST['CvPortfolio'])) {
			$params['cvPortfolio'] = $_POST['CvPortfolio'];
			$params['cvPortfolio']['imageFile_avatar'] = UploadedFile::getInstance($model, 'imageFile_avatar');

			$model = HubCv::getOrCreateCvPortfolio($user, $params);
		}

		$this->render('portfolio', array('model' => $model));
	}

	public function actionExperience()
	{
		$this->activeMenuCpanel = 'experience';
		$this->render('experience');
	}
}
