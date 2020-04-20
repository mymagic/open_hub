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
class ChargeController extends Controller
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
				'actions' => array('view', 'create', 'update', 'admin'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('list'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		Notice::page(Yii::t('backend', 'This function is temporary disabled'));
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
		$model = new Charge;
		$model->title = Yii::app()->request->getQuery('title');
		$model->status = 'new';
		$model->currency_code = Yii::app()->request->getQuery('currency_code', 'MYR');
		$model->amount = Yii::app()->request->getQuery('amount', '1.00');
		$model->charge_to = Yii::app()->request->getQuery('charge_to');
		$model->charge_to_code = Yii::app()->request->getQuery('charge_to_code');
		$model->date_started = HUB::now();
		$model->date_expired = strtotime('+1 month', $model->date_started);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Charge'])) {
			$model->attributes = $_POST['Charge'];
			$model->status = 'pending';
			$model->is_active = 1;

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_expired)) {
				$model->date_expired = strtotime($model->date_expired);
			}

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
		if (!$model->canUpdateByAdmin()) {
			Notice::page(Yii::t('backend', 'You cant update this item'));
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Charge'])) {
			$model->attributes = $_POST['Charge'];

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_expired)) {
				$model->date_expired = strtotime($model->date_expired);
			}

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
		$this->redirect(array('charge/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList($chargeToCode = '')
	{
		$this->layout = 'cpanel';
		$this->pageTitle = Yii::t('app', 'My Charges');
		$this->activeSubMenuCpanel = 'charges';

		$criteria = new CDbCriteria;
		$criteria->compare('t.is_active', 1);
		$criteria->compare('t.charge_to', 'email');
		$criteria->compare('t.charge_to_code', Yii::app()->user->username);

		$criteria2 = new CDbCriteria;
		$criteria2->with = array(
			'organization' => array('alias' => 'o'),
			'organization.organization2Emails' => array('alias' => 'o2e')
		);
		$criteria2->together = true;
		$criteria2->condition = 'charge_to=:chargeTo AND o2e.user_email=:userEmail AND o2e.status=:status';
		$criteria2->params = array('userEmail' => Yii::app()->user->username, 'status' => 'approve', 'chargeTo' => 'organization');
		$criteria->mergeWith($criteria2, 'OR');

		$dataProvider = new CActiveDataProvider('Charge', array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.id DESC',
			),
		));
		$dataProvider->pagination->pageSize = 10;
		$dataProvider->pagination->pageVar = 'page';

		$this->render('list', array(
			'dataProvider' => $dataProvider,
			'chargeToCode' => $chargeToCode
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Charge('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Charge'])) {
			$model->attributes = $_GET['Charge'];
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
	 * @return Charge the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Charge::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Charge $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'charge-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
