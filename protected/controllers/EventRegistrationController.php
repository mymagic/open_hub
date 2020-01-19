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

class EventRegistrationController extends Controller
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'syncFromBizzabo', 'syncFromBizzaboConfirmed', 'housekeeping', 'housekeepingConfirmed', 'bulkInsert', 'bulkInsertConfirmed'),
				'users' => array('@'),
				'expression' => '$user->isAdmin==true',
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
	public function actionCreate()
	{
		$model = new EventRegistration();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EventRegistration'])) {
			$model->attributes = $_POST['EventRegistration'];

			if (!empty($model->date_registered)) {
				$model->date_registered = strtotime($model->date_registered);
			}
			if (!empty($model->date_payment)) {
				$model->date_payment = strtotime($model->date_payment);
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
	 *
	 * @param int $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EventRegistration'])) {
			$model->attributes = $_POST['EventRegistration'];

			if (!empty($model->date_registered)) {
				$model->date_registered = strtotime($model->date_registered);
			}
			if (!empty($model->date_payment)) {
				$model->date_payment = strtotime($model->date_payment);
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
	 * Index.
	 */
	public function actionIndex()
	{
		$this->redirect(array('event-registration/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('EventRegistration');
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
		$model = new EventRegistration('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['EventRegistration'])) {
			$model->attributes = $_GET['EventRegistration'];
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
	 *
	 * @param int $id the ID of the model to be loaded
	 *
	 * @return EventRegistration the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = EventRegistration::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	// sync event data from bizzabo thru intermediate database at misc
	// please not that this only sync event entires, but not the registration data
	// todo: modularize
	public function actionSyncFromBizzabo($dateStart = '', $dateEnd = '')
	{
		Notice::page(Yii::t('backend', 'You are about to sync event registration record from Bizzbo, thru an intermediate Database that periodically in sync with Bizzabo API. Please take note that this function only sync the latest 5k records and the stability depends on your server setting. Click OK to continue.'), Notice_WARNING, array(
			'url' => $this->createUrl('eventRegistration/syncFromBizzaboConfirmed', array('dateStart' => $dateStart, 'dateEnd' => $dateEnd)),
			'cancelUrl' => $this->createUrl('eventRegistration/admin'),
		));
	}

	// todo: modularize
	public function actionSyncFromBizzaboConfirmed($dateStart = '', $dateEnd = '')
	{
		// limit to latest 5k records
		$result = HubBizzabo::syncEventRegistrationFromBizzabo($dateStart, $dateEnd, 5000);
		if ($result['status'] == 'success') {
			Notice::page($result['msg'], Notice_SUCCESS, array('url' => $this->createUrl('admin')));
		} else {
			Notice::page($result['msg'], Notice_ERROR);
		}

		Yii::app()->end();
	}

	public function actionHousekeeping()
	{
		Notice::page(Yii::t('backend', 'You are about to perform housekeeping on event registration data:'), Notice_WARNING, array(
			'url' => $this->createUrl('eventRegistration/housekeepingConfirmed', array()),
			'cancelUrl' => $this->createUrl('eventRegistration/admin'), 'htmlMessage' => '<ol>
				<li>Fill up nationality field (Malaysia only)</li>
				<li>Identify bumi thru person name analytics</li>
				<li>Fill up Event ID base on Event Code</li>
			</ol>',
		));
	}

	public function actionHousekeepingConfirmed()
	{
		$sqls = array();
		$success = false;

		// figure nationality
		$buffer = 'UPDATE event_registration SET nationality=\'MY\' WHERE json_original REGEXP \'"country":"Malaysia",\' AND nationality IS NULL';
		// $buffer = 'UPDATE event_registration SET nationality=\'MY\' WHERE json_original LIKE \'%"country":"Malaysia",%\' AND nationality IS NULL';
		$sqls[] = $buffer;

		// figure event id base on code
		$sqls[] = sprintf('UPDATE `event_registration` as er, event as e SET er.event_id=e.id WHERE er.event_id IS NULL and er.event_code=e.code');

		$transaction = Yii::app()->db->beginTransaction();
		try {
			foreach ($sqls as $sql) {
				$results[] = Yii::app()->db->createCommand($sql)->execute();
			}

			$transaction->commit();

			// select list of event registration
			/*
			 * this one a lot faster than EventRegistration::model()->findAll()
			 */
			$condition = 'LOWER(nationality) = :nationality AND json_original REGEXP :json_original';
			$params = [':nationality' => 'my', ':json_original' => '"country":"Malaysia",'];
			$rows = Yii::app()->db->createCommand()
				->select('id')
				->from('event_registration')
				->where($condition, $params)
				->queryAll();

			// $i = 0;
			$updateMsg = [];
			foreach ($rows as $row) {
				$evenRegistration = EventRegistration::model()->findByPk($row['id']);
				// skip if record already have meta record
				if (!isset($evenRegistration->_dynamicData['EventRegistration-status-isBumi']) || !isset($evenRegistration->_dynamicData['EventRegistration-status-isIndian'])) {
					$update = HUB::updateBumiIndianStatusForEventRegistration($evenRegistration);
					$updateMsg[] = sprintf('ID: #%d - Full Name: %s; isBumi %s; isIndian %s', $evenRegistration->id, $evenRegistration->full_name, Html::renderBoolean(HUB::checkEventRegistrationIsBumiStatus($evenRegistration)), Html::renderBoolean(HUB::checkEventRegistrationIsIndianStatus($evenRegistration)));
					// $i++;
				}
				// if($i==20) break;
			}

			$success = true;
		} catch (Exception $e) { // an exception is raised if a query fails
			$transaction->rollBack();
		}

		if ($success) {
			/*$htmlMessage = '<ol>';
			foreach($results as $result)
			{
				$htmlMessage = sprintf('<li>%s</li>', $result);
			}
			$htmlMessage .= '</ol>';*/

			$htmlMessage = '<small class="text-muted"><ol>';
			foreach ($sqls as $sql) {
				$htmlMessage .= sprintf('<li>%s;</li>', $sql);
			}
			if (isset($updateMsg)) {
				foreach ($updateMsg as $msg) {
					$htmlMessage .= sprintf('<li>%s</li>', $msg);
				}
			}
			$htmlMessage .= '</ol></small>';

			Notice::page(Yii::t('backend', 'Housekeeping completed'), Notice_SUCCESS, array('url' => $this->createUrl('admin'), 'htmlMessage' => $htmlMessage));
		} else {
			Notice::page(Yii::t('backend', 'Housekeeping failed'), Notice_SUCCESS, array('url' => $this->createUrl('admin')));
		}

		Yii::app()->end();
	}

	public function actionBulkInsert($eventId = '')
	{
		$settingTemplateFile = Setting::code2value('eventRegistration-bulkInsertTemplateFile');
		$model = new EventRegistrationBulkInsertForm();

		if (!empty($eventId)) {
			$model->event_id = $eventId;
			$event = Event::model()->findByPk($eventId);
			if (!$event->is_active || $event->is_cancelled) {
				Notice::page('Unable to proceed with this event. You are only allowed to bulk insert into an active and not cancelled event');
			}
		}

		$events = Event::model()->with(null)->isActive()->isNotCancelled()->findAll(array('select' => 'id, title', 'order' => 'title'));

		if (isset($_POST['EventRegistrationBulkInsertForm'])) {
			$model->attributes = $_POST['EventRegistrationBulkInsertForm'];
			$event = Event::model()->findByPk($model->event_id);
			$model->uploadFile_excel = UploadedFile::getInstance($model, 'uploadFile_excel');
			//print_r($model);exit;

			//print_r($_FILES['EventRegistrationBulkInsertForm']['tmp_name']['uploadFile_excel']);exit;
			$inputFileName = $_FILES['EventRegistrationBulkInsertForm']['tmp_name']['uploadFile_excel'];
			$sheetname = 'main';

			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$reader->setLoadSheetsOnly($sheetname);
			$spreadsheet = $reader->load($inputFileName);
			$sheetRows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

			//print_r($sheetRows);exit;
			/*
				[A] => Date Register
				[B] => Email
				[C] => Full Name
				[D] => Attended?
				[E] => Paid Fee (RM)
				[F] => Nationality
				[G] => Persona
				[H] => Phone
				[I] => Organization
			*/
			$count = 0;
			foreach ($sheetRows as $row) {
				++$count;
				if ($count == 1) {
					continue;
				}

				$sql = 'INSERT INTO event_registration (event_id, event_code, event_vendor_code, date_registered, date_payment, full_name, email, is_attended, paid_fee, nationality, persona, phone, organization, date_added, date_modified) VALUES (:event_id, :event_code, :event_vendor_code, :date_registered, :date_payment, :full_name, :email, :is_attended, :paid_fee, :nationality, :persona, :phone, :organization, :date_added, :date_modified) ON DUPLICATE KEY UPDATE event_vendor_code=event_vendor_code, date_registered=date_registered, date_payment=date_payment, full_name=full_name, email=email, is_attended=is_attended, paid_fee=paid_fee, nationality=nationality, persona=persona, phone=phone, organization=organization, date_modified=date_modified';

				$command = Yii::app()->db->createCommand($sql)->bindValues(
					array(':event_id' => $event->id, ':event_code' => $event->code, ':event_vendor_code' => 'manual',
					':full_name' => $row['C'], ':email' => $row['B'], ':is_attended' => $row['D'], ':paid_fee' => $row['E'], ':nationality' => $row['F'], ':persona' => $row['G'], ':phone' => $row['H'], ':organization' => $row['I'], ':date_registered' => strtotime($row['A']), ':date_payment' => strtotime($row['A']),
					':date_added' => time(), ':date_modified' => time(), )
				)->execute();
			}

			Notice::page(
				Yii::t('backend', 'Successfully loaded {count} records into event {eventName}', ['{count}' => $count - 1, '{eventName}' => $event->title]),
				Notice_SUCCESS,
				array('url' => $this->createUrl('/event/view', array('id' => $event->id)))
			);
		}

		$this->render('bulkInsert', array('model' => $model, 'events' => $events, 'settingTemplateFile' => $settingTemplateFile));
	}

	public function actionBulkInsertConfirmed()
	{
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param EventRegistration $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-registration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
