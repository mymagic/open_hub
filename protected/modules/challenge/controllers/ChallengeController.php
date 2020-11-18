<?php

class ChallengeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
	 */
	public $layout = 'backend';

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'application.yeebase.extensions.OrderColumn.OrderAction',
				'modelClass' => 'Challenge',
				'pkName' => 'id',
				'backToAction' => 'admin',
			),
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'adminTrash', 'order', 'getTagsBackend', 'deactivate', 'deactivateConfirmed', 'activate', 'activateConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
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
		$model = new Challenge;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Challenge'])) {
			$model->attributes = $_POST['Challenge'];
			$model->creator_user_id = Yii::app()->user->id;

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');
			$model->imageFile_header = UploadedFile::getInstance($model, 'imageFile_header');
			if (!empty($model->date_open)) {
				$model->date_open = strtotime($model->date_open);
			}
			if (!empty($model->date_close)) {
				$model->date_close = strtotime($model->date_close);
			}

			$model->date_submit = time();

			if ($model->save()) {
				UploadManager::storeImage($model, 'cover', $model->tableName());
				UploadManager::storeImage($model, 'header', $model->tableName());
				$model->setTags($model->tag_backend)->save();
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

		if (isset($_POST['Challenge'])) {
			$model->attributes = $_POST['Challenge'];

			$model->imageFile_cover = UploadedFile::getInstance($model, 'imageFile_cover');
			$model->imageFile_header = UploadedFile::getInstance($model, 'imageFile_header');
			if (!empty($model->date_open)) {
				$model->date_open = strtotime($model->date_open);
			}
			if (!empty($model->date_close)) {
				$model->date_close = strtotime($model->date_close);
			}

			if ($model->save()) {
				UploadManager::storeImage($model, 'cover', $model->tableName());
				UploadManager::storeImage($model, 'header', $model->tableName());
				$model->setTags($model->tag_backend)->save();
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function actionDeactivate($id)
	{
		$model = $this->loadModel($id);

		if ($model->is_active == 1) {
			Notice::page(
				Yii::t('notice', "Are you sure to deactivate this record '{title}'? \n\nDeactivated record will be move to the recycle bin. Then, if required, you may restore this record anytime.", ['{title}' => $model->title]),
				Notice_WARNING,
			array('url' => $this->createUrl('deactivateConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "Record '{title}' is already deactivated.", ['{title}' => $model->title]), Notice_INFO);
			$this->redirect(array('challenge/view', 'id' => $id));
		}
	}

	public function actionDeactivateConfirmed($id)
	{
		$model = $this->loadModel($id);

		$model->is_active = 0;

		if ($model->save()) {
			Yii::app()->esLog->log(sprintf("deactivated Challenge '#%s - %s'", $model->id, $model->title), 'challenge', array('trigger' => 'ChallengeController::actionDeactivateConfirmed', 'model' => 'Challenge', 'action' => 'deactivateConfirmed', 'id' => $model->id));

			Notice::flash(Yii::t('notice', "Challenge '{title}' is successfully deactivated.", ['{title}' => $model->title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to deactivate challenge '{title}' due to unknown reason.", ['{title}' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('challenge/view', 'id' => $id));
	}

	public function actionActivate($id)
	{
		$model = $this->loadModel($id);

		if ($model->is_active == 0) {
			Notice::page(
				Yii::t('notice', "Are you sure to activate this record '{title}'? \n\nActivated record will be restore and move out from the recycle bin.", ['{title}' => $model->title]),
				Notice_WARNING,
			array('url' => $this->createUrl('activateConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "Record '{title}' is already activated.", ['{title}' => $model->title]), Notice_INFO);
			$this->redirect(array('challenge/view', 'id' => $id));
		}
	}

	public function actionActivateConfirmed($id)
	{
		$model = $this->loadModel($id);

		$model->is_active = 1;

		if ($model->save()) {
			Yii::app()->esLog->log(sprintf("activated Challenge '#%s - %s'", $model->id, $model->title), 'challenge', array('trigger' => 'ChallengeController::actionActivateConfirmed', 'model' => 'Challenge', 'action' => 'activateConfirmed', 'id' => $model->id));

			Notice::flash(Yii::t('notice', "Challenge '{title}' is successfully activated.", ['{title}' => $model->title]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to activate challenge '{title}' due to unknown reason.", ['{title}' => $model->title]), Notice_ERROR);
		}

		$this->redirect(array('challenge/view', 'id' => $id));
	}

	/**
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('challenge/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Challenge');
		$dataProvider->criteria->order = 'ordering ASC';
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
		$model = new Challenge('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Challenge'])) {
			$model->attributes = $_GET['Challenge'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}
		$model->is_active = 1;

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdminTrash()
	{
		$model = new Challenge('search');
		$model->unsetAttributes();  // clear any default values

		if (isset($_GET['Challenge'])) {
			$model->attributes = $_GET['Challenge'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}
		$model->is_active = 0;

		$this->render('adminTrash', [
			'model' => $model,
		]);
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
			if ($organization->id == $selected->ownerOrganization->id) {
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
	 * @return Challenge the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Challenge::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Challenge $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'challenge-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
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
}
