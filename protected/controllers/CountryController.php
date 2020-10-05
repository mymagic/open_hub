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
class CountryController extends Controller
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
				'actions' => array('view', 'create', 'update', 'admin', 'delete'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true',
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
		$model = $this->loadModel($id);

		Yii::app()->esLog->log(sprintf("viewed Country '%s'", $model->printable_name), 'country', array('trigger' => 'CountryController::actionView', 'model' => 'Country', 'action' => 'view', 'id' => $model->id));

		$this->render('view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Country;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Country'])) {
			$model->attributes = $_POST['Country'];

			if ($model->save()) {
				Yii::app()->esLog->log(sprintf("created Country '%s'", $model->printable_name), 'country', array('trigger' => 'CountryController::actionCreate', 'model' => 'Country', 'action' => 'create', 'id' => $model->id));

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

		if (isset($_POST['Country'])) {
			$model->attributes = $_POST['Country'];

			if ($model->save()) {
				Yii::app()->esLog->log(sprintf("updated Country '%s'", $model->printable_name), 'country', array('trigger' => 'CountryController::actionUpdate', 'model' => 'Country', 'action' => 'update', 'id' => $model->id));

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
		$copy = clone $model;

		if ($model->delete()) {
			Yii::app()->esLog->log(sprintf("deleted Country '%s'", $copy->printable_name), 'country', array('trigger' => 'CountryController::actionDelete', 'model' => 'Country', 'action' => 'delete', 'id' => $copy->id));
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Country');
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
		$model = new Country('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['Country'])) $model->attributes=$_GET['Country'];
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
	 * @return Country the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Country::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Country $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'country-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
