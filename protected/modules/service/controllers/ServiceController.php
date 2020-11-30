<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class ServiceController extends Controller
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'adminTrash',
				'deactivate', 'deactivateConfirmed', 'activate', 'activateConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
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
		$model = new Service;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Service'])) {
			$model->attributes = $_POST['Service'];

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

		if (isset($_POST['Service'])) {
			$model->attributes = $_POST['Service'];

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('service/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Service');
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
		$this->pageTitle = Yii::t('app', 'Manage Service');

		$model = new Service('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Service'])) {
			$model->attributes = $_GET['Service'];
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
		$this->pageTitle = Yii::t('app', 'Deleted Service');

		$model = new Service('search');
		$model->unsetAttributes();  // clear any default values

		if (isset($_GET['Service'])) {
			$model->attributes = $_GET['Service'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}
		$model->is_active = 0;

		$this->render('adminTrash', array(
			'model' => $model,
		));
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
			$this->redirect(array('service/view', 'id' => $id));
		}
	}

	public function actionDeactivateConfirmed($id)
	{
		$model = $this->loadModel($id);

		$model->is_active = 0;

		if ($model->save()) {
			Yii::app()->esLog->log(sprintf("deactivated Service '#%s - %s'", $model->id, $model->title), 'service', array('trigger' => 'ServiceController::actionDeactivateConfirmed', 'model' => 'Service', 'action' => 'deactivateConfirmed', 'id' => $model->id));

			Notice::flash(Yii::t('notice', "Service '{title}' is successfully deactivated.", ['{title}' => $model->title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to deactivate service '{title}' due to unknown reason.", ['{title}' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('service/view', 'id' => $id));
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
			$this->redirect(array('service/view', 'id' => $id));
		}
	}

	public function actionActivateConfirmed($id)
	{
		$model = $this->loadModel($id);

		$model->is_active = 1;

		if ($model->save()) {
			Yii::app()->esLog->log(sprintf("activated Service '#%s - %s'", $model->id, $model->title), 'service', array('trigger' => 'ServiceController::actionActivateConfirmed', 'model' => 'Service', 'action' => 'activateConfirmed', 'id' => $model->id));

			Notice::flash(Yii::t('notice', "Service '{title}' is successfully activated.", ['{title}' => $model->title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to activate service '{title}' due to unknown reason.", ['{title}' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('service/view', 'id' => $id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Service the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Service::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Service $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
