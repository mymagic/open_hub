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
class EmbedController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
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
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('index', 'view', 'update', 'admin'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isContentManager==true || $user->isDeveloper==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('create', 'delete', 'deleteConfirmed'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Embed;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Embed'])) {
			$model->attributes = $_POST['Embed'];
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

		if (isset($_POST['Embed'])) {
			$model->attributes = $_POST['Embed'];

			$model->imageFile_main_en = UploadedFile::getInstance($model, 'imageFile_main_en');
			$model->imageFile_main_ms = UploadedFile::getInstance($model, 'imageFile_main_ms');
			$model->imageFile_main_zh = UploadedFile::getInstance($model, 'imageFile_main_zh');

			if ($model->save()) {
				if (is_object($model->imageFile_main_en)) {
					UploadManager::storeImage($model, 'main_en', $model->tableName(), null, '', 'image_main_en');

					$model->save();
				}
				if (is_object($model->imageFile_main_ms)) {
					UploadManager::storeImage($model, 'main_ms', $model->tableName(), null, '', 'image_main_ms');
					$model->save();
				}
				if (is_object($model->imageFile_main_zh)) {
					UploadManager::storeImage($model, 'main_zh', $model->tableName(), null, '', 'image_main_zh');
					$model->save();
				}
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
		$embed = $this->loadModel($id);
		if ($embed->is_default == 0) {
			Notice::page(
				Yii::t('notice', 'Are you sure to delete this embed content {code}?', ['{code}' => $embed->code]),
				Notice_WARNING,
			array('url' => $this->createUrl('deleteConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', '{code} is an undeletable default embed', ['{code}' => $embed->code]), Notice_ERROR);
			$this->redirect(array('embed/view', 'id' => $id));
		}
	}

	public function actionDeleteConfirmed($id)
	{
		$embed = $this->loadModel($id);
		if ($embed === null) {
			throw new CHttpException(404, 'The requested record does not exist.');
		}
		if ($embed->delete()) {
			Notice::flash(Yii::t('notice', 'Embed content {code} is successfully deleted.', ['{code}' => $embed->code]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', 'Failed to delete embed content {code} due to unknown reason.', ['{code}' => $embed->code]), Notice_ERROR);
		}

		if (!isset($_GET['ajax'])) {
			$this->redirect(array('embed/admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Embed');
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
		$model = new Embed('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['Embed'])) $model->attributes=$_GET['Embed'];
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
	 * @return Embed the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Embed::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested record does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Embed $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'embed-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
