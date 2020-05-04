<?php

class SubmissionController extends Controller
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
				'actions' => array('view', 'exportCsv', 'exportPdf', 'update', 'view'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('list', 'create', 'admin', 'delete', 'deleteConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true',
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

	public function actionExportCsv($id)
	{
		$model = $this->loadModel($id);
		$list = $model->renderJsonData('csv');
		$filename = sprintf('%s-#%s.csv', $model->form->slug, $model->id);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$out = fopen('php://output', 'w');
		foreach ($list as $fields) {
			fputcsv($out, $fields);
		}
		fclose($out);
	}

	public function actionExportPdf($id)
	{
		$submission = $this->loadModel($id);
		$filename = sprintf('%s-#%s.csv', $submission->form->slug, $submission->id);
		$htmlBuffer = $submission->renderSimpleFormattedHtml();

		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'tempDir' => Yii::getPathOfAlias('application.runtime')]);
		$mpdf->SetTitle($filename);
		$mpdf->WriteHTML("$htmlBuffer");
		$mpdf->Output($filename, 'I');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new FormSubmission;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['FormSubmission'])) {
			$model->attributes = $_POST['FormSubmission'];

			if (!empty($model->date_submitted)) {
				$model->date_submitted = strtotime($model->date_submitted);
			}

			$model->jsonArray_data = json_decode($model->json_data);

			if ($model->save()) {
				//UploadManager::storeImage($model, 'logo', $model->tableName());
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

		if (isset($_POST['FormSubmission'])) {
			$model->attributes = $_POST['FormSubmission'];

			if (!empty($model->date_submitted)) {
				$model->date_submitted = strtotime($model->date_submitted);
			}

			//$model->imageFile_logo = UploadedFile::getInstance($model, 'imageFile_logo');

			$model->jsonArray_data = json_decode($model->json_data);

			if ($model->save()) {
				//UploadManager::storeImage($model, 'logo', $model->tableName());
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

		Notice::page(
			Yii::t('backend', "Are you sure to delete submission '#{submission}'?", ['submission' => $model->id]),
			Notice_WARNING,
		array('url' => $this->createUrl('deleteConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
		);
	}

	public function actionDeleteConfirmed($id)
	{
		$model = $this->loadModel($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested record does not exist.');
		}
		$id = $model->id;
		$form = $model->form;

		if ($model->delete()) {
			Notice::flash(Yii::t('backend', "Submission '#{submission}' is successfully deleted.", ['submission' => $id]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('backend', "Failed to delete submission '#{submission}' due to unknown reason.", ['submission' => $id]), Notice_ERROR);
		}

		$this->redirect(array('/f7/form/view', 'id' => $form->id));
	}

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('form/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('FormSubmission');
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
		$model = new FormSubmission('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['FormSubmission'])) {
			$model->attributes = $_GET['FormSubmission'];
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
	 * @return FormSubmission the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = FormSubmission::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FormSubmission $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'submission-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
