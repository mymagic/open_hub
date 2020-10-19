<?php
/**
* NOTICE OF LICENSE.
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
*
* @see https://github.com/mymagic/open_hub
*
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/
class CpanelController extends Controller
{
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
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array(
					'index', 'services', 'setUserService', 'setting', 'download', 'requestDownloadUserData', 'downloadUserDataFile', 'deleteUserAccount',
					'terminateAccount', 'terminateConfirmed',
					'notification', 'toggleSubscriptionStatus', 'getSubscriptionStatus',
					'test', 'activity', 'getTimeline', 'profile', 'organization',
					'changePassword',
					'manageEmails', 'addEmail', 'getUser2Emails', 'deleteUser2Email', 'resendLinkEmailVerification'
				),
				'users' => array('@'),
				'expression' => '$user->accessCpanel===true',
			),
			array('allow', 'actions' => array('verifyUser2Email', 'cancelUser2Email')),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		parent::init();
		$this->layout = 'layouts.cpanel';
		$this->pageTitle = Yii::t('cpanel', 'Activity Feed');
		$this->cpanelMenuInterface = 'cpanelNavDashboard';
		$this->activeMenuCpanel = 'activity';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->layoutParams['containerFluid'] = false;
		$this->layoutParams['enableGlobalSearchBox'] = true;
	}

	public function actionOrganization()
	{
		$this->redirect(array('organization/list', 'realm' => 'cpanel'));
	}

	public function actionIndex()
	{
		$this->redirect(['cpanel/services']);
	}

	public function actionServices()
	{
		$this->redirect(array('activity'));
	}

	public function actionChangePassword()
	{
		if (Yii::app()->user->isGuest) {
			throw new CException(Yii::t('app', 'You must login to update your password.'));
		}

		if (Yii::app()->params['authAdapter'] != 'local') {
			throw new CException(Yii::t('app', 'You not allowed to update your password.'));
		}

		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Change Password');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'changePassword';

		$model = User::model()->findByAttributes(['username' => Yii::app()->user->username]);
		$model->scenario = 'changePassword';

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];

			$model->validate();

			if (!empty($model->opassword) && !$model->matchPassword($model->opassword)) {
				$model->addError('opassword', Yii::t('app', 'Please insert the correct current password'));
			}

			if (empty($model->getErrors())) {
				$model->password = $model->npassword;

				if ($model->save(false)) {
					Yii::app()->esLog->log(sprintf("password changed for username: '%s'", $model->username), 'user', array('trigger' => 'CpanelController::actionChangePassword', 'model' => 'User', 'action' => 'changePassword', 'id' => $model->id, 'userId' => $model->id));

					$this->redirect('profile');
				}
			}
		}

		$this->render('changePassword', array(
			'model' => $model
		));
	}

	public function actionProfile()
	{
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Profile Settings');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'profile';

		$model = User::model()->findByAttributes(['username' => Yii::app()->user->username]);

		$modelIndividual = Individual::getIndividualByEmail(Yii::app()->user->username);
		if ($modelIndividual === null) {
			if (Yii::app()->params['authAdapter'] == 'connect') {
				$account = $this->magicConnect->getUser($_COOKIE['x-token-access'], $_COOKIE['x-token-refresh'], Yii::app()->params['connectClientId'], Yii::app()->params['connectSecretKey']);
				$fullname = $account->firstname . ' ' . $account->lastname;
			} else {
				// if using local authAdapter, check for social login first
				$userSocial = UserSocial::model()->findByAttributes(['username' => Yii::app()->user->username]);
				if ($userSocial !== null) {
					$account = $userSocial->jsonArray_socialParams;
					$fullname = $account->firstName . ' ' . $account->lastName;
				}
			}

			$gender = null;

			if (!empty($account)) {
				if ($account->gender === 'M') {
					$gender = 'male';
				} elseif ($account->gender === 'F') {
					$gender = 'female';
				}
			}

			if (!isset($fullname)) {
				$fullname = $model->profile->full_name;
			}

			$modelIndividual = new Individual();
			$modelIndividual->full_name = $fullname;
			$modelIndividual->image_photo = Individual::getDefaultImagePhoto();
			$modelIndividual->gender = $gender;
			$modelIndividual->country_code = ($account->country) ? $account->country : null;
			$modelIndividual->save();
		}
		if (!$modelIndividual->hasUserEmail(Yii::app()->user->username)) {
			$i2o = new Individual2Email();
			$i2o->individual_id = $modelIndividual->id;
			$i2o->user_email = Yii::app()->user->username;
			$i2o->is_verify = 1;
			$i2o->save();
		}

		if (isset($_POST['Profile'])) {
			$model->profile->attributes = $_POST['Profile'];

			$modelIndividual->inputPersonas = empty($_POST['Individual']['inputPersonas']) ? null : $_POST['Individual']['inputPersonas'];

			$modelIndividual->full_name = $model->profile->full_name;
			if (!empty($model->profile->gender)) {
				$modelIndividual->gender = $model->profile->gender;
			}
			if (!empty($model->profile->country_code)) {
				$modelIndividual->country_code = $model->profile->country_code;
			}

			$model->profile->imageFile_avatar = UploadedFile::getInstance($model->profile, 'imageFile_avatar');
			$modelIndividual->imageFile_photo = $model->profile->imageFile_avatar;

			if ($model->profile->save()) {
				UploadManager::storeImage($model->profile, 'avatar', $model->profile->tableName(), '', $model->profile->user_id);

				if ($modelIndividual->save()) {
					UploadManager::storeImage($modelIndividual, 'photo', $modelIndividual->tableName());
				}

				Yii::app()->esLog->log(sprintf("updated profile '%s'", $model->profile->full_name), 'profile', array('trigger' => 'CpanelController::actionProfile', 'model' => 'Profile', 'action' => 'profile', 'id' => $model->profile->user_id, 'userId' => $model->profile->user_id));
			}
		}

		$this->render('profile', array(
			'model' => $model,
			'modelIndividual' => $modelIndividual
		));
	}

	public function actionManageEmails()
	{
		if (Yii::app()->user->isGuest) {
			throw new CException(Yii::t('app', 'You must login first.'));
		}

		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Other emails');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'email';

		$user = User::model()->findByAttributes(['username' => Yii::app()->user->username]);

		$this->render('manageEmails', array(
			'model' => $user
		));
	}

	public function actionGetUser2Emails($userId, $User2Emails_page = 0, $realm = 'backend')
	{
		$model['realm'] = $realm;
		$model['list'] = HubMember::getUser2Emails($userId, $User2Emails_page);

		Yii::app()->clientScript->scriptMap = array('jquery.min.js' => false);
		$this->renderPartial('_getUser2Emails', $model, false, true);
	}

	public function actionDeleteUser2Email($id, $realm = 'cpanel')
	{
		$model = HubMember::getUser2Email($id);

		if ($model->user->username != Yii::app()->user->username) {
			Notice::page(Yii::t('notice', 'Invalid Access'));
		}

		$user = $model->user;
		$copy = clone $model;
		if ($model->delete()) {
			// todo: esLog

			// todo
			// notify the email about his access to this individual
			//$notifMaker = NotifyMaker::user_hub_revokeEmailAccess($copy);
			//HUB::sendEmail($copy->user_email, $copy->user_email, $notifMaker['title'], $notifMaker['content']);
		}

		Notice::flash(Yii::t('notice', "Successfully unlinked email '{email}' from user '{username}'", ['{email}' => $copy->user_email, '{username}' => $copy->user->username]), Notice_SUCCESS);

		$this->redirect(array('cpanel/manageEmails'));
	}

	// todo
	public function actionResendLinkEmailVerification($email)
	{
		if (YsUtil::isEmailAddress($email)) {
			$user = User::model()->findByAttributes(['username' => Yii::app()->user->username]);

			$model = User2Email::model()->findByAttributes(array('user_email' => $email));

			if (!empty($model)) {
				// todo: esLog

				// send verification email
				$notifyMaker = NotifyMaker::member_user_linkUserEmail($user, $model);
				HUB::sendEmail($user->username, $user->profile->full_name, $notifyMaker['title'], $notifyMaker['content']);

				Notice::page(Yii::t('cpanel', "Successfully resend verification email to link '{email}' to your user account.", array('{email}' => $email)), Notice_SUCCESS);
			} else {
				Notice::page(Yii::t('cpanel', 'Invalid access'));
			}
		} else {
			Notice::page(Yii::t('cpanel', 'Invalid verification details'));
		}
	}

	//
	public function actionVerifyUser2Email($email, $key)
	{
		if (YsUtil::isEmailAddress($email) && YsUtil::isSha1($key)) {
			$model = User2Email::model()->findByAttributes(array('user_email' => $email, 'verification_key' => $key, 'is_verify' => 0));
			;
			if ($model === null) {
				Notice::page(Yii::t('cpanel', 'Unmatched verification details'));
			}

			$model->is_verify = 1;
			if ($model->save()) {
				// todo: esLog

				Notice::page(Yii::t('cpanel', "Successfully verified and linked email '{email}' to your user account.", array('{email}' => $email)), Notice_SUCCESS);
			}
		} else {
			Notice::page(Yii::t('cpanel', 'Invalid verification details'));
		}
	}

	public function actionCancelUser2Email($email, $key)
	{
		if (YsUtil::isEmailAddress($email) && YsUtil::isSha1($key)) {
			$model = User2Email::model()->findByAttributes(array('user_email' => $email, 'delete_key' => $key));
			if ($model === null) {
				Notice::page(Yii::t('cpanel', 'Unmatched details'));
			}

			$copy = clone $model;
			if ($model->delete()) {
				// todo: esLog
				Notice::page(Yii::t('cpanel', "Successfully unlinked email '{email}' from your user account.", array('{email}' => $email)), Notice_SUCCESS);
			}
		} else {
			Notice::page(Yii::t('cpanel', 'Invalid verification details'));
		}
	}

	public function actionAddEmail()
	{
		$user = User::model()->findByAttributes(['username' => Yii::app()->user->username]);

		$model = new User2Email;

		if (isset($_POST['User2Email'])) {
			$model->attributes = $_POST['User2Email'];
			$model->user_id = $user->id;
			$model->user_email = trim($model->user_email);
			$model->is_verify = 0;
			$model->verification_key = sha1(rand());
			$model->delete_key = sha1(rand());

			// user cannot add same email to the user account
			if ($model->user_email == $user->username) {
				Notice::flash(Yii::t('notice', "You are not allowed to add '{email}' identical to your user account", ['{email}' => $model->user_email]), Notice_ERROR);
			} else {
				if ($model->save()) {
					// send verification email
					$notifyMaker = NotifyMaker::member_user_linkUserEmail($user, $model);
					HUB::sendEmail($user->username, $user->profile->full_name, $notifyMaker['title'], $notifyMaker['content']);

					// todo: esLog

					Notice::flash(Yii::t('notice', "Successfully added email '{email}' to your user account. Please check for email to verify it.", ['{email}' => $model->user_email, '{username}' => $user->username]), Notice_SUCCESS);
				} else {
					Notice::flash(Yii::t('notice', "Failed to add email '{email}' to your user account", ['{email}' => $model->user_email, '{username}' => $model->username]), Notice_ERROR);
				}
			}
		}

		$this->redirect('manageEmails');
	}

	public function actionSetUserService()
	{
		$result_array = array();
		$result_array['status'] = 0;
		if (!empty($_POST)) {
			$user = Yii::app()->user;
			$selected_service_list = HUB::listServiceBookmarkByUser($user);

			$current_service_list = array();
			if (!empty($selected_service_list)) {
				foreach ($selected_service_list as $service) {
					$current_service_list[] = $service->service->slug;
				}
			}

			$service_list = (isset($_POST['selected_service']) && !empty($_POST['selected_service'])) ? $_POST['selected_service'] : '';
			if (!empty($current_service_list)) {
				$merged_service_list = array_merge($current_service_list, $service_list);
				$merged_service_list = implode(',', array_unique($merged_service_list));
			} else {
				$merged_service_list = implode(',', $service_list);
			}

			$user = Yii::app()->user;
			if (!empty($service_list)) {
				$selected_service_list = HUB::setServiceBookmarkByUser($user, $merged_service_list);
				if (count($selected_service_list)) {
					$result_array['status'] = 1;
				} else {
					$result_array['status'] = 0;
					$result_array['message'] = 'There are something issue';
				}
			} else {
				$result_array['status'] = 0;
				$result_array['message'] = Yii::t('app', 'You must insert at least one service to bookmark');
			}
		}
		echo json_encode($result_array);
		exit;
	}

	public function actionActivity()
	{
		$tmps = HUB::listServiceBookmarkable();

		foreach ($tmps as $service) {
			$serviceList[] = array('id' => $service->slug, 'label' => $service->title);
		}

		$user = HUB::getUserByUsername(Yii::app()->user->username);

		if (empty($user)) {
			$this->outputJsonFail('Invalid User');
		}

		$fyear = Yii::app()->request->getQuery('year', date('Y'));
		$year = $fyear;

		$services = Yii::app()->request->getQuery('service', '*');
		$fservices = $services == '*' ? $services : implode(',', $services);

		$user = HUB::getUserByUsername($user->username);
		$tmps = HUB::getUserActFeed($user, $fyear, $fservices);

		$result = [];
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				//group by date
				$date = date('d F Y, l', strtotime($tmp['date']));
				$time = date('h:ia', strtotime($tmp['date']));
				$result[$date][$time][] = $tmp;
			}
		}

		$this->render('activity', array('model' => $result, 'serviceList' => $serviceList, 'years' => $year, 'services' => $services));
	}

	public function actionGetTimeline()
	{
		$user = HUB::getUserByUsername(Yii::app()->user->username);

		if (empty($user)) {
			$this->outputJsonFail('Invalid User');
		}

		$fyear = Yii::app()->request->getQuery('year', date('Y'));

		$services = Yii::app()->request->getQuery('service', '*');
		$fservices = $services == '*' ? $services : implode(',', $services);

		$user = HUB::getUserByUsername($user->username);
		$tmps = HUB::getUserActFeed($user, $fyear, $fservices);

		$result = [];
		if (!empty($tmps)) {
			foreach ($tmps as $tmp) {
				//group by date
				$date = date('d F Y, l', strtotime($tmp['date']));
				$time = date('h:ia', strtotime($tmp['date']));
				$result[$date][$time][] = $tmp;
			}
		}

		echo CJSON::encode($result);
	}

	public function actionSetting()
	{
		$this->redirect(['/cpanel/manageUserEmailSubscription']);
	}

	public function actionDownload()
	{
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Download Account Information');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'download';

		$user = Yii::app()->user;
		$availableFiles = HUB::listUserDataDownload($user);
		$pendingOrProcessingRequests = HUB::getUserGeneratingDataDownloadRequest($user);
		$isGeneratingFile = count($pendingOrProcessingRequests) > 0 ? true : false;

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('download', array('availableFiles' => $availableFiles, 'isGeneratingFile' => $isGeneratingFile));
	}

	public function actionDownloadUserDataFile($id)
	{
		$user = Yii::app()->user;
		$request = Request::model()->findByPk($id);
		//print_r($request);
		if ($request->status != 'success' || empty($request->jsonArray_data->generationResult->data->url) || $request->user_id != $user->id) {
			Notice::page(Yii::t('notice', 'Invalid Access'));
		}

		$this->mixPanelTrack('user.download', array('format' => $request->jsonArray_data->format, 'username' => $request->user->username, 'requestId' => $request->id, 'fileUrl' => $request->jsonArray_data->generationResult->data->url));
		$this->piwikTrack('user', 'download', array('format' => $request->jsonArray_data->format, 'username' => $request->user->username, 'requestId' => $request->id, 'fileUrl' => $request->jsonArray_data->generationResult->data->url));

		$this->redirect($request->jsonArray_data->generationResult->data->url);
	}

	public function actionRequestDownloadUserData($format = 'html')
	{
		$user = Yii::app()->user;
		$pendingOrProcessingRequests = HUB::getUserGeneratingDataDownloadRequest($user);
		$isGeneratingFile = count($pendingOrProcessingRequests) > 0 ? true : false;

		if ($isGeneratingFile) {
			Notice::page(Yii::t('notice', 'Invalid Access'));
		}
		$request = HUB::requestUserDataDownload($user, $format);

		$this->redirect(['/cpanel/download']);
	}

	public function actionDeleteUserAccount()
	{
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Terminate Account');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'profile';
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('deleteUserAccount');
	}

	public function actionTerminateAccount()
	{
		$this->layout = 'layouts.plain';
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Terminate Account');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'profile';

		//No passing id from the call for security reasons.
		$id = Yii::app()->user->id;

		if (is_null($id)) {
			$this->redirect(array('cpanel/deleteUserAccount'));
		}

		$userObj = User::userId2obj($id);

		if (is_null($userObj)) {
			$this->redirect(array('cpanel/deleteUserAccount'));
		}

		$email = $userObj->username;

		if ($userObj->is_active == 1) {
			$this->render('confirmAccountDeletion', array('model' => $userObj));
			// Notice::page(Yii::t('notice', "Are you sure?
			// Once you confirm, your account ({$email}) will be permanently deactivated and you no longer can use this account."), Notice_WARNING,
			// array('url'=>$this->createUrl('terminateConfirmed'), 'cancelUrl'=>$this->createUrl('deleteUserAccount')));
		} else {
			$this->redirect(array('cpanel/deleteUserAccount'));
		}
	}

	public function actionTerminateConfirmed()
	{
		$id = Yii::app()->user->id;

		if (is_null($id)) {
			$this->redirect(array('cpanel/deleteUserAccount'));
		}

		$userObj = User::userId2obj($id);

		if (is_null($userObj)) {
			$this->redirect(array('cpanel/deleteUserAccount'));
		}

		$userObj->is_active = 0;

		$logBackend = Yii::t('app', "{date} '{username}' - Deactivated by the Account Owner", array('{username}' => Yii::app()->user->username, '{date}' => Html::formatDateTime(time(), 'medium', 'long')), null, Yii::app()->sourceLanguage);

		$member = $userObj->member;

		$member->log_admin_remark = $logBackend . "\n" . $member->log_admin_remark;

		$email = $userObj->username;

		if ($userObj->save(false) && $member->save(false) && $userObj->setStatusToTerminateInConnect()) {
			//Add the request to Request table
			$request = Request::model()->findByAttributes(array('status' => 'pending', 'type_code' => 'removeUserAccount', 'user_id' => $id));
			if (empty($r)) {
				$request = new Request();
				$request->user_id = $id;
				$request->type_code = 'removeUserAccount';
				$request->title = 'Request to remove account by user';
				$request->status = 'pending';
				$request->save();
			}
			//Add the request to download user data
			HUB::requestUserDataDownload($userObj);

			//Email user that their account is terminated
			// $params['email'] = $email;
			// $params['accountHolderName'] = $userObj->profile->full_name;

			// $receivers[] = array('email'=>$userObj->username, 'name'=>$userObj->profile->full_name);
			// 		$result = ysUtil::sendTemplateMail($receivers, Yii::t('default', 'Your account has been terminated.'), $params, '_terminateAccount');

			$notifyMaker = NotifyMaker::member_user_accountTerminationDone();

			HUB::sendEmail($email, $userObj->profile->full_name, $notifyMaker['title'], $notifyMaker['content']);

			//Try to unsubscribe user from all newsletters
			try {
				$newsletters = HubMailchimp::getAllMailchimpList(100);
				if (!empty($newsletters)) {
					foreach ($newsletters as &$newsletter) {
						$result = HubMailchimp::unsubscribeMailchimpList($email, $newsletter['id']);
					}
				}
			} catch (Exception $e) {
			}

			Notice::flash(Yii::t('notice', "User $email is successfully deactivated."), Notice_SUCCESS);

			Yii::app()->user->logout();

			// todo: detach MaGIC Connect
			$url = sprintf('%s/logoutRedirectUrl/?url=%s', Yii::app()->params['connectUrl'], Yii::app()->params['baseUrl'] . '/site/TerminateAccount');

			$this->redirect($url);
		} else {
			Notice::flash(Yii::t('notice', 'Failed to terminate user {username} due to unknown reason.', ['{username}' => $userObj->username]), Notice_ERROR);

			$this->redirect(array('cpanel/deleteUserAccount'));
		}
	}

	public function actionNotification()
	{
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = Yii::t('cpanel', 'Notification Settings');
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'notification';

		if (Yii::app()->params['mailchimpApiKey'] && Yii::app()->params['mailchimpLists']['masterNewsletter']) {
			$masterNewsletter = HubMailchimp::getOneMailchimpList(Yii::app()->params['mailchimpLists']['masterNewsletter']);
			$tmps = HubMailchimp::getAllMailchimpList(100);
			foreach ($tmps as &$tmp) {
				if ($tmp['id'] == $masterNewsletter['id']) {
					unset($tmp);
				}

				if ($tmp['visibility'] == 'pub') {
					$publicNewsletters[] = $tmp;
				} elseif ($tmp['visibility'] == 'prv') {
					if (HubMailchimp::isEmailExistsMailchimpList(Yii::app()->user->username, $tmp['id'])) {
						$privateNewsletters[] = $tmp;
					}
				}
			}
		}

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('notification', array('masterNewsletter' => $masterNewsletter, 'publicNewsletters' => $publicNewsletters, 'privateNewsletters' => $privateNewsletters));
	}

	public function actionGetSubscriptionStatus($listId)
	{
		$email = Yii::app()->user->username;
		if (!empty($email)) {
			$isSubscribed = HubMailchimp::isEmailSubscribeMailchimpList($email, $listId);
			$this->renderJson(array('status' => 'success', 'data' => array('isSubscribed' => $isSubscribed)));
		} else {
			$this->renderJson(array('status' => 'fail', 'msg' => 'Invalid Email Address'));
		}
	}

	public function actionToggleSubscriptionStatus($listId)
	{
		$email = Yii::app()->user->username;
		if (!empty($email)) {
			$firstname = !empty($this->user->profile->figureFirstName()) ? $this->user->profile->figureFirstName() : 'No name';
			$lastname = !empty($this->user->profile->figureLastName()) ? $this->user->profile->figureLastName() : 'User';

			$result = HubMailchimp::toggleSubscribeMailchimpList($email, $listId, array('firstname' => $firstname, 'lastname' => $lastname));

			// is an error string
			if (!is_array($result)) {
				$this->renderJson(array('status' => 'fail', 'msg' => $result));
			} else {
				$isSubscribed = $result['status'] == 'subscribed' ? true : false;

				$this->renderJson(array('status' => 'success', 'data' => array('isSubscribed' => $isSubscribed, 'result' => $result, 'list' => HubMailchimp::getOneMailchimpList($listId))));
			}
		} else {
			$this->renderJson(array('status' => 'fail', 'msg' => 'Invalid Email Address'));
		}
	}
}
