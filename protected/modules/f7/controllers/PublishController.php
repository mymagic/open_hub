<?php

class PublishController extends Controller
{
	//public $layout = 'frontend';

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
			array('allow',
				'actions' => array('index')),
			array('allow',
				'actions' => array('save', 'view', 'edit', 'revert', 'revertConfirmed'),
				'expression' => 'Yii::app()->controller->verifyAccess()',
			),
			array('allow',
				'actions' => array('download'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->layoutParams['isShowMenuSubLanguageSelector'] = true;
	}

	public function actionIndex($slug, $sid = '')
	{
		$form = Form::slug2obj($slug);
		if (!isset($form)) {
			throw new Exception('Form not exists');
		}
		if (!isset($form->jsonArray_stage)) {
			throw new Exception('Stages pipeline must be defined in form');
		}
		$this->pageTitle = Yii::t('app', $form->title);

		$this->layout = 'publish';
		if (isset($form->jsonArray_extra->customLayout)) {
			$this->layout = $form->jsonArray_extra->customLayout->path;
		}

		if (!empty($form->intakes) && !empty($form->intakes[0]) && !empty($form->intakes[0]->brandCode)) {
			$this->layoutParams['brand'] = $form->intakes[0]->brandCode;
		}

		// Check if closing time of the application has reached
		if ($form->isApplicationClosed()) {
			return $this->render('index', array('form' => $form, 'htmlForm' => $form->getEmptyForm()));
		}

		// cannot submit
		if (!HubForm::canSubmit($form, $sid)) {
			$closingTimeFormatted = Html::formatDateTimezone($form->date_close, 'standard', 'standard', '-', $form->timezone);

			$closingDate = empty($form->date_close) ? Yii::t('f7', 'closing date') : $closingTimeFormatted;

			$error = Yii::t('f7', 'Please note that multiple submissions is not allowed for this form. However, You can edit existing Submission(s) before {closingDate}.', array('{closingDate}' => $closingDate));

			$form->addError($error, $error);

			return $this->render('index', array('form' => $form, 'htmlForm' => $form->getEmptyForm()));
		}

		$submission = FormSubmission::model()->findByAttributes(array('form_code' => $form->code, 'id' => $sid, 'user_id' => Yii::app()->user->id));

		// if data not found (ensure this submission belongs to this user)
		if (!empty($sid) && empty($data)) {
			return $this->redirect("/f7/publish/index/$slug");
		}

		$htmlForm = HubForm::convertJsonToHtml(true, $form->json_structure, $submission->json_data, $form->slug, $sid);

		$uploadControls = HubForm::getListOfExistingUploadControlsWithValue($submission->json_data);
		// ys: using session here can be dangerous as user might open multiple tab
		$session = Yii::app()->session;
		foreach ($uploadControls as $uploadControl => $value) {
			$awsPath = $uploadControl . '.aws_path';
			$session['uploadfiles'] = array($awsPath => $value);
		}

		$this->render('index', array('form' => $form, 'htmlForm' => $htmlForm));
	}

	// sid: submission id, can be empty when call by actionIndex to create new submission
	public function actionSave($slug, $sid = '')
	{
		set_time_limit(0);
		$form = Form::slug2obj($slug);

		if (empty($form)) {
			throw new Exception(Yii::t('f7', 'Form not exists.'));
		}
		$this->layout = '/layouts/publish';

		// if application is closed now, show view
		if ($form->isApplicationClosed()) {
			// return $this->render('index', array('form' => $form, 'htmlForm' => $form->getEmptyForm()));
			Notice::page(Yii::t('f7', 'Application has closed. Form submission not saved!'), Notice_WARNING);
		}

		// if not allow multiple submission;
		if (!HubForm::canSubmit($form, $sid)) {
			$message = Yii::t('f7', 'Please note that multiple submissions is not allowed for this form.');
			//$form->addError($message, $message);
			//return $this->render('index', array('form' => $form, 'htmlForm' => $form->getEmptyForm()));
			Notice::page($message, Notice_WARNING);
		}

		if ($form->hasStage()) {
			$stage = $form->jsonArray_stage[0]->key;
		}

		// load existing submission from database
		$submission = FormSubmission::model()->findByAttributes(array('form_code' => $form->code, 'id' => $sid, 'user_id' => Yii::app()->user->id));
		// submission id is set but failed to get such record
		if (!empty($sid) && empty($submission)) {
			Notice::page(Yii::t('f7', 'Matching submission record not found!'), Notice_WARNING);
		}

		// save draft
		$htmlForm = HubForm::convertJsonToHtml(true, $form->json_structure, $submission->json_data, $form->slug, $sid);

		// if submit
		if (strtolower($_POST['save']) === 'submit') {
			// validate input data
			list($validated, $htmlForm) = $this->performValidation($form, $_POST, $slug, $submission, $sid);
			// not validated
			if (!$validated) {
				return $this->render('index', array('form' => $form, 'htmlForm' => $htmlForm, 'slug' => $slug, 'sid' => $submission->id));
			}
		}

		$data = array();
		// load existing json_data
		if (!empty($submission->json_data)) {
			$decodedJsonData = json_decode($submission->json_data);
			foreach ($decodedJsonData as $jVar => $jValue) {
				// upload file field found in existing data
				// pre inherite existing upload file data, so that user save existing draft wont wipe of previously uploaded file data
				if (strstr($jVar, '.aws_path')) {
					$data[$jVar] = $jValue;
				}
			}
		}

		$orgTitleSubmittedByUser = '';
		$formContainStarupModel = false;
		$icCounter = 0;

		foreach ($_POST as $key => $value) {
			if ($key === 'YII_CSRF_TOKEN' || $key === 'form_code' || $key === 'sid') {
				continue;
			}

			// ys: should not be hardcoded like this
			if ($key == 'startup') {
				$formContainStarupModel = true;
				$orgObj = Organization::title2obj($value);
				$data['startup_id'] = empty($orgObj) ? '' : $orgObj->id;
			}

			// ys: should not be hardcoded like this
			if (substr($key, 0, 12) === 'fnationality') {
				$country = Country::model()->findByAttributes(array('name' => $value));
				$splitted = explode('fnationality', $key);
				$num = count($splitted) === 2 ? $splitted[1] : '';
				$keyname = sprintf('fnationality%s_code', $num);
				$data[$keyname] = $country->code;
			}

			// ys: should not be hardcoded like this
			if (strpos($key, 'icnumber') !== false) {
				$icCounter++;
				$keyname = "calculated_age_$icCounter";
				if (strlen($value) > 0 && ctype_digit(substr($value, 0, 1))) {
					$data[$keyname] = $this->getAgeFromIC($value);
				}
			}

			$data[$key] = $value;

			if (strtolower($key) === 'startup') {
				$orgTitleSubmittedByUser = $value;
			}
		}

		// Server side checking if organization is available before and does not belong to this user.
		if ($formContainStarupModel) {
			if (!HubForm::canUserChooseThisOrgization(HUB::getSessionUsername(), $orgTitleSubmittedByUser)) {
				$error = Yii::t('f7', 'The company/startup name you entered has been taken.');
				$form->addError($error, $error);

				return $this->render('index', array('form' => $form, 'htmlForm' => $htmlForm, 'slug' => $slug, 'sid' => $submission->id));
			}
		}

		$jsonData = json_encode($data);
		$jsonData = $this->storeFormAttachments($form->code, $jsonData);

		$code = empty($submission->code) ? ysUtil::generateUUID() : $submission->code;
		$status = strtolower($_POST['save']) === strtolower('submit') ? 'submit' : 'draft';

		if (empty($submission)) {
			$submission = new FormSubmission();
		}
		$submission->code = $code;
		$submission->form_code = $form->code;
		$submission->user_id = Yii::app()->user->id;
		$submission->jsonArray_data = json_decode($jsonData);
		$submission->status = $status;
		if (empty($submission->stage)) {
			$submission->stage = $stage;
		}
		$submission->date_submitted = time();
		$submission->date_added = empty($submission->date_added) ? time() : $submission->date_added;
		$submission->date_modified = time();

		if ($submission->save(false)) {
			$url = $this->createUrl('/f7/publish/view/', array('slug' => $slug, 'sid' => $submission->id));

			if ($submission->status == 'submit') {
				if ($form->hasHook('onNotifyAfterSubmitForm') != false) {
					$form->execHook('onNotifyAfterSubmitForm', array('submission' => $submission));
				} else {
					$notifMaker = HubForm::notifyMaker_user_afterSubmitForm($submission);
					HUB::sendNotify('member', $submission->user->username, $notifMaker['message'], $notifMaker['title'], $notifMaker['content'], 3);
				}
				Notice::Page(Yii::t('f7', 'You have successfully submitted your entry.'), Notice_SUCCESS, array('url' => $url));
			} else {
				if ($form->hasHook('onNotifyAfterSubmitDraft') != false) {
					$form->execHook('onNotifyAfterSubmitDraft', array('submission' => $submission));
				} else {
					$notifMaker = HubForm::notifyMaker_user_afterSubmitDraft($submission);
					HUB::sendNotify('member', $submission->user->username, $notifMaker['message'], $notifMaker['title'], $notifMaker['content'], 3);
				}
				Notice::flash(Yii::t('f7', 'You have successfully saved your entry as draft.'), Notice_SUCCESS);
				$this->redirect(array('/f7/publish/edit', 'slug' => $slug, 'sid' => $submission->id));
			}
		} else {
			throw new Exception(Yii::t('f7', 'Opps, something wrong, we failed to update your application due'));
		}
	}

	// sid: submission id
	public function actionView($slug, $sid)
	{
		list($form, $htmlForm, $submission) = $this->performViewOrEditTasks(false, $slug, $sid);

		$this->layout = '/layouts/publish';

		$this->render('view', array('form' => $form, 'htmlForm' => $htmlForm, 'submission' => $submission));
	}

	// sid: submission id
	public function actionEdit($slug, $sid)
	{
		set_time_limit(0);

		list($form, $htmlForm, $submission) = $this->performViewOrEditTasks(true, $slug, $sid);
		// get user confirmation to revert back to draft to edit
		if ($submission->status == 'submit') {
			$this->redirect(array('revert', 'slug' => $slug, 'sid' => $sid));
		}

		$this->layout = '/layouts/publish';

		$this->render('edit', array('form' => $form, 'htmlForm' => $htmlForm, 'submission' => $submission));
	}

	// ask user to ensure action to revert submitted application
	public function actionRevert($slug, $sid)
	{
		$form = Form::slug2obj($slug);
		if (empty($form)) {
			throw new Exception('Form not exists');
		}
		if ($form->isApplicationClosed()) {
			return $this->render('index', array('form' => $form, 'htmlForm' => $form->getEmptyForm()));
		}

		$submission = FormSubmission::model()->findByAttributes(array('form_code' => $form->code, 'id' => $sid));
		// nothing to revert, send to view page
		if ($submission->status == 'draft') {
			$this->redirect(array('view', 'slug' => $slug, 'sid' => $sid));
		}

		$url = Yii::app()->createAbsoluteUrl('/f7/publish/revertConfirmed', array('slug' => $slug, 'sid' => $sid));
		$urlCancel = Yii::app()->createAbsoluteUrl('/f7/publish/view', array('slug' => $slug, 'sid' => $sid));
		$htmlMessage = 'Editing this form will change its status to <b><span class="text-danger">Draft</span></b> even if you don\'t change any existing data.<br />Are you sure you want to continue?';

		if ($submission->status === 'draft') {
			$this->redirect($url);
		} else {
			Notice::page($htmlMessage, Notice_WARNING, array('url' => $url, 'urlLabel' => Yii::t('f7', 'Continue Editing'), 'cancelLabel' => Yii::t('f7', 'No'), 'cancelUrl' => $urlCancel));
		};
	}

	// confrim revert submission back to 'draft'
	public function actionRevertConfirmed($slug, $sid)
	{
		$form = Form::slug2obj($slug);
		if (empty($form)) {
			throw new Exception('Form not exists');
		}

		// if application has closed
		if ($form->isApplicationClosed()) {
			$this->redirect(array('index', 'slug' => $slug, 'sid' => $sid));
		}

		$submission = FormSubmission::model()->findByAttributes(array('form_code' => $form->code, 'id' => $sid));
		if ($submission->status == 'draft') {
			throw new Exception(Yii::t('f7', 'Failed to revert a submission which is already in draft status'));
		}
		$submission->status = 'draft';
		$submission->stage = $submission->form->jsonArray_stage[0]->key;
		;
		$submission->date_submitted = null;
		if ($submission->save()) {
			// notify user
			if ($form->hasHook('onNotifyAfterChangedSubmit2Draft') != false) {
				$form->execHook('onNotifyAfterChangedSubmit2Draft', array('submission' => $submission));
			} else {
				$notifMaker = HubForm::notifyMaker_user_afterChangedSubmit2Draft($submission);
				HUB::sendNotify('member', $submission->user->username, $notifMaker['message'], $notifMaker['title'], $notifMaker['content'], 3);
			}

			$this->redirect(array('/f7/publish/edit', 'slug' => $submission->form->slug, 'sid' => $submission->id));
		} else {
			print_r($submission->getErrors());
			exit;
			throw new Exception(Yii::t('f7', 'Failed to rever submission back to draft mode due to unknown error'));
		}
	}

	public function actionDownload($filename)
	{
		$downloadFile = rawurlencode($filename);
		$downloadLink = Yii::app()->params['s3Url'] . '/' . "uploads/forms/$downloadFile";

		if (HubForm::isUrlExists($downloadLink) === false) {
			throw new Exception('The requested file does not exist.');
		}
		$contentType = '';

		$ext = strtolower(pathinfo($downloadFile, PATHINFO_EXTENSION));

		if ($ext === 'pdf') {
			$contentType = 'application/pdf';
		} elseif ($ext === 'jpeg' || $ext === 'jpg' || $ext === 'png' || $ext === 'bmp' || $ext === 'gif' || $ext === 'doc' || $ext === 'zip' || $ext === 'xls' || $ext === 'xlsx') {
			$contentType = mime_content_type($downloadFile);
		} else {
			throw new Exception('File type is not supported');
		}

		header('Content-Description: File Transfer');
		header('Content-Type: ' . $contentType);
		header('Content-Disposition: inline; filename="' . $downloadFile . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		// UPDATE 23/11/2020 This code solves the corrupt zip and excel files issue
		while (ob_get_level()) {
			ob_end_clean();
		}

		// flush(); // Flush system output buffer
		readfile($downloadLink);
		ob_start();

		Yii::app()->end();
	}

	protected function verifyAccess()
	{
		try {
			$slug = Yii::app()->request->getQuery('slug');

			if (empty($slug)) {
				return false;
			}

			$form = Form::slug2obj($slug);

			if (is_null($form)) {
				return false;
			}

			if ($form->is_login_required) {
				return Yii::app()->user->isGuest ? false : true;
			}

			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	protected function performViewOrEditTasks($isEnabled, $slug, $sid)
	{
		if (Yii::app()->params['enableProfileLog']) {
			Yii::beginProfile('PublishController::performViewOrEditTasks');
		}

		if (empty($slug)) {
			throw new Exception('Incorrect Request');
		}
		if (empty($sid)) {
			$this->redirect("/f7/publish/index/$slug");
		}

		$form = Form::slug2obj($slug);
		if (empty($form)) {
			throw new Exception('Form not found');
		}

		$this->pageTitle = Yii::t('app', $form->title);

		if (!HubForm::canSubmit($form, $sid)) {
			$closingTimeFormated = Html::formatDateTimezone($form->date_close, 'standard', 'standard', '-', $form->timezone);
			$closingDate = empty($form->date_close) ? 'closing date' : $closingTimeFormated;

			$error = Yii::t('f7', 'Please note that multiple submissions is not allowed for this form. However, You can edit existing Submission(s) before {closingDate}.', array('{closingDate}' => $closingDate));

			$form->addError($error, $error);

			return $this->render('index', array('form' => $form, 'htmlForm' => $form->getEmptyForm()));
		}

		$submission = FormSubmission::model()->findByAttributes(array('form_code' => $form->code, 'id' => $sid, 'user_id' => Yii::app()->user->id));
		//Ensure this submission belongs to this user
		if (empty($submission)) {
			$this->redirect("/f7/publish/index/$slug");
		}

		$htmlForm = HubForm::convertJsonToHtml($isEnabled, $form->json_structure, $submission->json_data, $form->slug, $sid);

		$uploadControls = HubForm::getListOfExistingUploadControlsWithValue($submission->json_data);
		// ys: using session here can be dangerous as user might open multiple tab
		$session = Yii::app()->session;
		foreach ($uploadControls as $uploadControl => $value) {
			$awsPath = $uploadControl . '.aws_path';
			$session['uploadfiles'] = array($awsPath => $value);
		}

		if (Yii::app()->params['enableProfileLog']) {
			Yii::endProfile('PublishController::performViewOrEditTasks');
		}

		return array($form, $htmlForm, $submission);
	}

	protected function performValidation($model, $postedData, $slug, $formData, $sid)
	{
		$isEnabled = true;

		list($status, $errors) = HubForm::validateForm($model->json_structure, $postedData, $formData);

		foreach ($errors as $error) {
			$model->addError($error, $error);
		}

		$postInJson = json_encode($postedData, true);

		$htmlForm = HubForm::convertJsonToHtml($isEnabled, $model->json_structure, $postInJson, $model->slug, $sid);

		if (!$status) {
			return array(false, $htmlForm);
		}

		return array(true, $htmlForm);
	}

	protected function storeFormAttachments($formCode, $jsonData)
	{
		$uploadControls = HubForm::getListOfUploadControls($formCode);
		foreach ($uploadControls as $uploadControl) {
			$localFile = '';

			if (!empty($_FILES["$uploadControl"]['name'])) {
				// ys: todo: fuck the hardcode, filesize limit should be taken from the json form structure
				if ($_FILES["$uploadControl"]['size'] > 10485760) { // Max file size to upload 10MB
					throw new Exception(Yii::t('f7', 'Size of the file you are trying to upload is more than the allowed size of 10MB.'));
				}
				$extension = end(explode('.', $_FILES["$uploadControl"]['name']));

				$mimeType = $_FILES["$uploadControl"]['type'];

				$localFile = Yii::getPathOfAlias('uploads') . '/' . time() . '_' . $_FILES["$uploadControl"]['name'];

				rename($_FILES["$uploadControl"]['tmp_name'], $localFile);

				$pathToFileInCloud = HubForm::storeFile('uploads/' . basename($localFile));

				$jsonData = HubForm::updateJsonForm($jsonData, $uploadControl . '.aws_path', $pathToFileInCloud);
			}
		}

		return $jsonData;
	}

	private function getAgeFromIC($value)
	{
		$year = substr($value, 0, 2);
		$dt = DateTime::createFromFormat('y', $year);
		$year4digits = $dt->format('Y');
		$month = substr($value, 2, 2);
		$day = substr($value, 4, 2);

		$age = (date('md', date('U', mktime(0, 0, 0, $month, $day, $year4digits))) > date('md')
			? ((date('Y') - $year4digits) - 1)
			: (date('Y') - $year4digits));

		return $age;
	}
}
