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
class OrganizationStatusController extends Controller
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'delete'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || ($user->isAdmin==true && $user->isSensitiveDataAdmin==true)',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			// skip action ajax from checking the role for some reason. otherwise need to assign these actions for all roles even for view only role
			array(
				'allow',
				'actions' => array('ajaxOrganization'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		$this->activeMenuMain = 'organization';
		parent::init();
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $tab = 'comment')
	{
		$model = $this->loadModel($id);

		$actions = [];
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getOrganizationStatusActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getOrganizationStatusActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getOrganizationStatusActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getOrganizationStatusActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeOrganizationStatusViewTabs($model, $realm);

		$this->render('view', array(
			'model' => $model,
			'realm' => $realm,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($organization_id = '')
	{
		$model = new OrganizationStatus;

		if (!empty($organization_id)) {
			$model->organization_id = $organization_id;
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['OrganizationStatus'])) {
			$model->attributes = $_POST['OrganizationStatus'];

			if (!empty($model->date_reported)) {
				$model->date_reported = strtotime($model->date_reported);
			}

			if ($model->save()) {
				$log = Yii::app()->esLog->log(sprintf("created status record #%s for organization '%s'", $model->id, $model->organization->title), 'organization', array('trigger' => 'OrgranizationStatusController::actionCreate', 'model' => 'OrganizationStatus', 'action' => 'create', 'id' => $model->organization->id, 'organizationId' => $model->organization->id));

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

		if (isset($_POST['OrganizationStatus'])) {
			$model->attributes = $_POST['OrganizationStatus'];

			if (!empty($model->date_reported)) {
				$model->date_reported = strtotime($model->date_reported);
			}

			if ($model->save()) {
				$log = Yii::app()->esLog->log(sprintf("updated status record #%s for organization '%s'", $model->id, $model->organization->title), 'organization', array('trigger' => 'OrgranizationStatusController::actionUpdate', 'model' => 'OrganizationStatus', 'action' => 'update', 'id' => $model->organization->id, 'organizationId' => $model->organization->id));

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
			$log = Yii::app()->esLog->log(sprintf("deleted status record #%s for organization '%s'", $copy->id, $copy->organization->title), 'organization', array('trigger' => 'OrgranizationStatusController::actionDelete', 'model' => 'OrganizationStatus', 'action' => 'delete', 'id' => $copy->organization->id, 'organizationId' => $copy->organization->id));
		}

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
		$this->redirect(array('organizationStatus/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('OrganizationStatus');
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
		$model = new OrganizationStatus('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['OrganizationStatus'])) {
			$model->attributes = $_GET['OrganizationStatus'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAjaxOrganization($term = '', $id = '')
	{
		$results = array();
		$command = Yii::app()->db->createCommand();

		if (strlen($term) < 3) {
			$this->outputJsonRaw(array('results' => array()));
		}

		// update
		if (!empty($id)) {
			$selected = $this->loadModel($id);
		}

		$command = $command->select('id as id, title as text')->from('organization')->where(array('like', 'title', '%' . $term . '%'));
		// create
		if (empty($selected)) {
			// only active organization can be use
			$command = $command->andWhere('is_active=1');
		}
		$command = $command->order('title ASC')->limit(30);

		$results = array_merge($results, $command->queryAll());
		foreach ($results as &$result) {
			$organization = Organization::model()->findByPk($result['id']);
			if ($organization->id == $selected->organization->id) {
				$result['selected'] = true;
			}
			$result['textOneliner'] = !empty($organization->text_oneliner) ? ysUtil::truncate($organization->text_oneliner) : '-';
			$result['urlWebsite'] = !empty($organization->url_website) ? $organization->url_website : '-';
			$result['imageLogoThumbUrl'] = $organization->getImageLogoThumbUrl();
		}
		$return['results'] = $results;
		$this->outputJsonRaw($return);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrganizationStatus the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = OrganizationStatus::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrganizationStatus $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'organizationStatus-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function composeOrganizationStatusViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getOrganizationStatusViewTabs')) {
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
			$tabs['organizationStatus'][] = array(
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => '_view-meta',
			);
		}

		return $tabs;
	}
}
