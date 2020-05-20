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

class EventController extends Controller
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
				'actions' => ['list', 'view', 'create', 'update', 'admin', 'adminNoRegistration', 'overview', 'timeline', 'getTagsBackend', 'sendSurvey', 'sendSurveyConfirmed', 'exportRegistration'],
				'users' => ['@'],
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			],
			['deny',  // deny all users
				'users' => ['*'],
			],
		];
	}

	public function actionExportRegistration($id)
	{
		$model = $this->loadModel($id);

		$headers = array(
			'Registration Code',
			'Full Name	',
			'First Name',
			'Last Name',
			'Email',
			'Phone',
			'Company',
			'Gender',
			'Age Group',
			'Where Found',
			'Persona',
			'Nationality',
			'Is Attended',
			'Date Registered',
			'Date Payment',
		);

		$buffer[] = $headers;
		foreach ($model->eventRegistrations as $registration) {
			$record['registration_code'] = $registration->registration_code;
			$record['full_name'] = $registration->full_name;
			$record['first_name'] = $registration->first_name;
			$record['last_name'] = $registration->last_name;
			$record['email'] = $registration->email;
			$record['phone'] = $registration->phone;
			$record['organization'] = $registration->organization;
			$record['gender'] = $registration->gender;
			$record['age_group'] = $registration->age_group;
			$record['where_found'] = $registration->where_found;
			$record['persona'] = $registration->persona;
			$record['nationality'] = $registration->nationality;
			$record['is_attended'] = $registration->is_attended;
			$record['date_registered'] = $registration->renderDateRegistered();
			$record['date_payment'] = $registration->renderDatePayment();
			$buffer[] = $record;
		}

		$filename = sprintf('%s.%s.csv', date('Ymd', $model->date_started), $model->title);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$out = fopen('php://output', 'w');
		foreach ($buffer as $fields) {
			fputcsv($out, $fields);
		}
		fclose($out);
	}

	/**
	 * Displays a particular model.
	 *
	 * @param int $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $tab = 'comment')
	{
		if (empty($realm)) {
			$realm = 'backend';
		}
		if ($realm == 'cpanel') {
			$this->layout = 'cpanel';
		}
		$this->pageTitle = Yii::t('app', 'View Event');
		$model = $this->loadModel($id);
		$this->pageTitle = Yii::t('app', "View '{EventTitle}'", ['{EventTitle}' => $model->title]);

		$modelEventRegistration = new EventRegistration('search');
		$modelEventRegistration->unsetAttributes();
		$modelEventRegistration->event_id = $id;

		// check for member access, not admin
		if (!Yii::app()->user->accessBackend) {
			if (!$model->canAccessByUserEmail(Yii::app()->user->username)) {
				Notice::page(Yii::t('notice', 'Invalid Access'));
			}
		}

		$actions = [];
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getEventActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getEventActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getEventActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getEventActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeEventViewTabs($model, $realm);

		$this->render('view', [
			'model' => $model,
			'realm' => $realm,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
			'modelEventRegistration' => $modelEventRegistration,
		]);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($realm = 'backend')
	{
		$model = new Event();
		$model->vendor = 'manual';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Event'])) {
			$model->attributes = $_POST['Event'];
			$params['event'] = $_POST['Event'];
			$model = HubEvent::createEvent($_POST['Event']['title'], $params);

			if (!empty($model->id)) {
				$this->redirect(array('view', 'id' => $model->id, 'realm' => $realm));
			} else {
				Notice::page(Yii::t('notice', 'Failed to link data to creator'));
			}
		}

		$this->render('create', [
			'model' => $model,
			'realm' => $realm,
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
		if (isset($_POST['Event'])) {
			$oriModel = clone $model;
			$model->attributes = $_POST['Event'];
			$model->setLatLongAddress($_POST['Event']['latlong_address']);

			// convert full address to parts and store
			if (($oriModel->full_address != $model->full_address) && !empty($model->full_address)) {
				$model->resetAddressParts();
			}

			if (!empty($model->date_started)) {
				$model->date_started = strtotime($model->date_started);
			}
			if (!empty($model->date_ended)) {
				$model->date_ended = strtotime($model->date_ended);
			}

			if ($model->save()) {
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
		$this->redirect(['event/overview']);
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Event');
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
		$model = new Event('search');
		$model->unsetAttributes();  // clear any default values
		$model->is_active = 1;

		if (isset($_GET['Event'])) {
			$model->attributes = $_GET['Event'];
		}
		if (Yii::app()->request->getParam('clearFilters')) {
			EButtonColumnWithClearFilters::clearFilters($this, $model);
		}

		$this->render('admin', [
			'model' => $model,
		]);
	}

	public function actionAdminNoRegistration()
	{
		$sqlCount = 'SELECT COUNT(e.id) FROM event e LEFT JOIN event_registration r ON e.id=r.event_id LEFT JOIN event_organization o ON e.id=o.event_id WHERE (o.event_id IS NULL AND r.event_id IS NULL) AND e.is_active=1 AND e.is_cancelled != 1 ORDER BY `e`.`date_started` DESC';
		$count = Yii::app()->db->createCommand($sqlCount)->queryScalar();

		$sql = 'SELECT e.* FROM event e LEFT JOIN event_registration r ON e.id=r.event_id LEFT JOIN event_organization o ON e.id=o.event_id WHERE (o.event_id IS NULL AND r.event_id IS NULL) AND e.is_active=1 AND e.is_cancelled != 1 ORDER BY `e`.`date_started` DESC';

		$dataProvider = new CSqlDataProvider($sql, [
			'totalItemCount' => $count,
			'pagination' => [
				'pageSize' => 30,
			],
		]);

		$this->render('adminNoRegistration', [
			'events' => $dataProvider,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param int $id the ID of the model to be loaded
	 *
	 * @return Event the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Event::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function actionOverview()
	{
		//$this->redirect(array('event/timeline'));
		$stat['general']['totalEvents'] = Event::model()->countByAttributes(['is_active' => 1]);
		$stat['general']['totalCancelledEvents'] = Event::model()->countByAttributes(['is_cancelled' => 1]);
		$stat['general']['totalActiveEventGroups'] = EventGroup::model()->countByAttributes(['is_active' => 1]);

		$stat['general']['totalRegistrations'] = Yii::app()->db->createCommand('SELECT COUNT(er.id) FROM event_registration as er LEFT JOIN event as e ON er.event_code=e.code WHERE e.is_active=1')->queryScalar();
		$stat['general']['totalAttendedRegistrations'] = Yii::app()->db->createCommand('SELECT COUNT(er.id) FROM event_registration as er LEFT JOIN event as e ON er.event_code=e.code WHERE e.is_active=1 AND er.is_attended=1')->queryScalar();

		$stat['general']['totalUniqueRegistrations'] = Yii::app()->db->createCommand('SELECT COUNT(DISTINCT(email)) FROM event_registration')->queryScalar();
		$stat['general']['totalUniqueAttendedRegistrations'] = Yii::app()->db->createCommand('SELECT COUNT(DISTINCT(email)) FROM event_registration WHERE is_attended=1')->queryScalar();

		$stat['gender']['male'] = Yii::app()->db->createCommand("SELECT COUNT(id) FROM event_registration WHERE gender='male'")->queryScalar();
		$stat['gender']['female'] = Yii::app()->db->createCommand("SELECT COUNT(id) FROM event_registration WHERE gender='female'")->queryScalar();
		$stat['gender']['unknown'] = Yii::app()->db->createCommand("SELECT COUNT(id) FROM event_registration WHERE gender='unknown' OR gender IS NULL")->queryScalar();

		$stat['gender']['uniqueMale'] = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(email)) FROM event_registration WHERE gender='male'")->queryScalar();
		$stat['gender']['uniqueFemale'] = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(email)) FROM event_registration WHERE gender='female'")->queryScalar();
		$stat['gender']['uniqueUnknown'] = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(email)) FROM event_registration WHERE gender='unknown' OR gender IS NULL")->queryScalar();

		$stat['quality']['noRegistration'] = Yii::app()->db->createCommand('SELECT COUNT(e.id) FROM event e LEFT JOIN event_registration r ON e.id=r.event_id LEFT JOIN event_organization o ON e.id=o.event_id WHERE (o.event_id IS NULL AND r.event_id IS NULL) AND e.is_active=1 AND e.is_cancelled != 1 ORDER BY `e`.`id` ASC')->queryScalar();
		$stat['quality']['noName'] = Yii::app()->db->createCommand('SELECT COUNT(id) FROM event_registration WHERE (first_name="" OR first_name IS NULL) AND (last_name="" OR last_name IS NULL)')->queryScalar();
		$stat['quality']['noEmail'] = Yii::app()->db->createCommand('SELECT COUNT(id) FROM event_registration WHERE (email="" OR email IS NULL)')->queryScalar();
		$stat['quality']['noNationality'] = Yii::app()->db->createCommand('SELECT COUNT(id) FROM event_registration WHERE (nationality="" OR nationality IS NULL)')->queryScalar();
		$stat['quality']['noEventVendorCode'] = Yii::app()->db->createCommand('SELECT COUNT(id) FROM event_registration WHERE (event_vendor_code="" OR event_vendor_code IS NULL)')->queryScalar();

		//$stat['general']['totalDraftEvents'] = 0;
		$this->render('overview', ['stat' => $stat]);
	}

	public function actionTimeline($year = '')
	{
		if (empty($year)) {
			$year = date('Y');
		}

		$timestampStart = gmmktime(0, 0, 0, 1, 1, $year);
		//echo date("r", $timestampStart);
		$timestampEnd = strtotime(date('r', $timestampStart) . ' +1 year');
		//echo date("r", $timestampEnd);exit;

		$sql = sprintf('SELECT * FROM event WHERE date_started>=%s AND date_started <%s AND is_active=1 AND is_cancelled!=1 ORDER BY date_started DESC', $timestampStart, $timestampEnd);
		$model['events'] = Event::model()->findAllBySql($sql);

		$this->render('timeline', ['model' => $model, 'year' => $year]);
	}

	public function actionGetTagsBackend()
	{
		header('Content-type: application/json');

		$tmps = Tag::model()->findAll(['select' => 'name', 'order' => 'name ASC']);
		foreach ($tmps as $t) {
			$result[] = $t->name;
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}

	public function actionSendSurvey($eventId)
	{
		$surveyType = Yii::app()->request->getParam('surveyType');
		$event = Event::model()->findByPk($eventId);
		$surveyForm = HubEvent::getSurveyForm($eventId, $surveyType);

		Notice::page(
			Yii::t('notice', "Are you sure to send survey '{surveyTitle}' to all attended participants of event #{eventId} '{eventTitle}'", ['{eventId}' => $event->id, '{eventTitle}' => $event->title, '{surveyTitle}' => $surveyForm->title]),
			Notice_WARNING,
			['url' => $this->createUrl('sendSurveyConfirmed', ['eventId' => $event->id, 'surveyType' => $surveyType]), 'cancelUrl' => $this->createUrl('view', ['id' => $event->id])]
		);
	}

	public function actionSendSurveyConfirmed($eventId, $surveyType)
	{
		$settingSendEmailSurvey = Setting::code2value('event-sendPostSurveyEmail');
		if (!$settingSendEmailSurvey) {
			Notice::page(
				Yii::t('notice', 'Sending post survey email failed due to this function has been disabled it setting'),
				Notice_ERROR,
				['url' => $this->createUrl('event/view', ['id' => $eventId])]
			);
		}

		$surveyTypes = HubEvent::getSurveyTypes($eventId);
		$numberOfDays = $surveyTypes[$surveyType]['numberOfDays'];

		// send email
		$result = HubEvent::sendSurveyEmailAfterEvent($surveyType, $eventId);

		Notice::page(
			Yii::t('notice', 'Ok Done. There are {totalReceivers} potential receivers. Please note that email will not be sent to the same participant twice.', ['{totalReceivers}' => count($result[0]['participants'])]),
			Notice_INFO,
			['url' => $this->createUrl('event/view', ['id' => $eventId])]
		);
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param Event $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function composeEventViewTabs($model, $realm = 'backend')
	{
		$tabs = [];

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getEventViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getEventViewTabs($model, $realm));
			}
		}

		if ($realm == 'backend') {
		}

		ksort($tabs);

		// if (Yii::app()->user->isDeveloper) {
		if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) {
			$tabs['event'][] = [
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => '_view-meta',
			];
		}

		return $tabs;
	}
}
