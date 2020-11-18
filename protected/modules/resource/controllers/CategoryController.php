<?php

class CategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';

	public function actions()
	{
		return array(
		);
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'adminTrash', 'deactivate', 'deactivateConfirmed', 'activate', 'activateConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->activeMenuCpanel = 'resource';
		$this->activeMenuMain = 'resource';
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ResourceCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ResourceCategory'])) {
			$model->attributes = $_POST['ResourceCategory'];

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ResourceCategory'])) {
			$model->attributes = $_POST['ResourceCategory'];

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

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
		$this->redirect(array('resource-category/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('ResourceCategory');
		$dataProvider->pagination->pageSize = 5;
		$dataProvider->pagination->pageVar = 'page';

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new ResourceCategory('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['ResourceCategory'])) {
			$model->attributes = $_GET['ResourceCategory'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}
		$model->is_active = 1;

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdminTrash()
	{
		$model = new ResourceCategory('search');
		$model->unsetAttributes();  // clear any default values

		if (isset($_GET['ResourceCategory'])) {
			$model->attributes = $_GET['ResourceCategory'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}
		$model->is_active = 0;

		$this->render('adminTrash', [
			'model' => $model,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ResourceCategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ResourceCategory::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ResourceCategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'resource-category-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDeactivate($id)
	{
		$model = $this->loadModel($id);

		if ($model->is_active == 1) {
			Notice::page(
				Yii::t('notice', "Are you sure to deactivate this record '{title}'? \n\nDeactivated record will be move to the recycle bin. Then, if required, you may restore this record anytime.", ['{title}' => $model->title]),
				Notice_WARNING,
			array('url' => $this->createUrl('deactivateConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "Record '{title}' is already deactivated.", ['{title}' => $model->title]), Notice_INFO);
			$this->redirect(array('category/view', 'id' => $id));
		}
	}

	public function actionDeactivateConfirmed($id)
	{
		$model = $this->loadModel($id);

		$model->is_active = 0;

		if ($model->save()) {
			Yii::app()->esLog->log(sprintf("deactivated Resource Category '#%s - %s'", $model->id, $model->title), 'category', array('trigger' => 'CategoryController::actionDeactivateConfirmed', 'model' => 'Category', 'action' => 'deactivateConfirmed', 'id' => $model->id));

			Notice::flash(Yii::t('notice', "Resource Category '{title}' is successfully deactivated.", ['{title}' => $model->title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to deactivate Resource Category '{title}' due to unknown reason.", ['{title}' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('category/view', 'id' => $id));
	}

	public function actionActivate($id)
	{
		$model = $this->loadModel($id);

		if ($model->is_active == 0) {
			Notice::page(
				Yii::t('notice', "Are you sure to activate this record '{title}'? \n\nActivated record will be restore and move out from the recycle bin.", ['{title}' => $model->title]),
				Notice_WARNING,
			array('url' => $this->createUrl('activateConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "Record '{title}' is already activated.", ['{title}' => $model->title]), Notice_INFO);
			$this->redirect(array('category/view', 'id' => $id));
		}
	}

	public function actionActivateConfirmed($id)
	{
		$model = $this->loadModel($id);

		$model->is_active = 1;

		if ($model->save()) {
			Yii::app()->esLog->log(sprintf("activated Resource Category '#%s - %s'", $model->id, $model->title), 'category', array('trigger' => 'CategoryController::actionActivateConfirmed', 'model' => 'Category', 'action' => 'activateConfirmed', 'id' => $model->id));

			Notice::flash(Yii::t('notice', "Resource Category '{title}' is successfully activated.", ['{title}' => $model->title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to activate Resource Category '{title}' due to unknown reason.", ['{title}' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('category/view', 'id' => $id));
	}
}
