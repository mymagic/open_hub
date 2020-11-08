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

class IndividualOrganizationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 *             using two-column layout. See 'protected/views/layouts/backend.php'.
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
	 *
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
				'actions' => array('list', 'view', 'create', 'update', 'admin'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			// skip action ajax from checking the role for some reason. otherwise need to assign these actions for all roles even for view only role
			array(
				'allow',
				'actions' => array('ajaxOrganization', 'ajaxIndividual'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
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
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($individualId = '', $organizationCode = '')
	{
		$this->pageTitle = Yii::t('backend', 'Link Individual to Organization');
		$model = new IndividualOrganization();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (!empty($individualId) && $presetIndividual = Individual::model()->findByPk($individualId)) {
			$model->individual_id = $individualId;
			$model->individualTitle = $presetIndividual->full_name;
		}
		if (!empty($organizationCode) && $presetOrganization = Organization::code2obj($organizationCode)) {
			$model->organization_code = $organizationCode;
			$model->organizationTitle = $presetOrganization->title;
		}

		if (isset($_POST['IndividualOrganization'])) {
			$model->attributes = $_POST['IndividualOrganization'];

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_ended)) {
				$model->date_ended = strtotime($model->date_ended);
			}

			if ($model->save()) {
				$this->redirect(array('individual/view', 'id' => $model->individual->id));
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

		if (isset($_POST['IndividualOrganization'])) {
			$model->attributes = $_POST['IndividualOrganization'];

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_ended)) {
				$model->date_ended = strtotime($model->date_ended);
			}

			if ($model->save()) {
				$this->redirect(array('individual/view', 'id' => $model->individual->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Index.
	 */
	public function actionIndex()
	{
		$this->redirect(array('individualOrganization/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('IndividualOrganization');
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
		$model = new IndividualOrganization('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['IndividualOrganization'])) {
			$model->attributes = $_GET['IndividualOrganization'];
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

	public function actionAjaxIndividual($term = '', $id = '')
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

		$command = $command->select('id as id, full_name as text')->from('individual')->where(array('like', 'full_name', '%' . $term . '%'));
		// create
		if (empty($selected)) {
			// only active organization can be use
			$command = $command->andWhere('is_active=1');
		}
		$command = $command->order('full_name ASC')->limit(30);

		$results = array_merge($results, $command->queryAll());
		foreach ($results as &$result) {
			$individual = Individual::model()->findByPk($result['id']);
			if ($individual->id == $selected->individual->id) {
				$result['selected'] = true;
			}
			$result['imagePhotoThumbUrl'] = $individual->getImagePhotoThumbUrl();
		}
		$return['results'] = $results;
		$this->outputJsonRaw($return);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param int $id the ID of the model to be loaded
	 *
	 * @return IndividualOrganization the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = IndividualOrganization::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param IndividualOrganization $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'individual-organization-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
