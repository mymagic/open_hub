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
class PageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'backend';

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
				'actions' => array('index', 'view'),
				'users' => array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('create', 'update', 'admin', 'delete', 'deleteConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isContentManager==true',
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
		$model = new Page;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Page'])) {
			$model->attributes = $_POST['Page'];

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

		if (isset($_POST['Page'])) {
			$model->attributes = $_POST['Page'];

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
		$page = $this->loadModel($id);
		if ($page->is_default == 0) {
			Notice::page(
				Yii::t('notice', sprintf("Are you sure to delete this page '%s'?", $page->getAttributeDataByLanguage($page, 'title'))),
				Notice_WARNING,
			array('url' => $this->createUrl('deleteConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', sprintf("'%s' is an undeletable default page", $page->getAttributeDataByLanguage($page, 'title'))), Notice_ERROR);
			$this->redirect(array('page/view', 'id' => $id));
		}
	}

	public function actionDeleteConfirmed($id)
	{
		$page = Page::model()->findByPk($id);
		if ($page === null) {
			throw new CHttpException(404, 'The requested record does not exist.');
		}
		if ($page->delete()) {
			Notice::flash(Yii::t('notice', sprintf("Page '%s' is successfully deleted.", $page->getAttributeDataByLanguage($page, 'title'))), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', sprintf("Failed to delete page '%s' due to unknown reason.", $page->getAttributeDataByLanguage($page, 'title'))), Notice_ERROR);
		}

		if (!isset($_GET['ajax'])) {
			$this->redirect(array('page/admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Page');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Page('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['Page']))	$model->attributes=$_GET['Page'];
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
	 * @return Page the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Page::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Page $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
