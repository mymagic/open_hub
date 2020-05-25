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
class BackendController extends Controller
{
	public $layout = 'backend';

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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('dashboard', 'renderDashboardViewTab', 'logout', 'me', 'changePassword', 'updateAccount', 'getQuickInfo', 'getSubjectTags'),
				'users' => array('@'),
				'expression' => '$user->accessBackend==true',
			),
			array('allow', // allow admin user to sync local account to connect
				'actions' => array('connect', 'connectConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isDeveloper==true || $user->isSuperAdmin==true ',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow',
				'actions' => array('index', 'login'),
				'users' => array('*'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionLogin()
	{
		Notice::debugFlash('BackendController.actionAdminLogin()');
		if (!Yii::app()->user->isGuest) {
			Notice::Page(Yii::t('notice', 'Please logout from your account before making a new login'), Notice_INFO, array('url' => $this->createUrl('site/logout'), 'urlLabel' => Yii::t('app', 'Logout Now')));
		}

		// magic connect

		$this->redirect(array('site/login'));

		$model['form'] = new LoginForm();

		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model['form']);
			Yii::app()->end();
		}
		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model['form']->attributes = $_POST['LoginForm'];
			// $model['form']->validate() &&
			// validate user input and redirect to the previous page if valid
			if ($model['form']->login()) {
				// if can access backend
				if (Yii::app()->user->accessBackend) {
					$this->redirect(array('backend/dashboard'));
				}
				// if can access cpanel
				elseif (Yii::app()->user->accessCpanel) {
					$this->redirect(array('cpanel/index'));
				}
				//  others
				else {
					$this->redirect(Yii::app()->user->returnUrl);
				}
			} else {
				// form will automatically display error msg
			}
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	public function actionLogout()
	{
		Notice::debugFlash('BackendController.actionLogout()');
		/*Yii::app()->user->logout();
		Notice::flash(Yii::t('default', 'You have successfully logout from the system!'), Notice_SUCCESS);
		$this->redirect('login');*/
		$this->redirect(array('site/logout'));
	}

	public function actionIndex()
	{
		$this->redirect(array('backend/dashboard'));
	}

	public function actionDashboard()
	{
		$realm = 'backend';

		// check list of module required upgrade
		$countModule2Upgrade = YeeModule::countModuleCanUpgrade();
		if ($countModule2Upgrade > 0) {
			Notice::flash(Yii::t('backend', '<a href="{url}">{n} module needs to upgrade now!</a>|<a href="{url}">{n} modules need to upgrade now!</a>', array($countModule2Upgrade, '{url}' => $this->createUrl('/sys/module/admin'))), Notice_INFO);
		}

		$stat['totalUsers'] = User::model()->countByAttributes(array('is_active' => 1));
		$stat['totalLogins'] = Yii::app()->db->createCommand('SELECT SUM(stat_login_success_count) FROM user WHERE is_active=1')->queryScalar();
		$stat['totalOrganizations'] = Organization::model()->countByAttributes(array('is_active' => 1));
		$stat['totalProducts'] = Product::model()->countByAttributes(array('is_active' => 1));
		//$stat['totalMentorSessions'] = MentorSession::model()->countByAttributes(array('is_test' => 0));
		$stat['totalIndividuals'] = Individual::model()->countByAttributes(array('is_active' => 1));
		$stat['totalEvents'] = Event::model()->countByAttributes(array('is_active' => 1, 'is_cancelled' => 0));
		// todo: select total registration base on active and not cancelled events
		$stat['totalEventRegistrations'] = Yii::app()->db->createCommand('SELECT COUNT(er.id) FROM event_registration as er LEFT JOIN event as e ON er.event_code=e.code WHERE e.is_active=1')->queryScalar();

		$notices = $tabs = array();
		$model = null;
		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getDashboardViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getDashboardViewTabs($model, $realm));
			}
			if (method_exists(Yii::app()->getModule($moduleKey), 'getDashboardNotices')) {
				$notices = array_merge($notices, (array) Yii::app()->getModule($moduleKey)->getDashboardNotices($model, $realm));
			}
		}

		ksort($tabs);

		$this->render('dashboard', array('model' => $model, 'tabs' => $tabs, 'stat' => $stat, 'notices' => $notices));
	}

	public function actionRenderDashboardViewTab($viewPath)
	{
		$model = null;
		$this->renderPartial($viewPath, $model, false, true);
	}

	public function actionMe()
	{
		$profile = Profile::model()->find('t.user_id=:userId', array(':userId' => Yii::app()->user->id));
		if ($profile === null) {
			throw new CHttpException(404, 'The requested user does not exist.');
		}
		$this->render('me', array('model' => $profile));
	}

	public function actionConnectConfirmed()
	{
		//echo 'start';
		//print_r($this->magicConnect->getUserData());
		//echo $this->magicConnect->isLoggedIn();
		//echo (int)$this->magicConnect->isUserExists('exiang83@gmail.com');
		//echo (int)$this->magicConnect->isUserExists('exiang83+88aaaaa@gmail.com');
		//$tmp = $this->magicConnect->createUser('exiang83+'.rand(1,99).'@gmail.com', 'Allen', 'Tan');

		// get all user
		$users = User::model()->findAll();

		// loop thru each
		$countToConnect = 0;
		$countConnected = 0;
		$total = count($users);
		$newPassword = ysUtil::generateRandomPassword();
		foreach ($users as $user) {
			//echo $user->username;
			// find which have connect account and which not
			if (!empty($user->username)) {
				echo $user->username . ' - ' . $user->profile->full_name . '<br>';
				try {
					$c = $this->magicConnect->isUserExists($user->username);
					if ($c != true) {
						++$countToConnect;
						$result = $this->magicConnect->createUser($user->username, $user->first_name, $user->last_name, $newPassword);
						if ($result) {
							++$countConnected;
						}
					}
				} catch (Exception $e) {
				}
			}
		}

		echo $countToConnect . '<br />';
		echo $countConnected . '<br />';
	}

	public function actionConnect()
	{
		// get all user
		$users = User::model()->findAll();

		// loop thru each
		$countConnected = 0;
		$total = count($users);
		foreach ($users as $user) {
			//echo $user->username;
			// find which have connect account and which not
			if (!empty($user->username)) {
				try {
					$c = $this->magicConnect->isUserExists($user->username);
					if ($c == true) {
						++$countConnected;
					}
				} catch (Exception $e) {
				}
			}
		}

		//echo $countConnected; echo " | "; echo $total - $countConnected;exit;
		if ($total - $countConnected < 1) {
			Notice::page(Yii::t('notice', 'You have no user to create MaGIC connect account for.'), Notice_INFO);
		} else {
			Notice::page(
				Yii::t(
					'notice',
					'Out of {total} total users, you have total of {connected} users that registered with MaGIC Connect. Do you like to create MaGIC connect account for the other {notConnected} users?',
					['{total}' => $total, '{connected}' => $countConnected, '{notConnected}' => $total - $countConnected]
				),
				Notice_WARNING,
				array('url' => $this->createUrl('backend/connectConfirmed'), 'cancelUrl' => $this->createUrl('backend/dashboard'))
			);
		}
	}

	public function actionChangePassword()
	{
		if (Yii::app()->user->isGuest) {
			throw new CException(Yii::t('app', 'You must login to update your password.'));
		}

		// magic connect
		if (!empty($this->magicConnect)) {
			$this->redirect($this->magicConnect->getProfileUrl());
		}

		$model = new User('changePassword');

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			if ($model->validate()) {
				$modelToSave = Profile::model()->find('t.user_id=:userId', array(':userId' => Yii::app()->user->id));
				if ($modelToSave === null) {
					throw new CHttpException(404, 'The requested user does not exist.');
				}
				if ($modelToSave->user->matchPassword($model->opassword)) {
					$modelToSave->user->password = $model->cpassword;
					if ($modelToSave->user->save(false)) {
						Notice::flash(Yii::t('notice', 'Your new password is updated successfully.'), Notice_SUCCESS);
						$this->redirect(array('backend/me'));
					}
				} else {
					//throw new CException('Please insert the correct current password.');
					$model->addError('opassword', Yii::t('app', 'Please insert the correct current password'));
				}
			}
		}

		$this->render('changePassword', array(
			'model' => $model,
		));
	}

	public function actionUpdateAccount()
	{
		if (Yii::app()->user->isGuest) {
			throw new CException(Yii::t('app', 'You must login to update your profile'));
		}
		// magic connect
		if (!empty($this->magicConnect)) {
			$this->redirect($this->magicConnect->getProfileUrl());
		}

		$model = Profile::model()->find('t.user_id=:userId', array(':userId' => Yii::app()->user->id));
		if ($model === null) {
			throw new CHttpException(404, 'The requested user does not exist.');
		}
		if (isset($_POST['Profile'])) {
			$model->attributes = $_POST['Profile'];

			//$model->avatar_image_file = CUploadedFile::getInstance($model, 'avatar_image_file');
			if ($model->save() && $model->user->save(false)) {
				/*if(is_object($model->avatar_image_file))
				{
					$image = new Image($model->avatar_image_file->tempName);
					$image->resize(160, 160, Image::NONE);
					$image->save($model->upload_path.DIRECTORY_SEPARATOR .'avatar.'.$model->username.'.jpg');

					$model->avatar_image_url = 'uploads/profile/avatar.' . $model->username . '.jpg';
					$model->save();
				}*/

				Notice::flash(Yii::t('notice', 'Your account is updated successfully.'), Notice_SUCCESS);
				$this->redirect(array('backend/me'));
			} else {
				Notice::flash(Yii::t('notice', 'Failed to update account information due to unknwon reason'), Notice_ERROR);
			}
		}

		$this->render('updateAccount', array(
			'model' => $model,
		));
	}

	public function actionGetSubjectTags()
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
