<?php

class Form2IntakeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'application.yeebase.extensions.OrderColumn.OrderAction',
				'modelClass' => 'Form2Intake',
				'pkName' => 'id',
				//'backToAction' => 'admin',
			),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'delete', 'order'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
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
	public function actionCreate($intakeId = '')
	{
		$model = new Form2Intake;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->intake_id = $intakeId;

		if (isset($_POST['Form2Intake'])) {
			$model->attributes = $_POST['Form2Intake'];

			// if the form already attached to an intake
			if ($model->form->hasIntake()) {
				Notice::page(Yii::t('backend', "This form already attached to intake '{intakeTitle}', please unlink to proceed", ['{intakeTitle}' => $model->form->getIntake()->title]), Notice_ERROR, array('url' => $this->createUrl('intake/view', array('id' => $model->form->getIntake()->id))));
			}

			// check is already exists?
			if (HubForm::isForm2IntakeExists($model->form_id, $model->intake_id)) {
				Notice::page(Yii::t('backend', "Form '{formName}' already linked to '{intakeName}'", ['{formName}' => $model->form->title, '{intakeName}' => $model->intake->title]), Notice_ERROR, array('url' => $this->createUrl('/f7/intake/view', array('id' => $model->intake->id))));
			}

			if ($model->save()) {
				$this->redirect(array('/f7/intake/view', 'id' => $model->intake_id));
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

		if (isset($_POST['Form2Intake'])) {
			$model->attributes = $_POST['Form2Intake'];

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
		$model = $this->loadModel($id);
		$modelCopied = $model;
		$model->delete();

		if (!isset($_GET['ajax'])) {
			if (!empty($modelCopied->intake)) {
				$this->redirect(array('/f7/intake/view', 'id' => $modelCopied->intake->id));

				Notice::flash(Yii::t('backend', "Successfully unlinked form '{formName}' from '{intakeName}'", ['{formName}' => $modelCopied->form->title, '{intakeName}' => $modelCopied->intake->title]), Notice_SUCCESS);
			} else {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
	}

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('form2-intake/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Form2Intake');
		$dataProvider->criteria->order = 'ordering ASC';
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
		$model = new Form2Intake('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Form2Intake'])) {
			$model->attributes = $_GET['Form2Intake'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Form2Intake the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Form2Intake::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Form2Intake $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'form2-intake-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
