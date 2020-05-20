<?php

class ResourceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';
	public $customParse = '';

	public function actions()
	{
		return array();
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function init()
	{
		parent::init();
		$this->layoutParams['enableGlobalSearchBox'] = true;
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('delete', 'admin', 'getTagsBackend'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('list', 'view', 'create', 'update', 'adminByOrganization'),
				'users' => array('@'),
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $organizationId = '', $tab = 'comment')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$org = Organization::model()->findByPk($organizationId);

			if (!$org->canAccessByUserEmail(Yii::app()->user->username)) {
				$this->redirect(array('/organization/list', 'realm' => $realm));
			}

			$this->layout = 'layouts.cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
			$this->customParse = $org->id;
			$this->activeMenuCpanel = 'resource';
		}
		$this->pageTitle = Yii::t('app', 'View Resource');
		$model = $this->loadModel($id);
		$this->activeSubMenuCpanel = 'resource-adminByOrganization';

		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		if (!empty($organization_id)) {
			$organization = Organization::model()->findByPk($organizationId);
		}

		$actions = array();
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getIndividualActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getIndividualActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getIndividualActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getIndividualActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeResourceViewTabs($model, $realm);

		$this->render('view', array(
			'model' => $model,
			'realm' => $realm,
			'organization' => $organization,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($organization_id = '', $realm = 'backend')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$org = Organization::model()->findByPk($organization_id);

			if (!$org->canAccessByUserEmail(Yii::app()->user->username)) {
				$this->redirect(array('/organization/list', 'realm' => $realm));
			}

			$this->layout = 'layouts.cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
			$this->customParse = $org->id;
			$this->activeMenuCpanel = 'resource';
		}
		$this->pageTitle = Yii::t('app', 'Create Resource');

		$model = new Resource;
		if (!empty($organization_id)) {
			$organization = Organization::model()->findByPk($organization_id);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Resource'])) {
			$model->attributes = $_POST['Resource'];

			if ($realm == 'cpanel') {
				if (!empty($organization->id)) {
					$model->inputOrganizations = array($organization->id);
				}
			}

			if (!empty($_POST['Resource']['latlong_address'])) {
				$model->setLatLongAddress($_POST['Resource']['latlong_address']);
			}

			$model->imageFile_logo = UploadedFile::getInstance($model, 'imageFile_logo');

			$model->latlong_address = null;
			// var_dump($model->validate(), $model->getErrors());
			if ($model->save()) {
				UploadManager::storeImage($model, 'logo', $model->tableName());

				$log = Yii::app()->esLog->log(sprintf("created resource '%s'", $model->title), 'resource', array('trigger' => 'ResourceController::actionCreate', 'model' => 'Resource', 'action' => 'create', 'id' => $model->id));

				$this->redirect(array('view', 'id' => $model->id, 'realm' => $realm, 'organization_id' => $organization_id));
			}

			// clear unwanted error messages
			$model->clearErrors('html_content');
			$model->clearErrors('title');
			$model->clearErrors('slug');
		}

		$this->render('create', array(
			'model' => $model,
			'organization' => $organization,
			'realm' => $realm
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $organization_id = '', $realm = 'backend')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$org = Organization::model()->findByPk($organization_id);

			if (!$org->canAccessByUserEmail(Yii::app()->user->username)) {
				$this->redirect(array('/organization/list', 'realm' => $realm));
			}

			$this->layout = 'layouts.cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
			$this->customParse = $org->id;
			$this->activeMenuCpanel = 'resource';
		}
		$this->pageTitle = Yii::t('app', 'Update Resource');

		$model = $this->loadModel($id);
		if (!empty($organization_id)) {
			$organization = Organization::model()->findByPk($organization_id);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Resource'])) {
			$model->attributes = $_POST['Resource'];
			if (!empty($_POST['Resource']['latlong_address'])) {
				$model->setLatLongAddress($_POST['Resource']['latlong_address']);
			}

			if (empty($_POST['Resource']['inputIndustries'])) {
				$model->inputIndustries = null;
			}
			if (empty($_POST['Resource']['inputPersonas'])) {
				$model->inputPersonas = null;
			}
			if (empty($_POST['Resource']['inputStartupStages'])) {
				$model->inputStartupStages = null;
			}
			if (empty($_POST['Resource']['inputResourceGeofocuses'])) {
				$model->inputResourceGeofocuses = null;
			}

			$model->imageFile_logo = UploadedFile::getInstance($model, 'imageFile_logo');

			if ($model->save()) {
				UploadManager::storeImage($model, 'logo', $model->tableName());

				$log = Yii::app()->esLog->log(sprintf("updated resource '%s'", $model->title), 'resource', array('trigger' => 'ResourceController::actionUpdate', 'model' => 'Resource', 'action' => 'update', 'id' => $model->id));

				$this->redirect(array('view', 'id' => $model->id, 'realm' => $realm, 'organization_id' => $organization_id));
			}
		}

		$this->render('update', array(
			'model' => $model,
			'organization' => $organization,
			'realm' => $realm
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('resource/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList($organization_id = '', $realm = 'backend')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$org = Organization::model()->findByPk($organization_id);

			if (!$org->canAccessByUserEmail(Yii::app()->user->username)) {
				$this->redirect(array('/organization/list', 'realm' => $realm));
			}

			$this->layout = 'layouts.cpanel';
			$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
			$this->cpanelMenuInterface = 'cpanelNavOrganizationInformation';
			$this->customParse = $org->id;
			$this->activeMenuCpanel = 'resource';
		}

		$this->pageTitle = Yii::t('app', 'List Resources');

		if ($realm === 'backend') {
			$dataProvider = new CActiveDataProvider('Resource');
			$dataProvider->pagination->pageSize = 5;
			$dataProvider->pagination->pageVar = 'page';

			$this->render('index', array(
				'dataProvider' => $dataProvider,
				'realm' => $realm
			));
		}
		if ($realm === 'cpanel') {
			$model = new Resource('search');
			$model->unsetAttributes();  // clear any default values
			if (isset($_GET['Resource'])) {
				$model->attributes = $_GET['Resource'];
			}
			$model->searchOrganizationId = $org->id;
			if (Yii::app()->request->getParam('clearFilters')) {
				EButtonColumnWithClearFilters::clearFilters($this, $model);
			}

			$this->render('list', array(
				'model' => $model,
				'organization' => $org,
				'realm' => $realm
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($realm = 'backend')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$this->layout = 'layouts.cpanel';
		}
		$this->pageTitle = Yii::t('app', 'Manage Resources');

		$model = new Resource('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Resource'])) {
			$model->attributes = $_GET['Resource'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', array(
			'model' => $model,
			'realm' => $realm,
		));
	}

	public function actionAdminByOrganization($organization_id, $realm = 'backend')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$this->layout = 'layouts.cpanel';
		}
		$this->pageTitle = Yii::t('app', 'Manage Resources');

		$organization = Organization::model()->findByPk($organization_id);

		//$this->activeSub = 'product-adminByOrganization';
		$model = new Resource('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Resource'])) {
			$model->attributes = $_GET['Resource'];
		}
		$model->searchOrganizationId = $organization_id;
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('adminByOrganization', array(
			'model' => $model,
			'organization' => $organization,
			'realm' => $realm
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Resource the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Resource::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function actionGetTagsBackend()
	{
		header('Content-type: application/json');

		$tmps = Tag::model()->findAll(array('select' => 'name', 'order' => 'name ASC'));
		foreach ($tmps as $t) {
			$result[] = $t->name;
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}

	/**
	 * Performs the AJAX validation.
	 * @param Resource $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'resource-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function composeResourceViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getResourceViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getResourceViewTabs($model, $realm));
			}
		}

		if ($realm == 'backend') {
			$tabs['resource'][] = array(
				'key' => 'legacy',
				'title' => 'Legacy <span class="label label-warning">dev</span>',
				'viewPath' => 'modules.resource.views.backend._view-legacy'
			);
		}

		ksort($tabs);

		// if (Yii::app()->user->isDeveloper) {
		if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) {
			$tabs['resource'][] = array(
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => 'modules.resource.views.backend._view-meta'
			);
		}

		return $tabs;
	}
}
