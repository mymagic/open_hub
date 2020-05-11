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
					'test', 'activity', 'getTimeline', 'profile', 'organization'
				),
				'users' => array('@'),
				'expression' => '$user->accessCpanel===true',
			),
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
		$this->pageTitle = 'Activity Feed';
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

	public function actionProfile()
	{
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = 'Profile Settings';
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'profile';

		$model = Individual::getIndividualByEmail(Yii::app()->user->username);

		if ($model === null) {
			$account = $this->magicConnect->getUser($_COOKIE['x-token-access'], $_COOKIE['x-token-refresh'], Yii::app()->params['connectClientId'], Yii::app()->params['connectSecretKey']);
			$gender = null;
			if ($account->gender === 'M') {
				$gender = 'male';
			} elseif ($account->gender === 'F') {
				$gender = 'female';
			}
			$fullname = $account->firstname . ' ' . $account->lastname;
			$model = new Individual();
			$model->full_name = $fullname;
			$model->image_photo = Individual::getDefaultImagePhoto();
			$model->gender = $gender;
			$model->country_code = ($account->country) ? $account->country : 'null';
			$model->save();
		}
		if (!$model->hasUserEmail(Yii::app()->user->username)) {
			$i2o = new Individual2Email();
			$i2o->individual_id = $model->id;
			$i2o->user_email = Yii::app()->user->username;
			$i2o->is_verify = 1;
			$i2o->save();
		}

		if (isset($_POST['Individual'])) {
			$model->attributes = $_POST['Individual'];

			if (empty($_POST['Individual']['inputPersonas'])) {
				$model->inputPersonas = null;
			}

			$model->imageFile_photo = UploadedFile::getInstance($model, 'imageFile_photo');

			if ($model->save()) {
				UploadManager::storeImage($model, 'photo', $model->tableName());
				Yii::app()->esLog->log(sprintf("updated individual '%s'", $model->full_name), 'individual', array('trigger' => 'IndividualController::actionUpdate', 'model' => 'Individual', 'action' => 'update', 'id' => $model->id, 'individualId' => $model->id));
			}
		}

		$this->render('profile', array(
			'model' => $model,
		));
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
		$this->pageTitle = 'Download Account Information';
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
		$this->pageTitle = 'Deactivate Account';
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'profile';
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('deleteUserAccount');
	}

	public function actionTerminateAccount()
	{
		$this->layoutParams['bodyClass'] = str_replace('gray-bg', 'white-bg', $this->layoutParams['bodyClass']);
		$this->pageTitle = 'Deactivate Account';
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
			$this->render('_confirmAccountDeletion', array('model' => $userObj));
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

			//Try to unsubscribe user from MaGIC newsletter
			try {
				$listId = Yii::app()->params['mailchimpLists']['magicNewsletter'];
				$result = HubMailchimp::unsubscribeMailchimpList($email, $listId);
			} catch (Exception $e) {
			}

			Notice::flash(Yii::t('notice', "User $email is successfully deactivated."), Notice_SUCCESS);

			Yii::app()->user->logout();

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
		$this->pageTitle = 'Notification Settings';
		$this->cpanelMenuInterface = 'cpanelNavSetting';
		$this->activeMenuCpanel = 'notification';

		$lists['magicNewsletter'] = HubMailchimp::getOneMailchimpList(Yii::app()->params['mailchimpLists']['magicNewsletter']);

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('notification', array('lists' => $lists));
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
