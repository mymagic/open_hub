<?php

class CpanelController extends Controller
{
	// customParse is for cpanelNavOrganizationInformation to pass in organization ID
	//public $customParse = '';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + setExperienceStudy, setExperienceJob', // we only allow deletion via POST request
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
				'actions' => array('portfolio', 'enablePortfolio', 'disablePortfolio',
				'experience', 'createExperience', 'deleteExperience', 'deleteExperienceConfirmed', 'listExperiences', 'viewExperience', 'updateExperience', 'setExperienceStudy', 'setExperienceJob'),
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

	public function actionEnablePortfolio()
	{
		$model = HubCv::getOrCreateCvPortfolio($this->user);
		$model->visibility = 'public';
		$model->save();

		$return['data'] = $model->toApi();
		$return['meta']['input']['userId'] = $this->user->id;

		return $this->outputJsonSuccess($return['data'], $return['meta']);
	}

	public function actionDisablePortfolio()
	{
		$model = HubCv::getOrCreateCvPortfolio($this->user);
		$model->visibility = 'private';
		$model->save();

		$return['data'] = $model->toApi();
		$return['meta']['input']['userId'] = $this->user->id;

		return $this->outputJsonSuccess($return['data'], $return['meta']);
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
		$this->layout = 'layouts.plain';
		$this->layoutParams['modalDialogClass'] = 'modal-lg';

		// disable mixpanel as its js caused jquery modal submit issue redirected to json straight
		Yii::app()->params['enableMixPanel'] = false;

		$this->pageTitle = 'Add New Experience';
		$this->activeMenuCpanel = 'experience';

		$portfolio = HubCv::getOrCreateCvPortfolio($this->user);

		$model = new CvExperience();
		$model->cv_portfolio_id = $portfolio->id;

		$this->performAjaxValidation($model);
		if (isset($_POST['CvExperience'])) {
			$status = 'fail';
			$msg = '';
			$data = null;

			$model->attributes = $_POST['CvExperience'];
			if (!empty($model->full_address)) {
				$model->resetAddressParts();
			}

			if ($model->save()) {
				$status = 'success';
				$msg = Yii::t('collection', "Successfully added '{title}' to portfolio", array('{title}' => $model->title));
				$data = $model->toApi();
			}

			$this->renderJSON(array('status' => $status, 'msg' => $msg, 'data' => $data));
		}

		$this->render('createExperience', array(
			'model' => $model, 'portfolio' => $portfolio
		));
	}

	public function actionViewExperience($id)
	{
		$this->layout = 'layouts.modal';
		$this->layoutParams['modalDialogClass'] = 'modal-lg';
		$this->layoutParams['showModalFooter'] = true;
		$this->layoutParams['showModalHeader'] = false;
		$this->pageTitle = 'View Experience';
		$this->activeMenuCpanel = 'experience';

		$model = $this->loadExperienceModel($id);
		$this->pageTitle = $model->title;

		$this->render('viewExperience', array(
			'model' => $model
		));
	}

	public function actionUpdateExperience($id)
	{
		$this->layout = 'layouts.plain';
		$this->layoutParams['modalDialogClass'] = 'modal-lg';

		// disable mixpanel as its js caused jquery modal submit issue redirected to json straight
		Yii::app()->params['enableMixPanel'] = false;

		$this->pageTitle = 'Update Experience';
		$this->activeMenuCpanel = 'experience';

		$model = $this->loadExperienceModel($id);
		$oriModel = clone $model;

		$this->performAjaxValidation($model);
		if (isset($_POST['CvExperience'])) {
			$status = 'fail';
			$msg = '';
			$data = null;

			$model->attributes = $_POST['CvExperience'];
			if (($oriModel->full_address != $model->full_address) && !empty($model->full_address)) {
				$model->resetAddressParts();
			}

			if ($model->save()) {
				$status = 'success';
				$msg = Yii::t('collection', "Successfully updated '{title}'", array('{title}' => $model->title));
				$data = $model->toApi();
			}

			$this->renderJSON(array('status' => $status, 'msg' => $msg, 'data' => $data));
		}

		$this->render('updateExperience', array(
			'model' => $model, 'portfolio' => $model->cvPortfolio
		));
	}

	// id: experience id
	public function actionSetExperienceStudy($id)
	{
		$msg = '';
		$meta['input']['id'] = $id;
		$model = $this->loadExperienceModel($id);
		if (!$model->is_active) {
			$msg = Yii::t('cv', "Failed to update inactive experience '{title}' as the highest academic experience for portfolio '{displayName}'", array('{title}' => $model->title, '{displayName}' => $model->cvPortfolio->display_name));
		} elseif ($model->genre != 'study') {
			$msg = Yii::t('cv', 'Invalid experience type');
		} else {
			$model->cvPortfolio->high_academy_experience_id = $model->id;
			if ($model->cvPortfolio->save()) {
				$msg = Yii::t('cv', "Successfully updated '{title}' as the highest academic experience for portfolio '{displayName}'", array('{title}' => $model->title, '{displayName}' => $model->cvPortfolio->display_name));
				$this->outputJsonSuccess($model->cvPortfolio->toApi(), $meta, $msg);
			} else {
				$msg = Yii::t('cv', 'Failed to save due to error: {error}', array('{error}' => Yii::app()->modelErrors2String($model->cvPortfolio)));
			}
		}
		$this->outputJsonFail($msg, $meta);
	}

	// id: experience id
	public function actionSetExperienceJob($id)
	{
		$msg = '';
		$meta['input']['id'] = $id;
		$model = $this->loadExperienceModel($id);
		if (!$model->is_active) {
			$msg = Yii::t('cv', "Failed to update inactive experience '{title}' as the current job experience for portfolio '{displayName}'", array('{title}' => $model->title, '{displayName}' => $model->cvPortfolio->display_name));
		} elseif ($model->genre != 'job') {
			$msg = Yii::t('cv', 'Invalid experience type');
		} else {
			$model->cvPortfolio->current_job_experience_id = $model->id;
			$model->cvPortfolio->organization_name = $model->organization_name;
			if ($model->cvPortfolio->save()) {
				$msg = Yii::t('cv', "Successfully updated '{title}' as the current job experience for portfolio '{displayName}'", array('{title}' => $model->title, '{displayName}' => $model->cvPortfolio->display_name));
				$this->outputJsonSuccess($model->cvPortfolio->toApi(), $meta, $msg);
			} else {
				$msg = Yii::t('cv', 'Failed to save due to error: {error}', array('{error}' => Yii::app()->modelErrors2String($model->cvPortfolio)));
			}
		}
		$this->outputJsonFail($msg, $meta);
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'experience-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function loadExperienceModel($id)
	{
		$model = CvExperience::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function actionDeleteExperience($id)
	{
		$model = $this->loadExperienceModel($id);

		Notice::page(Yii::t('cv', "Are you confirm to delete experience '{title}'?", array('{title}' => $model->title)), Notice_WARNING, array('url' => $this->createUrl('deleteExperienceConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('experience')));
	}

	public function actionDeleteExperienceConfirmed($id)
	{
		$model = $this->loadExperienceModel($id);
		$oriModel = clone $model;
		$model->delete();

		Notice::flash(Yii::t('cv', "Experience '{title}' is successfully deleted.", ['{title}' => $oriModel->title]), Notice_SUCCESS);

		$this->redirect(array('experience'));
	}

	public function actionListExperiences($page = 1)
	{
		$client = new \GuzzleHttp\Client(['base_uri' => Yii::app()->params['baseApiUrl'] . '/']);

		try {
			$response = $client->post(
				'getCvExperiences',
			[
				'form_params' => [
					'username' => Yii::app()->user->username,
					'page' => $page,
				],
				'verify' => false,
			]
			);
		} catch (Exception $e) {
			$this->outputJsonFail($e->getMessage());
		}

		$this->outputJsonRaw($response->getBody());
	}
}
