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
				'actions' => array('portfolio', 'experience', 'createExperience'),
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

		if (!Yii::app()->getModule('cv')->isCpanelEnabled) {
			Notice::page(Yii::t('cv', 'This page has been disabled by admin'), Notice_INFO);
		}
	}

	public function actionIndex()
	{
		$this->redirect(array('portfolio'));
	}

	public function actionPortfolio()
	{
		$this->activeMenuCpanel = 'portfolio';

		$model = HubCv::getOrCreateCvPortfolio($this->user);
		if (isset($_POST['CvPortfolio'])) {
			$params['cvPortfolio'] = $_POST['CvPortfolio'];
			$params['cvPortfolio']['imageFile_avatar'] = UploadedFile::getInstance($model, 'imageFile_avatar');

			$model = HubCv::getOrCreateCvPortfolio($this->user, $params);
		}

		$this->render('portfolio', array('model' => $model));
	}

	public function actionExperience()
	{
		$this->activeMenuCpanel = 'experience';

		$model = new CvExperience('search');
		$model->unsetAttributes();
		if (isset($_GET['CvExperience'])) {
			$model->attributes = $_GET['CvExperience'];
		}

		$portfolio = HubCv::getOrCreateCvPortfolio($this->user);
		$model->cv_portfolio_id = $portfolio->id;

		$this->render('experience', array(
			'model' => $model, 'portfolio' => $portfolio
		));
	}

	public function actionCreateExperience()
	{
		$this->pageTitle = 'Add New Experience';
		$this->activeMenuCpanel = 'experience';

		$portfolio = HubCv::getOrCreateCvPortfolio($this->user);

		$model = new CvExperience();
		if (isset($_POST['CvExperience'])) {
			$model->attributes = $_POST['CvExperience'];
			$model->cv_portfolio_id = $portfolio->id;

			if ($model->save()) {
				$this->redirect(array('experience'));
			}
		}

		$this->render('createExperience', array(
			'model' => $model, 'portfolio' => $portfolio
		));
	}
}
