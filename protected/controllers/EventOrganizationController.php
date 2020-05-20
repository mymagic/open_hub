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
class EventOrganizationController extends Controller
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'bulkInsert', 'delete'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
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
		$model = new EventOrganization;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EventOrganization'])) {
			$model->attributes = $_POST['EventOrganization'];
			// source, how we enter this event. eg: manual, atas, bizzabo...
			$model->event_vendor_code = 'manual';
			if (!empty($model->organization_id)) {
				$organization = Organization::model()->findByPk($model->organization_id);
				$model->organization_name = $organization->title;
			}

			if (!empty($model->date_action)) {
				$model->date_action = strtotime($model->date_action);
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['EventOrganization'])) {
			$model->attributes = $_POST['EventOrganization'];

			if (!empty($model->date_action)) {
				$model->date_action = strtotime($model->date_action);
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
		$this->redirect(array('event-organization/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('EventOrganization');
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
		$model = new EventOrganization('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['EventOrganization'])) {
			$model->attributes = $_GET['EventOrganization'];
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
	 * @return EventOrganization the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = EventOrganization::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function actionBulkInsert($eventId = '')
	{
		$settingTemplateFile = Setting::code2value('eventOrganization-bulkInsertTemplateFile');
		$model = new EventOrganizationBulkInsertForm;

		if (!empty($eventId)) {
			$model->event_id = $eventId;
			$event = Event::model()->findByPk($eventId);
			if (!$event->is_active || $event->is_cancelled) {
				Notice::page('Unable to proceed with this event. You are only allowed to bulk insert into an active and not cancelled event');
			}
			$events[] = $event;
		} else {
			$events = Event::model()->with(null)->isActive()->isNotCancelled()->findAll(array('select' => 'id, title', 'order' => 'title'));
		}

		if (isset($_POST['EventOrganizationBulkInsertForm'])) {
			$model->attributes = $_POST['EventOrganizationBulkInsertForm'];
			$event = Event::model()->findByPk($model->event_id);
			$model->uploadFile_excel = UploadedFile::getInstance($model, 'uploadFile_excel');
			//print_r($model);exit;

			//print_r($_FILES['EventOrganizationBulkInsertForm']['tmp_name']['uploadFile_excel']);exit;
			$inputFileName = $_FILES['EventOrganizationBulkInsertForm']['tmp_name']['uploadFile_excel'];
			$sheetname = 'main';

			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$reader->setLoadSheetsOnly($sheetname);
			$spreadsheet = $reader->load($inputFileName);
			$sheetRows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

			// print_r($sheetRows);exit;

			// not to process fundraised, revenue, teamsize column first (skip)

			/*
				[A] Date Register
				[B] Organization Name
				[C] Website
				[D] Country of Origin
				[E] Description
				[F] One Linear
				[G] Industry (skip)
				[H] Logo Link (skip)
				[I] Year Founded
				[J] as_role_code
				[K] Fundraised (Before) (skip)
				[L] Revenue (Before) (skip)
				[M] Team Size (Before) (skip)

				[O] Founder Name #1
				[P] Founder Email #1
				[Q] Founder Contact No #1

				[R] founder #2 Name
				[S] Founder #2 Email
				[T] Founder Contact No #2

				[U] founder #3 Name
				[V] Founder #3 Email
				[W] Founder Contact No #3
			*/

			$count = 0;
			foreach ($sheetRows as $row) {
				$count++;
				if ($count == 1) {
					continue;
				}

				$asRoleCode = $row['J'];
				$dateAction = $row['A'];
				$organizationTitle = trim($row['B']);

				// check if organization exists by title, if yes use the existing, else create new
				if ($existingId = Organization::isTitleExists($organizationTitle)) {
					$organization = Organization::model()->findByPk($existingId);
					if (!empty($organization)) {
						if (empty($organization->year_founded)) {
							$organization->year_founded = $row['I'];
						}
						if (empty($organization->url_website)) {
							$organization->url_website = $row['C'];
						}
						if (empty($organization->text_oneliner)) {
							$organization->text_oneliner = $row['E'];
						}
						if (empty($organization->text_short_description)) {
							$organization->text_short_description = $row['F'];
						}
						$organization->save();
					}
				} else {
					$params['organization']['one_liner'] = $row['F'];
					$params['organization']['text_short_description'] = $row['E'];
					//$params['emailContact'] ;
					$params['organization']['year_founded'] = $row['I'];
					$params['organization']['url_website'] = $row['C'];
					$organization = HUB::createOrganization($organizationTitle, $params);
					$organization->save();
				}

				// add event_organization
				if (!$organization->hasEventOrganization($event->code, $asRoleCode)) {
					$organization->addEventOrganization($event->code, $asRoleCode, array(
						'eventId' => $event->id,
						'eventVendorCode' => 'manual',
						'registrationCode' => '',
						'dateAction' => strtotime($dateAction),
					));
				}

				$founders = array();
				// founder 1
				if (!empty($row['O'])) {
					$founders[] = array('name' => $row['O'], 'email' => $row['P'], 'contact' => $row['Q']);
				}
				// founder 2
				if (!empty($row['R'])) {
					$founders[] = array('name' => $row['R'], 'email' => $row['S'], 'contact' => $row['T']);
				}
				// founder 3
				if (!empty($row['U'])) {
					$founders[] = array('name' => $row['U'], 'email' => $row['V'], 'contact' => $row['W']);
				}

				// foreach founder
				if (!empty($founders)) {
					foreach ($founders as $founder) {
						// add organization2email
						// add access if email is set and organization do not have such user email yet
						if (!empty($founder['email']) && YsUtil::isEmailAddress($founder['email']) && !$organization->hasUserEmail($founder['email'])) {
							$o2e = new Organization2Email;
							$o2e->organization_id = $organization->id;
							$o2e->user_email = $founder['email'];
							$o2e->status = 'approve';
							$o2e->save();
						}

						// check if individual exists by name, if yes use existing, else create new
						if ($idvId = Individual::isFullnameExists($founder['name'])) {
							$individual = HubIndividual::getIndividual($idvId);
							if (empty($individual->mobile_number)) {
								$individual->mobile_number = $founder['contact'];
							}
							$individual->save();
						} else {
							$individual = new Individual;
							$individual->full_name = $founder['name'];
							$individual->mobile_number = $founder['contact'];
							$individual->save();
						}

						// add individual_organization if organization do not have this individual
						if (!$organization->hasIndividualOrganization($individual->id, 'founder')) {
							$organization->addIndividualOrganization($individual->id, 'founder');
						}

						// add individual2email if email is set
						if (!empty($founder['email']) && !$individual->hasUserEmail($founder['email'])) {
							$i2o = new Individual2Email;
							$i2o->individual_id = $individual->id;
							$i2o->user_email = $founder['email'];
							$i2o->is_verify = 0;
							$i2o->save();
						}
					}
				}
			}

			Notice::page(
				Yii::t('backend', 'Successfully loaded {count} companies into event {eventName}', ['{count}' => $count - 1, '{eventName}' => $event->title]),
				Notice_SUCCESS,
				array('url' => $this->createUrl('/event/view', array('id' => $event->id)))
			);
		}

		$this->render('bulkInsert', array('model' => $model, 'events' => $events, 'settingTemplateFile' => $settingTemplateFile));
	}

	public function actionDelete($id, $returnUrl = '')
	{
		$this->loadModel($id)->delete();

		if (empty($returnUrl) && !empty($_POST['returnUrl'])) {
			$returnUrl = $_POST['returnUrl'];
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($returnUrl) ? $returnUrl : array('admin'));
		}

		if (!empty($returnUrl)) {
			$this->redirect($returnUrl);
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param EventOrganization $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-organization-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
