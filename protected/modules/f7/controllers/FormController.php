<?php

class FormController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 *             using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';

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
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'export', 'import', 'importConfirmed', 'builder'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('delete', 'deleteConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 *
	 * @param int $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$modelSubmission = new FormSubmission('search');
		$modelSubmission->unsetAttributes();
		if (isset($_GET['FormSubmission'])) {
			$modelSubmission->attributes = $_GET['FormSubmission'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $modelSubmission);
		}
		$modelSubmission->form_code = $model->code;

		$this->render('view', array(
			'model' => $model,
			'modelSubmission' => $modelSubmission,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($intakeId = '')
	{
		$model = new Form();
		$model->json_structure = '{}';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Form'])) {
			$model->attributes = $_POST['Form'];

			if (!empty($model->date_open)) {
				$model->date_open = strtotime($model->date_open);
			}
			if (!empty($model->date_close)) {
				$model->date_close = strtotime($model->date_close);
			}

			$model->jsonArray_structure = json_decode($model->json_structure);
			$model->jsonArray_stage = json_decode($model->json_stage);
			$model->jsonArray_event_mapping = json_decode($model->json_event_mapping);

			$transaction = Yii::app()->db->beginTransaction();
			try {
				if ($model->save()) {
					if (!empty($intakeId)) {
						$intake = Intake::model()->findByPk($intakeId);
						$form2Intake = new Form2Intake();
						$form2Intake->intake_id = $intake->id;
						$form2Intake->form_id = $model->id;
						$form2Intake->save();
					}

					$transaction->commit();
					//UploadManager::storeImage($model, 'logo', $model->tableName());

					if (!empty($intakeId)) {
						$this->redirect(array('/f7/intake/view', 'id' => $form2Intake->intake_id));
					} else {
						$this->redirect(array('view', 'id' => $model->id));
					}
				}
			} catch (Exception $e) {
				$exceptionMessage = $e->getMessage();
				$result = false;
				$transaction->rollBack();
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param int $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Form'])) {
			$model->attributes = $_POST['Form'];

			//$model->imageFile_logo = UploadedFile::getInstance($model, 'imageFile_logo');
			if (!empty($model->date_open)) {
				$model->date_open = strtotime($model->date_open);
			}
			if (!empty($model->date_close)) {
				$model->date_close = strtotime($model->date_close);
			}

			$model->jsonArray_structure = json_decode($model->json_structure);
			$model->jsonArray_stage = json_decode($model->json_stage);
			$model->jsonArray_event_mapping = json_decode($model->json_event_mapping);

			if ($model->save()) {
				Notice::flash(Yii::t('f7', 'Form Updated'), Notice_SUCCESS);
				//UploadManager::storeImage($model, 'logo', $model->tableName());
				$this->redirect(array('update', 'id' => $model->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param int $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		Notice::page(
			Yii::t('backend', 'Are you sure to delete form {form}?', ['form' => $model->title]),
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
		$title = $model->title;

		if (!empty($model->formSubmissions)) {
			Notice::page(Yii::t('backend', 'You are not allowed to delete form {form} while there are submissions in it.', ['form' => $model->title]), Notice_ERROR, array('url' => $this->createUrl('view', array('id' => $model->id))));
		}

		if ($model->delete()) {
			Notice::flash(Yii::t('backend', 'Form {form} is successfully deleted.', ['form' => $title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('backend', 'Failed to delete form {form} due to unknown reason.', ['form' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('form/admin'));
	}

	/**
	 * Index.
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
		$dataProvider = new CActiveDataProvider('Form');
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
		$model = new Form('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Form'])) {
			$model->attributes = $_GET['Form'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionExport($id, $status = '', $stage = '', $format = 'csv')
	{
		$list = array();
		$model = $this->loadModel($id);
		$counter = 0;

		foreach ($model->formSubmissions as $submission) {
			$tmp = $submission->renderJsonData('csv');
			if ($counter === 0) {
				$list[] = $tmp[0];
			}

			$list[] = $tmp[1];
			++$counter;
		}

		$filename = sprintf('%s.csv', $model->slug);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$out = fopen('php://output', 'w');
		foreach ($list as $fields) {
			fputcsv($out, $fields);
		}
		fclose($out);
	}

	public function actionImport($id)
	{
		Notice::page(Yii::t('backend', 'You are about to import F7 form submissions to the Central. New organization from submission will be added. Click OK to continue. (Mohammad hardcoded this, it is sucks and kind of useless)'), Notice_WARNING, array(
			'url' => $this->createUrl('form/importConfirmed', array('id' => $id)),
			'cancelUrl' => $this->createUrl("form/view?id=$id"),
		));
	}

	public function actionImportConfirmed($id)
	{
		Notice::page(Yii::t('core', 'Not implemented'));
	}

	public function actionBuilder()
	{
		$this->render('builder');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param int $id the ID of the model to be loaded
	 *
	 * @return Form the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Form::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param Form $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
