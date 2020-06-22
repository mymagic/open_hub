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
				'actions' => array('save', 'view', 'edit', 'confirm'),
				'expression' => 'Yii::app()->controller->verfiyAccess()',
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('list', 'create', 'update', 'admin', 'delete', 'download'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	protected function verfiyAccess()
	{
		try {
			$slug = $_GET['slug'];

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

	public function init()
	{
		parent::init();
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
	}

	public function actionIndex($slug, $eid = '', $sid = '')
	{
		if (empty($slug)) {
			throw new Exception('Request is not correct');
		}
		$model = Form::slug2obj($slug);

		$this->pageTitle = Yii::t('app', $model->title);

		if (is_null($model)) {
			throw new Exception('Request is not correct');
		}
		if ($model->type == 1) {
			$this->layout = 'publish-survey';
		} else {
			$this->layout = 'publish-default';
		}

		// Check if closing time of the application has reached
		if ($model->isApplicationClosed()) {
			return $this->render('index', array('model' => $model, 'form' => $model->getEmptyForm()));
		}

		$closingTimeFormated = Html::formatDateTimezone($model->date_close, 'standard', 'standard', '-', $model->timezone);

		$closingDate = empty($model->date_close) ? 'closing date' : $closingTimeFormated;

		if (!HubForm::canSubmit($model, $sid)) {
			$error = Yii::t('f7', 'Please note that multiple submissions is not allowed for this form. However, You can edit existing Submission(s) before {closingDate}.', array('{closingDate}' => $closingDate));

			$model->addError($error, $error);

			return $this->render('index', array('model' => $model, 'form' => $model->getEmptyForm()));
		}

		$userId = Yii::app()->user->id;

		$data = FormSubmission::model()->findByAttributes(array('form_code' => $model->code, 'id' => $sid, 'user_id' => $userId));

		$isEnabled = true;

		$form = HubForm::convertJsonToHtml($isEnabled, $model->json_structure, $data->json_data, $model->slug, $sid, $eid);

		//Ensure this submission belongs to this user
		if (!empty($sid) && empty($data)) {
			return $this->redirect("/f7/publish/index/$slug");
		}

		$uploadControls = HubForm::getListOfExistingUploadControlsWithValue($data->json_data);

		// ys: using session here can be dangerous as user might open multiple tab
		$session = Yii::app()->session;

		foreach ($uploadControls as $uploadControl => $value) {
			$awsPath = $uploadControl . '.aws_path';
			$session['uploadfiles'] = array($awsPath => $value);
		}

		if (!empty($model->intakes) && !empty($model->intakes[0]) && !empty($model->intakes[0]->brandCode)) {
			$this->layoutParams['brand'] = $model->intakes[0]->brandCode;
		}

		$this->render('index', array('model' => $model, 'form' => $form));
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

	public function actionSave($slug, $sid = '', $eid = '')
	{
		$submissionDate = '';
		$model = Form::slug2obj($slug);

		if (is_null($model)) {
			throw new Exception(Yii::t('f7', 'The request is not in proper format.'));
		}
		if ($model->type == 1) {
			$this->layout = '/layouts/publish-survey';
		} else {
			$this->layout = '/layouts/publish-default';
		}

		// Check if closing time of the application has reached
		if ($model->isApplicationClosed()) {
			return $this->render('index', array('model' => $model, 'form' => $model->getEmptyForm()));
		}

		$formCode = $model->code;

		if ($model->hasStage()) {
			$stage = $model->jsonArray_stage[0]->key;
		}

		if (!HubForm::canSubmit($model, $sid)) {
			$error = Yii::t('f7', 'Please note that multiple submissions is not allowed for this form.');
			$model->addError($error, $error);

			return $this->render('index', array('model' => $model, 'form' => $model->getEmptyForm()));
		}

		$userId = Yii::app()->user->id;

		$formData = FormSubmission::model()->findByAttributes(array('form_code' => $model->code, 'id' => $sid, 'user_id' => $userId));

		//Ensure this submission belongs to this user
		if (!empty($sid) && empty($formData)) {
			return $this->redirect("/f7/publish/index/$slug/$eid");
		}

		$message = Yii::t('f7', 'You have successfuly saved your application as draft.');

		$form = '';
		if (strtolower($_POST['save']) === 'submit') {
			$submissionDate = time();

			//Validate input data
			list($res, $form) = self::performValidation($model, $_POST, $slug, $formData, $sid, $eid);
			if (!$res) {
				return $this->render('index', array('model' => $model, 'form' => $form, 'slug' => $slug, 'sid' => $formData->id, 'eid' => $eid));
			}

			$message = Yii::t('f7', 'You have successfuly submitted your application.');
		} else {
			$form = HubForm::convertJsonToHtml(true, $model->json_structure, $formData->json_data, $model->slug, $sid, $eid);
		}

		$data = array();
		// pre inherite existing upload file data, so that user save existing draft wont wipe of previously uploaded file data
		if (!empty($formData->json_data)) {
			$decodedJsonData = json_decode($formData->json_data);
			foreach ($decodedJsonData as $jVar => $jValue) {
				// upload file field found in existing data
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

			if ($key == 'startup') {
				$formContainStarupModel = true;
				$orgObj = Organization::title2obj($value);
				$data['startup_id'] = empty($orgObj) ? '' : $orgObj->id;
			}

			if (substr($key, 0, 12) === 'fnationality') {
				$country = Country::model()->findByAttributes(array('name' => $value));
				$splitted = explode('fnationality', $key);
				$num = count($splitted) === 2 ? $splitted[1] : '';
				$keyname = sprintf('fnationality%s_code', $num);
				$data[$keyname] = $country->code;
			}

			if (strpos($key, 'icnumber') !== false) {
				$icCounter++;
				$keyname = "calculated_age_$icCounter";
				if (strlen($value) > 0 && ctype_digit(substr($value, 0, 1))) {
					$data[$keyname] = self::getAgeFromIC($value);
				}
			}

			$data[$key] = $value;

			if (strtolower($key) === 'startup') {
				$orgTitleSubmittedByUser = $value;
			}
		}

		//Survey Form
		if ($model->type == 1 && !empty($eid)) {
			$data['EventID'] = $eid;
			$data['inputtext-eventId'] = $eid;
		}

		//Server side checking if organization is available before and does
		//not belong to this user.
		if ($formContainStarupModel) {
			if (!HubForm::canUserChooseThisOrgization(Yii::app()->user->username, $orgTitleSubmittedByUser)) {
				$error = Yii::t('f7', 'The company/startup name you entered has been taken.');
				$model->addError($error, $error);

				return $this->render('index', array('model' => $model, 'form' => $form, 'slug' => $slug, 'sid' => $formData));
			}
		}

		$jsonData = json_encode($data);
		$jsonData = self::storeFormAttachments($formCode, $jsonData);

		$code = empty($formData->code) ? ysUtil::generateUUID() : $formData->code;
		$userId = Yii::app()->user->id;
		$status = strtolower($_POST['save']) === strtolower('submit') ? 'submit' : 'draft';

		if (is_null($formData)) {
			$formData = new FormSubmission();
		}
		$sendEmail = 0;
		if ($formData->status === 'submit' && $status == 'draft') {
			$sendEmail = 1;
		} // send draft email (warning email)
		elseif ($status === 'submit') {
			$sendEmail = 2;
		} // send submit email

		$formData->code = $code;
		$formData->form_code = $formCode;
		$formData->user_id = $userId;
		$formData->jsonArray_data = json_decode($jsonData);
		$formData->status = $status;
		$formData->stage = $stage;
		$formData->date_submitted = $submissionDate;
		$formData->date_added = empty($formData->date_added) ? time() : $formData->date_added;
		$formData->date_modified = time();

		$formData->save(false);

		if ($sendEmail === 2) { //Submission Email
			$profile = Profile::model()->find('t.user_id=:userId', array(':userId' => Yii::app()->user->id));
			$user = User::userId2obj(Yii::app()->user->id);

			$emailContent = self::getEmailContentAfterFormSubmission($model, $formData);

			if (!empty($user)) {
				HUB::sendEmail($user->username, $profile->full_name, 'You have successfuly submitted your form.', $emailContent, array());
			}
		} elseif ($sendEmail === 1) { //Warning Email
			$profile = Profile::model()->find('t.user_id=:userId', array(':userId' => Yii::app()->user->id));
			$user = User::userId2obj(Yii::app()->user->id);
			$emailContent = self::getEmailContentAfterFormChangedToDraftFromSubmit($model, $formData);

			if (!empty($user)) {
				HUB::sendEmail($user->username, $profile->full_name, 'Application status was changed to draft.', $emailContent, array());
			}
		}

		if ($model->type == 1) {
			$url = "/f7/publish/index/$slug/?eid=$eid";
			$message = 'Thank you for your valuable input. You have successfuly submitted the survery.';
		} else {
			$url = "/f7/publish/index/$slug";
		}

		//return $this->render('finish',array('status'=>$status, 'message'=>$message,'url'=>$url));
		if (strtolower($_POST['save']) === 'submit') {
			Notice::Page($message, Notice_SUCCESS, array('url' => $url));
		} else {
			Notice::flash($message, Notice_SUCCESS);

			return $this->redirect("/f7/publish/edit/$slug/$sid");
		}
	}

	protected function getEmailContentAfterFormSubmission($model, $submission)
	{
		$intakeTitle = $model->getIntake()->title;
		$submissionTitle = !empty($intakeTitle) ? $intakeTitle : $model->title;

		$emailBody = $submission->renderSimpleFormattedHtml();

		$html = sprintf("
		Hi,
		<br><br>
		Thank you for submitting your %s for %s.
		<br><br>
		Please find below the contents that have been submitted:
		<br><br>

		%s
		<br><br>
		<small>
		<img src='https://mymagic.my/wp-content/themes/magic2017/assets/art/logo.svg' height='50' width='150'><br>
		

		MALAYSIAN GLOBAL INNOVATION
		<br>
		& CREATIVITY CENTRE 1072152-T
		<br><br>
		Block 3730, Persiaran APEC,
		<br>
		63000, Cyberjaya, Malaysia
		<br><br>
		Website: www.mymagic.my
		<br>
		MaGIC Central: central.mymagic.my
		<br>
		Facebook: facebook.com/magic.cyberjaya
		<br>
		Twitter: @MaGICCyberjaya
		<br>
		Instagram: magic_cyberjaya
		<br>
		LinkedIn: My MaGIC Cyberjaya
		</small>
		", ($model->type == '1') ? 'survey' : 'application', $submissionTitle, $emailBody);

		return $html;
	}

	protected function getEmailContentAfterFormChangedToDraftFromSubmit($model, $submission)
	{
		$closingTimeFormated = Html::formatDateTimezone($model->date_close, 'standard', 'standard', '-', $model->timezone);

		$url = Yii::app()->createAbsoluteUrl('f7/publish/view', array('slug' => $model->slug, 'sid' => $submission->id));

		$html = sprintf("
		Hi,
		<br><br>
		Please note that you just changed your submission status to Draft status. If you want this submission to be considered by MaGIC, You must submit your application before the closing time: %s.
		<br><br>
		You can view your application from the following link:<br><br>
		%s
		<br><br>
		<small>
		<img src='https://mymagic.my/wp-content/themes/magic2017/assets/art/logo.png' height='50' width='150'><br>
		

		MALAYSIAN GLOBAL INNOVATION
		<br>
		& CREATIVITY CENTRE 1072152-T
		<br><br>
		Block 3730, Persiaran APEC,
		<br>
		63000, Cyberjaya, Malaysia
		<br><br>
		Website: www.mymagic.my
		<br>
		MaGIC Central: central.mymagic.my
		<br>
		Facebook: facebook.com/magic.cyberjaya
		<br>
		Twitter: @MaGICCyberjaya
		<br>
		Instagram: magic_cyberjaya
		<br>
		LinkedIn: My MaGIC Cyberjaya
		</small>
		", $closingTimeFormated, $url);

		return $html;
	}

	public function actionView($slug, $sid = '', $eid = '')
	{
		list($model, $form) = self::performViewOrEditTasks(false, $slug, $sid, $eid);

		if ($model->type == 1) {
			$this->layout = '/layouts/publish-survey';
		} else {
			$this->layout = '/layouts/publish-default';
		}

		$this->render('view', array('model' => $model, 'form' => $form));
	}

	protected function isUrlExists($url)
	{
		$headers = get_headers($url, 0);

		return stripos($headers[0], '200 OK') ? true : false;
	}

	public function actionDownload($downloadFile)
	{
		$downloadFile = rawurlencode($downloadFile);

		$downloadLink = Yii::app()->params['s3Url'] . '/' . "uploads/forms/$downloadFile";

		if (self::isUrlExists($downloadLink) === false) {
			throw new Exception('The requested file does not exist.');
		}
		$contentType = '';

		$ext = strtolower(pathinfo($downloadFile, PATHINFO_EXTENSION));

		if ($ext === 'pdf') {
			$contentType = 'application/pdf';
		} elseif ($ext === 'jpeg' || $ext === 'jpg' || $ext === 'png' || $ext === 'bmp' || $ext === 'gif' || $ext === 'doc') {
			$contentType = mime_content_type($downloadFile);
		} else {
			throw new Exception('File type is not supported');
		}
		header('Content-Description: File Transfer');
		header('Content-Type: ' . $contentType);
		header('Content-Disposition: inline; filename="' . $downloadFile . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		flush(); // Flush system output buffer
		readfile($downloadLink);
		Yii::app()->end();

		// Somehow these methods does not work
		//Yii::app()->getRequest()->sendFile( $downloadFile , file_get_contents( $downloadLink ) ,['inline'=>true]);

		//Yii::$app->response->sendFile($downloadFile , file_get_contents( $downloadLink ) ,['inline'=>true]);
		//Yii::$app->response->sendFile($downloadFile, file_get_contents($downloadLink));
	}

	public function actionEdit($slug, $sid = '', $eid = '')
	{
		list($model, $form) = self::performViewOrEditTasks(true, $slug, $sid, $eid);

		if ($model->type == 1) {
			$this->layout = '/layouts/publish-survey';
		} else {
			$this->layout = '/layouts/publish-default';
		}

		$this->render('edit', array('model' => $model, 'form' => $form));
	}

	public function actionConfirm($slug, $sid = '', $eid = '')
	{
		if (empty($slug)) {
			throw new Exception('Request is not correct');
		}
		if (empty($sid)) {
			return $this->redirect("/f7/publish/index/$slug");
		}

		$model = Form::slug2obj($slug);

		if (is_null($model)) {
			throw new Exception('Request is not correct');
		}
		if ($model->isApplicationClosed()) {
			return $this->render('index', array('model' => $model, 'form' => $model->getEmptyForm()));
		}

		$url = Yii::app()->createAbsoluteUrl('f7/publish/edit', array('slug' => $slug, 'sid' => $sid));
		$urlCancel = Yii::app()->createAbsoluteUrl('f7/publish/view', array('slug' => $slug, 'sid' => $sid));

		$htmlMessage = "Editing this form will change its status to <b><span style='Color:red';>Draft</span></b> even if you don't change any existing data.<br />Are you sure you want to continue?";

		$userId = Yii::app()->user->id;

		$data = FormSubmission::model()->findByAttributes(array('form_code' => $model->code, 'id' => $sid, 'user_id' => $userId));

		if ($data->status === 'draft') {
			$this->redirect($url);
		} else {
			Notice::page($htmlMessage, Notice_WARNING, array('url' => $url, 'urlLabel' => Yii::t('f7', 'Continue Editing'), 'cancelLabel' => Yii::t('f7', 'No'), 'cancelUrl' => $urlCancel));
		};
	}

	protected function performViewOrEditTasks($isEnabled, $slug, $sid, $eid)
	{
		if (empty($slug)) {
			throw new Exception('Request is not correct');
		}
		if (empty($sid)) {
			if (empty($eid)) {
				return $this->redirect("/f7/publish/index/$slug");
			} else {
				return $this->redirect("/f7/publish/index/$slug/?eid=$eid");
			}
		}

		$model = Form::slug2obj($slug);

		$this->pageTitle = Yii::t('app', $model->title);

		if (is_null($model)) {
			throw new Exception('Request is not correct');
		}
		if ($model->type == 1) {
			return $this->redirect("/f7/publish/index/$slug/?eid=$eid");
		}

		$closingTimeFormated = Html::formatDateTimezone($model->date_close, 'standard', 'standard', '-', $model->timezone);

		$closingDate = empty($model->date_close) ? 'closing date' : $closingTimeFormated;

		if (!HubForm::canSubmit($model, $sid)) {
			$error = "Please note that multiple submissions is not allowed for this form. However, You can edit existing Submission(s) before $closingDate.";

			$model->addError($error, $error);

			return $this->render('index', array('model' => $model, 'form' => $model->getEmptyForm()));
		}

		$userId = Yii::app()->user->id;

		$data = FormSubmission::model()->findByAttributes(array('form_code' => $model->code, 'id' => $sid, 'user_id' => $userId));

		$form = HubForm::convertJsonToHtml($isEnabled, $model->json_structure, $data->json_data, $model->slug, $sid);

		//Ensure this submission belongs to this user
		if (empty($data)) {
			return $this->redirect("/f7/publish/index/$slug");
		}

		$uploadControls = HubForm::getListOfExistingUploadControlsWithValue($data->json_data);

		// ys: using session here can be dangerous as user might open multiple tab
		$session = Yii::app()->session;

		foreach ($uploadControls as $uploadControl => $value) {
			$awsPath = $uploadControl . '.aws_path';
			$session['uploadfiles'] = array($awsPath => $value);
		}

		return array($model, $form);
	}

	protected function performValidation($model, $postedData, $slug, $formData, $sid, $eid)
	{
		$isEnabled = true;

		list($status, $errors) = HubForm::validateCustomForm($model->json_structure, $postedData, $formData);

		foreach ($errors as $error) {
			$model->addError($error, $error);
		}

		$postInJson = json_encode($postedData, true);

		$form = HubForm::convertJsonToHtml($isEnabled, $model->json_structure, $postInJson, $model->slug, $sid, $eid);

		if (!$status) {
			return array(false, $form);
		}

		return array(true, $form);
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
			}

			if (!empty($_FILES["$uploadControl"])) {
				$pathToFileInCloud = HubForm::storeFile('uploads/' . basename($localFile));

				// updateJsonForm($jsonData, $elementName, $newkey, $newValue)
				$jsonData = HubForm::updateJsonForm($jsonData, $uploadControl . '.aws_path', $pathToFileInCloud);
			}
		}

		return $jsonData;
	}
}
