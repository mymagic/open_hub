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

class EventGroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 *             using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';

	public function actions()
	{
		return [
		];
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return [
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		];
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return [
			['allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => ['index'],
				'users' => ['*'],
			],
			['allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => ['list', 'view', 'admin'],
				'users' => ['@'],
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			],
			['allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => ['create', 'update', 'delete'],
				'users' => ['@'],
				// 'expression' => '$user->isSuperAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			],
			['deny',  // deny all users
				'users' => ['*'],
			],
		];
	}

	/**
	 * Displays a particular model.
	 *
	 * @param int $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $tab = 'comment')
	{
		$model = $this->loadModel($id);

		// Active List
		$modelEventActiveList = new Event('search');
		$modelEventActiveList->unsetAttributes();  // clear any default values
		$modelEventActiveList->id = $id;
		$modelEventActiveList->is_active = 1;

		// Inactive List
		$modelEventInactiveList = new Event('search');
		$modelEventInactiveList->unsetAttributes();  // clear any default values
		$modelEventInactiveList->id = $id;
		$modelEventInactiveList->is_active = 0;

		$actions = [];
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getEventGroupActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getEventGroupActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getEventGroupActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getEventGroupActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeEventGroupViewTabs($model, $realm);

		$this->render('view', [
			'model' => $model,
			'modelEventActiveList' => $modelEventActiveList,
			'modelEventInactiveList' => $modelEventInactiveList,
			'realm' => $realm,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
		]);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new EventGroup();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EventGroup'])) {
			$model->attributes = $_POST['EventGroup'];

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_ended)) {
				$model->date_ended = strtotime($model->date_ended);
			}

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');

			if ($model->save()) {
				UploadManager::storeImage($model, 'cover', $model->tableName());
				$this->redirect(['view', 'id' => $model->id]);
			}
		}

		$this->render('create', [
			'model' => $model,
		]);
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

		if (isset($_POST['EventGroup'])) {
			$model->attributes = $_POST['EventGroup'];

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_ended)) {
				$model->date_ended = strtotime($model->date_ended);
			}

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');

			if ($model->save()) {
				UploadManager::storeImage($model, 'cover', $model->tableName());
				$this->redirect(['view', 'id' => $model->id]);
			}
		}

		$this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param int $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
		}
	}

	/**
	 * Index.
	 */
	public function actionIndex()
	{
		$this->redirect(['event-group/admin']);
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('EventGroup');
		$dataProvider->pagination->pageSize = 5;
		$dataProvider->pagination->pageVar = 'page';

		$this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new EventGroup('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['EventGroup'])) {
			$model->attributes = $_GET['EventGroup'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', [
			'model' => $model,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param int $id the ID of the model to be loaded
	 *
	 * @return EventGroup the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = EventGroup::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param EventGroup $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-group-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function composeEventGroupViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getEventGroupViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getMemberViewTabs($model, $realm));
			}
		}

		if ($realm == 'backend') {
			/*$tabs['member'][] = array(
				'key' => 'individual',
				'title' => 'Individual',
				'viewPath' => 'views.individualMember.backend._view-member-individual'
			);*/
		}

		ksort($tabs);

		// if (Yii::app()->user->isDeveloper) {
		if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) {
			$tabs['eventGroup'][] = array(
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => '_view-meta',
			);
		}

		return $tabs;
	}
}
