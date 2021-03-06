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
class EventOwnerController extends Controller
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'delete'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			// skip action ajax from checking the role for some reason. otherwise need to assign these actions for all roles even for view only role
			array(
				'allow',
				'actions' => array('ajaxOrganization', 'ajaxEvent'),
				'users' => array('@'),
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
	public function actionCreate($eventCode = '')
	{
		$this->pageTitle = Yii::t('backend', 'Set Event Owner');
		$model = new EventOwner;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (!empty($eventCode)) {
			$model->event_code = $eventCode;
		}

		if (isset($_POST['EventOwner'])) {
			$model->attributes = $_POST['EventOwner'];

			if ($model->save()) {
				Yii::app()->esLog->log(sprintf("created Event Owner '%s' to Event '%s'", $model->organization->title, $model->event->title), 'eventOwner', array('trigger' => 'EventOwnerController::actionCreate', 'model' => 'EventOwner', 'action' => 'create', 'id' => $model->id));

				$this->redirect(array('event/view', 'id' => $model->event->id));
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

		if (isset($_POST['EventOwner'])) {
			$model->attributes = $_POST['EventOwner'];

			if ($model->save()) {
				Yii::app()->esLog->log(sprintf("updated Event Owner '%s' to Event '%s'", $model->organization->title, $model->event->title), 'eventOwner', array('trigger' => 'EventOwnerController::actionUpdate', 'model' => 'EventOwner', 'action' => 'update', 'id' => $model->id));

				$this->redirect(array('event/view', 'id' => $model->event->id));
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
		$this->redirect(array('event-owner/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('EventOwner');
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
		$model = new EventOwner('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['EventOwner'])) {
			$model->attributes = $_GET['EventOwner'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$copy = clone $model;

		if ($model->delete()) {
			Yii::app()->esLog->log(sprintf("deleted Event Owner '%s' to Event '%s'", $copy->organization->title, $copy->event->title), 'eventOwner', array('trigger' => 'EventOwnerController::actionDelete', 'model' => 'EventOwner', 'action' => 'delete', 'id' => $copy->id));

			Notice::flash(Yii::t('notice', "'{organizationTitle}' has been unlinked from this event", array('{organizationTitle}' => $model->organization->title)), Notice_SUCCESS);
		}
		$this->redirect(array('event/view', 'id' => $copy->event->id));
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

		$command = $command->select('code as id, title as text')->from('organization')->where(array('like', 'title', '%' . $term . '%'));
		// create
		if (empty($selected)) {
			// only active organization can be use
			$command = $command->andWhere('is_active=1');
		}
		$command = $command->order('title ASC')->limit(30);

		$results = array_merge($results, $command->queryAll());
		foreach ($results as &$result) {
			$organization = Organization::code2obj($result['id']);
			if ($organization->code == $selected->organization->code) {
				$result['selected'] = true;
			}
			$result['textOneliner'] = !empty($organization->text_oneliner) ? ysUtil::truncate($organization->text_oneliner) : '-';
			$result['urlWebsite'] = !empty($organization->url_website) ? $organization->url_website : '-';
			$result['imageLogoThumbUrl'] = $organization->getImageLogoThumbUrl();
		}
		$return['results'] = $results;
		$this->outputJsonRaw($return);
	}

	public function actionAjaxEvent($term = '', $id = '')
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

		$command = $command->select('code as id, title as text')->from('event')->where(array('like', 'title', '%' . $term . '%'));
		// create
		if (empty($selected)) {
			// only active organization can be use
			$command = $command->andWhere('is_active=1');
		}
		$command = $command->order('title ASC')->limit(30);

		$results = array_merge($results, $command->queryAll());
		foreach ($results as &$result) {
			$event = Event::code2obj($result['id']);
			if ($event->code == $selected->event->code) {
				$result['selected'] = true;
			}
			$result['at'] = !empty($event->at) ? ysUtil::truncate($event->at) : '-';
			$result['dateStarted'] = $event->renderDateStarted();
			$result['dateEnded'] = $event->renderDateEnded();
		}
		$return['results'] = $results;
		$this->outputJsonRaw($return);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EventOwner the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = EventOwner::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EventOwner $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-owner-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
