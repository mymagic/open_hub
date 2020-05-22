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
class IndividualController extends Controller
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
				'actions' => array('overview', 'list', 'view', 'create', 'update', 'admin', 'getTagsBackend', 'merge', 'getIndividualNodes', 'doMerge', 'doMergeConfirmed',
				'getIndividual2Emails', 'deleteIndividual2Email', 'addIndividual2Email', 'toggleIndividual2EmailStatus', 'requestJoinEmail', ),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('overview', 'list', 'view', 'admin', 'getTagsBackend', 'getIndividual2Emails'),
				'users' => array('@'),
				// 'expression' => '$user->isEcosystem==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		$this->activeMenuCpanel = 'individual';
		$this->activeMenuMain = 'individual';
		parent::init();
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $tab = 'comment')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$this->layout = 'cpanel';
		}
		$this->pageTitle = Yii::t('app', 'View Individual');
		$model = $this->loadModel($id);
		$this->pageTitle = Yii::t('app', "View '{IndividualTitle}'", array('{IndividualTitle}' => $model->full_name));

		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$actions = array();
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getIndividualActions')) {
					$actions = array_merge($actions, (array)Yii::app()->getModule($moduleKey)->getIndividualActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getIndividualActions')) {
					$actions = array_merge($actions, (array)Yii::app()->getModule($moduleKey)->getIndividualActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeIndividualViewTabs($model, $realm);

		$this->render('view', array(
			'model' => $model,
			'actions' => $actions,
			'realm' => $realm,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
		));
	}

	public function actionOverview()
	{
		$this->redirect(array('admin'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Individual;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Individual'])) {
			$model->attributes = $_POST['Individual'];

			$model->imageFile_photo = UploadedFile::getInstance($model, 'imageFile_photo');

			if ($model->save()) {
				UploadManager::storeImage($model, 'photo', $model->tableName());

				$log = Yii::app()->esLog->log(sprintf("created '%s'", $model->full_name), 'individual', array('trigger' => 'IndividualController::actionCreate', 'model' => 'Individual', 'action' => 'create', 'id' => $model->id, 'individualId' => $model->id));

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

		if (isset($_POST['Individual'])) {
			$model->attributes = $_POST['Individual'];

			if (empty($_POST['Individual']['inputPersonas'])) {
				$model->inputPersonas = null;
			}

			$model->imageFile_photo = UploadedFile::getInstance($model, 'imageFile_photo');

			if ($model->save()) {
				UploadManager::storeImage($model, 'photo', $model->tableName());

				$log = Yii::app()->esLog->log(sprintf("updated individual '%s'", $model->full_name), 'individual', array('trigger' => 'IndividualController::actionUpdate', 'model' => 'Individual', 'action' => 'update', 'id' => $model->id, 'individualId' => $model->id));

				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
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

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('individual/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Individual');
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
		$model = new Individual('search');
		$model->unsetAttributes();  // clear any default values
		$model->is_active = 1;

		if (isset($_GET['Individual'])) {
			$model->attributes = $_GET['Individual'];
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
	 * @return Individual the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Individual::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Individual $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'individual-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionMerge($sourceKeyword = '', $targetKeyword = '')
	{
		$this->pageTitle = Yii::t('app', 'Merge Individuals');

		$suggestions = Yii::app()->db->createCommand('SELECT * FROM (select count(*) as total, full_name, left(individual.full_name, 20) as r from individual WHERE is_active=1 GROUP BY r ORDER BY total DESC) AS a WHERE a.total>1')->queryAll();
		//echo '<pre>';print_r($suggestions);exit;

		$this->render('merge', array('targetKeyword' => $targetKeyword, 'sourceKeyword' => $sourceKeyword, 'suggestions' => $suggestions));
	}

	public function actionDoMerge($sourceKeyword, $targetKeyword)
	{
		if (is_numeric($sourceKeyword)) {
			$source = Individual::model()->findByAttributes(array('id' => $sourceKeyword));
		} else {
			$source = Individual::model()->findByAttributes(array('full_name' => $sourceKeyword));
		}

		if (is_numeric($targetKeyword)) {
			$target = Individual::model()->findByAttributes(array('id' => $targetKeyword));
		} else {
			$target = Individual::model()->findByAttributes(array('full_name' => $targetKeyword));
		}

		Notice::page(Yii::t('backend', "Are you sure to merge all data from '{source}' into '{target}'? This action is NOT REVERSIBLE. '{source}' will be deactivated after the process.", ['{source}' => $source->full_name, '{target}' => $target->full_name]), Notice_WARNING, array(
			'url' => $this->createUrl('individual/doMergeConfirmed', array('target' => $target->id, 'source' => $source->id)),
			'cancelUrl' => $this->createUrl('individual/merge', array('targetKeyword' => $target->full_name, 'sourceKeyword' => $source->full_name))
		));
	}

	public function actionDoMergeConfirmed($source, $target)
	{
		$success = false;
		try {
			$source = Individual::model()->findByAttributes(array('id' => $source));

			$target = Individual::model()->findByAttributes(array('id' => $target));

			$result = HUB::doIndividualsMerge($source, $target);
			$success = true;
		} catch (Exception $e) {
			$success = false;
			$exceptionMessage = $e->getMessage();
		}

		if ($success) {
			/* save history of merging */
			HUB::createIndividualMergeHistory($source, $target);

			Notice::page(Yii::t('backend', "Successfully merged '{source}' into '{target}'", ['{source}' => $source->full_name, '{target}' => $target->full_name]), Notice_SUCCESS, array('url' => $this->createUrl('individual/view', array('id' => $target->id))));
		} else {
			Notice::page(Yii::t('backend', "Failed to merge '{source}' into '{target}' due to error: {error}", ['{source}' => $source->full_name, '{target}' => $target->full_name, '{error}' => $exceptionMessage]), Notice_ERROR, array('url' => $this->createUrl('individual/merge', array('targetKeyword' => $target->full_name, 'sourceKeyword' => $source->full_name))));
		}
	}

	public function actionGetIndividualNodes($keyword)
	{
		if (is_numeric($keyword)) {
			$model = Individual::model()->findByAttributes(array('id' => $keyword));
		} else {
			$model = Individual::model()->findByAttributes(array('full_name' => $keyword));
		}

		if (!empty($model)) {
			echo $this->renderPartial('_getIndividualNodes', array('model' => $model));
		} else {
			echo sprintf("'%s' not found", $keyword);
		}
	}

	//
	// individual2email
	public function actionGetIndividual2Emails($individualId, $Individual2Emails_page = 0, $realm = 'backend')
	{
		$model['realm'] = $realm;
		$model['list'] = HUB::getIndividual2Emails($individualId, $Individual2Emails_page);

		Yii::app()->clientScript->scriptMap = array('jquery.min.js' => false);
		$this->renderPartial('_getIndividual2Emails', $model, false, true);
	}

	public function actionDeleteIndividual2Email($id, $realm = '')
	{
		$model = HUB::getIndividual2Email($id);
		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->individual->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$individual = $model->individual;
		$copy = clone $model;
		if ($model->delete()) {
			// notify the email about his access to this individual
			//$notifMaker = NotifyMaker::user_hub_revokeEmailAccess($copy);
			//HUB::sendEmail($copy->user_email, $copy->user_email, $notifMaker['title'], $notifMaker['content']);
		}

		if ($realm == 'cpanel') {
			Notice::flash(Yii::t('notice', "Successfully revoke request from email '{email}' to link '{individualTitle}'", ['{email}' => $copy->user_email, '{individualTitle}' => $copy->individual->full_name]), Notice_SUCCESS);
		} else {
			// same user
			Notice::flash(Yii::t('notice', "Successfully revoke '{email}' access to '{individualTitle}'", ['{email}' => $copy->user_email, '{individualTitle}' => $copy->individual->full_name]), Notice_SUCCESS);
		}

		/*if($copy->user_email == Yii::app()->user->username)
		{
			$this->redirect(array('individual/select', 'realm'=>$realm));
		}*/

		$this->redirect(array('individual/view', 'id' => $individual->id, 'realm' => $realm));
	}

	public function actionDeleteUserIndividual2Email($individualID, $userEmail, $realm = 'cpanel')
	{
		$result = HUB::getIndividual2EmailUserID($individualID, $userEmail);

		Notice::page(Yii::t('notice', 'You are about to remove your access request to the individual. Click OK to continue.'), Notice_WARNING, array(
			'url' => $this->createUrl('individual/deleteIndividual2Email', array('id' => $result, 'realm' => $realm)), 'cancelUrl' => $this->createUrl('individual/select')));
	}

	public function actionAddIndividual2Email($individualId, $realm = 'backend')
	{
		$individual = $this->loadModel($individualId);
		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$individual->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$model = new Individual2Email;

		if (isset($_POST['Individual2Email'])) {
			$model->attributes = $_POST['Individual2Email'];
			$model->individual_id = $individualId;
			$model->user_email = trim($model->user_email);
			$model->is_verify = 1;

			if ($model->save()) {
				// notify the email about his access to this individual
				//$notifMaker = NotifyMaker::user_hub_approveEmailAccess($model);
				//HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);

				Notice::flash(Yii::t('notice', "Successfully added email '{email}' to individual '{individualTitle}'", ['{email}' => $model->user_email, '{individualTitle}' => $model->individual->full_name]), Notice_SUCCESS);
			} else {
				Notice::flash(Yii::t('notice', "Failed to add email '{email}' to individual '{individualTitle}'", ['{email}' => $model->user_email, '{individualTitle}' => $model->individual->full_name]), Notice_ERROR);
			}
		}

		$this->redirect(array('view', 'id' => $model->individual_id, 'realm' => $realm));
	}

	public function actionToggleIndividual2EmailStatus($id, $realm = 'backend')
	{
		$model = HUB::getIndividual2Email($id);
		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->individual->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$model->is_verify = (int)!$model->is_verify;

		if ($model->save()) {
			if (!$model->is_verify) {
				// notify the email about his access to this individual
				//$notifMaker = NotifyMaker::user_hub_revokeEmailAccess($model);
				//HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);
			} else {
				// notify the email about his access to this individual
				//$notifMaker = NotifyMaker::user_hub_approveEmailAccess($model);
				//HUB::sendEmail($model->user_email, $model->user_email, $notifMaker['title'], $notifMaker['content']);
			}
		}
		$this->redirect(array('view', 'id' => $model->individual_id, 'realm' => $realm));
	}

	public function actionRequestJoinEmail($individualId, $email, $realm = 'cpanel')
	{
		$model = new Individual2Email;
		$model->individual_id = $individualId;
		$model->user_email = $email;

		//echo $model->individual->hasUserEmail($email);exit;
		if ($model->individual->hasUserEmail($email)) {
			if ($model->individual->canAccessByUserEmail($email)) {
				Notice::page(Yii::t('notice', "Failed to add request. The email '{email}' is already linked up with '{individualTitle}'.", ['{email}' => $email, '{individualTitle}' => $model->individual->full_name]), Notice_ERROR);
			} else {
				Notice::page(Yii::t('notice', "Failed to add request. The email '{email}' is blocked by '{individualTitle}'.", ['{email}' => $email, '{individualTitle}' => $model->individual->full_name]), Notice_ERROR);
			}
		} else {
			if ($model->save()) {
				Notice::flash(Yii::t('notice', "Successfully added request from email '{email}' to join '{individualTitle}'.", ['{email}' => $email, '{individualTitle}' => $model->individual->full_name]), Notice_SUCCESS);
			}
		}

		$this->redirect(array('select', 'id' => $model->individual_id, 'realm' => $realm));
	}

	public function composeIndividualViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getIndividualViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getIndividualViewTabs($model, $realm));
			}
		}

		if ($realm == 'backend') {
			$tabs['individual'][] = array(
				'key' => 'organization',
				'title' => Yii::t('backend', 'Organization'),
				'viewPath' => 'views.individualOrganization.backend._view-individual-organization'
			);
		}

		ksort($tabs);

		// if (Yii::app()->user->isDeveloper) {
		if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) {
			$tabs['individual'][] = array(
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => '_view-meta'
			);
		}

		return $tabs;
	}
}
