<?php

class ChallengeController extends Controller
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
				'modelClass' => 'Challenge',
				'pkName' => 'id',
				'backToAction' => 'admin',
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'delete', 'order', 'getTagsBackend'),
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
	public function actionCreate()
	{
		$model = new Challenge;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Challenge'])) {
			$model->attributes = $_POST['Challenge'];

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');
			$model->imageFile_header = UploadedFile::getInstance($model, 'imageFile_header');
			if (!empty($model->date_open)) {
				$model->date_open = strtotime($model->date_open);
			}
			if (!empty($model->date_close)) {
				$model->date_close = strtotime($model->date_close);
			}

			$model->date_submit = time();

			if ($model->save()) {
				UploadManager::storeImage($model, 'cover', $model->tableName());
				UploadManager::storeImage($model, 'header', $model->tableName());
				$model->setTags($model->tag_backend)->save();
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

		if (isset($_POST['Challenge'])) {
			$model->attributes = $_POST['Challenge'];

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');
			$model->imageFile_header = UploadedFile::getInstance($model, 'imageFile_header');
			if (!empty($model->date_open)) {
				$model->date_open = strtotime($model->date_open);
			}
			if (!empty($model->date_close)) {
				$model->date_close = strtotime($model->date_close);
			}

			if ($model->save()) {
				UploadManager::storeImage($model, 'cover', $model->tableName());
				UploadManager::storeImage($model, 'header', $model->tableName());
				$model->setTags($model->tag_backend)->save();
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
		$this->redirect(array('challenge/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Challenge');
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
		$model = new Challenge('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Challenge'])) {
			$model->attributes = $_GET['Challenge'];
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
	 * @return Challenge the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Challenge::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Challenge $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'challenge-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
}
