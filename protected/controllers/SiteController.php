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

class SiteController extends Controller
{
	public $layout = 'frontend';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		$this->redirect(array('/cpanel'));
	}

	public function actionBooking()
	{
		$this->redirect(array('/mentor'));
	}

	public function actionAbout()
	{
		$this->activeMenuMain = 'about';
		$this->render('about');
	}

	public function actionLocalLogin($returnUrl = '', $email = '')
	{
		Notice::debugFlash('SiteController.actionLogin()');
		if (!Yii::app()->user->isGuest) {
			Notice::Page(Yii::t('app', 'Please logout from your account before making a new login'), Notice_INFO, array('url' => $this->createUrl('site/logout'), 'urlLabel' => Yii::t('app', 'Logout Now')));
		}

		$model['form'] = new LoginForm;
		if (!empty($email)) {
			$model['form']->username = $email;
		}

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
				$redirectUrl = base64_decode($_GET['redirectUrl']);
				if (!empty($redirectUrl)) {
					$this->redirect($redirectUrl);
				}

				// if can access cpanel
				if (Yii::app()->user->accessCpanel && $_POST['LoginForm']['from'] == 'frontend') {
					//$this->redirect(array('cpanel/index'));
					$this->redirect(Yii::app()->user->returnUrl);
				}

				// if can access backend
				elseif (Yii::app()->user->accessBackend) {
					$this->redirect(array('backend/index'));
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
		$this->render('localLogin', array('model' => $model));
	}

	// todo: detach MaGIC Connect
	public function actionConnectLogin($returnUrl = '')
	{
		if (!empty($returnUrl)) {
			Yii::app()->user->returnUrl = $returnUrl;
		}

		$httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https' : 'http';

		$query = http_build_query([
			'client_id' => Yii::app()->params['connectClientId'],
			'redirect_uri' => $this->createAbsoluteUrl('site/connectCallback', array(), $httpOrHttps),
			'response_type' => 'code',
			'scope' => '*',
		]);

		$this->redirect(Yii::app()->params['connectUrl'] . '/oauth/authorize?' . $query);
	}

	// todo: detach MaGIC Connect
	public function actionConnectCallback()
	{
		if (empty($this->magicConnect)) {
			$this->magicConnect = new MyMagic\Connect\Client();
			$this->magicConnect->setConnectUrl('https:' . Yii::app()->params['connectUrl']);
		}

		// if user is guest but have magic cookie
		if (Yii::app()->user->isGuest) {
			$httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https' : 'http';
			$userdata = $this->magicConnect->connect(
				$_GET['code'],
				Yii::app()->params['connectClientId'],
				Yii::app()->params['connectSecretKey'],
				$this->createAbsoluteUrl('site/connectCallback', array(), $httpOrHttps)
			);

			// check to see if user found using email return by magic connect
			$connectEmail = $userdata['email'];
			if (!empty($connectEmail)) {
				$user = User::username2obj($connectEmail);
				if (empty($user)) {
					// todo:
					//echo "user not found, create one in local"; exit;
					//Notice::page('failed to create local user base on connect');
					$result = HUB::createLocalMember($connectEmail, $userdata['firstname'] . ' ' . $userdata['lastname'], 'connect');
					if ($result['status'] == 'success') {
						$user = User::username2obj($connectEmail);
					} else {
						echo 'Failed to create local user base on connect';
						exit;
					}
				}
			} else {
				echo 'Failed to retreive email from connect';
				exit;
			}

			$identity = new UserIdentity($user->username, '');
			$identity->authenticate('sso');
			Yii::app()->user->login($identity, 3600 * 24 * 30);
		}

		if (!Yii::app()->user->isGuest && !empty(Yii::app()->user->id)) {
			$this->user = User::model()->findByPk((int) Yii::app()->user->id);

			// is blocked
			if ($this->user->is_active == 0) {
				Yii::app()->user->logout();
				$this->redirect(Yii::app()->homeUrl);
			}

			UserSession::trackLogin(Yii::app()->user->id, Yii::app()->session->getSessionID());
		}

		// update connect avatar
		if (UrlHelper::isAbsoluteUrl($userdata['avatar'])) {
			$imageAvatar = $userdata['avatar'];
		} else {
			// todo: detach MaGIC Connect
			$imageAvatar = $this->magicConnect->getConnectUrl() . '/' . $userdata['avatar'];
		}

		// if image avatar has been updated, then do not need save the avatar
		preg_match('/uploads\/profile\/avatar.[0-9]+.jpg/', $this->user->profile->image_avatar, $matches);
		if (empty($matches)) {
			$this->user->profile->image_avatar = $imageAvatar;
		}

		if (!empty($this->user)) {
			$this->user->profile->save(false);
		}

		Yii::app()->request->redirect(Yii::app()->user->returnUrl);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = '/layouts/error';

		if ($error = Yii::app()->errorHandler->error) {
			if (isset($error['type']) && $error['type'] == 'NoticeException') {
				$model = unserialize($error['message']);
				switch ($error['errorCode']) {
					case Notice_INFO:

						$this->render('pageNoticeInfo', $model);
						break;

					case Notice_SUCCESS:

						$this->render('pageNoticeSuccess', $model);
						break;

					case Notice_WARNING:

						$this->render('pageNoticeWarning', $model);
						break;

					default:

						$this->render('pageNoticeError', $model);
						break;
				}
			} elseif ($error['code'] == 403) {
				$model['title'] = 'Invalid Access';
				$model['message'] = !empty($error['message']) ? $error['message'] : $error;
				$this->render('pageAccessError', $model);
			} else {
				if (Yii::app()->request->isAjaxRequest) {
					echo $error['message'];
				} else {
					$model['title'] = 'Those do not believe in magic will never find it';
					$model['message'] = !empty($error['message']) ? $error['message'] : $error;
					$this->render('pageNoticeError', $model);
				}
			}
		}
	}

	/**
	 * Displays the contact page.
	 */
	public function actionContact()
	{
		$model['form'] = new ContactForm();
		if (isset($_POST['ContactForm'])) {
			$model['form']->attributes = $_POST['ContactForm'];
			if ($model['form']->validate()) {
				$name = '=?UTF-8?B?' . base64_encode($model['form']->name) . '?=';
				$subject = '=?UTF-8?B?' . base64_encode($model['form']->subject) . '?=';
				$headers = "From: $name <{$model['form']->email}>\r\n" .
					"Reply-To: {$model['form']->email}\r\n" .
					"MIME-Version: 1.0\r\n" .
					'Content-Type: text/plain; charset=UTF-8';

				mail(Yii::app()->params['adminEmail'], $subject, $model['form']->body, $headers);
				Yii::app()->user->setFlash('contact', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'));
				$this->refresh();
			}
		}
		$this->render('contact', array('model' => $model));
	}

	public function actionHello()
	{
		echo 'Hello';
	}

	public function actionAfterLogin()
	{
		if (!Yii::app()->user->isGuest) {
			if (Yii::app()->user->accessCpanel) {
				$this->redirect(array('/cpanel/index'));
			} elseif (Yii::app()->user->accessBackend) {
				$this->redirect(array('/backend/index'));
			} else {
				Notice::page(Yii::t('notice', 'Please logout from your account before making a new login'), Notice_INFO, array('url' => $this->createUrl('site/logout'), 'urlLabel' => Yii::t('app', 'Logout Now')));
			}
		}
	}

	/**
	 * Displays the login page.
	 */
	public function actionLogin($returnUrl = '')
	{
		if (Yii::app()->params['authAdapter'] == 'connect') {
			$this->redirect(array('/site/connectLogin', 'returnUrl' => $returnUrl));
		} else {
			$this->redirect(array('/site/localLogin', 'returnUrl' => $returnUrl));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout($returnUrl = '')
	{
		Notice::debugFlash('SiteController.actionLogout()');
		Yii::app()->user->logout();

		$this->redirect(array('logoutThen', 'returnUrl' => $returnUrl));

		//$this->redirect(Yii::app()->params['baseUrl']);
	}

	// 2 logout requried to clear the session
	// todo: detach MaGIC Connect
	public function actionLogoutThen($returnUrl = '')
	{
		Notice::flash(Yii::t('notice', 'You have successfully logout from the system!'), Notice_SUCCESS);
		if (empty($returnUrl)) {
			// todo: potential https issue
			$returnUrl = sprintf('http:%s', urlencode(Yii::app()->params['baseUrl']));
		}

		if (Yii::app()->params['authAdapter'] == 'connect') {
			$urlConnectLogout = sprintf('%s/logoutRedirectUrl/?url=%s', Yii::app()->params['connectUrl'], $returnUrl);
			$this->redirect($urlConnectLogout);
		} else {
			$this->redirect(Yii::app()->params['baseUrl']);
		}
	}

	public function actionSignup($returnUrl = '')
	{
		if (Yii::app()->params['authAdapter'] == 'connect') {
			$this->redirect(array('/site/connectLogin', 'returnUrl' => $returnUrl));
		} else {
			$this->redirect(array('/site/localSignup', 'returnUrl' => $returnUrl));
		}
	}

	public function actionLocalSignup($returnUrl = '')
	{
		$model['form'] = new SignupForm;

		if (isset($_POST['SignupForm'])) {
			$model['form']->attributes = $_POST['SignupForm'];

			// if the model is validated
			if ($model['form']->validate()) {
				$input['email'] = $model['form']['email'];
				$input['cemail'] = $model['form']['cemail'];
				$input['fullname'] = $model['form']['fullname'];

				$return = HUB::createLocalMember($model['form']['email'], $model['form']['fullname'], $signupType = 'default', $input);
				if ($return['status'] == 'success') {
					$user = $return['data']['user'];

					$params['email'] = $input['email'];
					$params['password'] = $return['data']['newPassword'];
					$params['link'] = $this->createAbsoluteUrl('site/login');
					$receivers[] = array('email' => $input['email'], 'name' => $input['fullname']);

					$result = ysUtil::sendTemplateMail($receivers, Yii::t('app', 'Welcome to {site}', array('{site}' => Yii::app()->params['baseDomain'])), $params, '_createMember');

					// continue to the welcome page
					$this->redirect(array('site/welcome', 'id' => $user->id, 'returnUrl' => $returnUrl));
				} else {
					Notice::page("Failed to register due to unexpected reason: '{$exceptionMessage}'.", Notice_ERROR);
				}
			}
		}
		$this->render('localSignup', array('model' => $model));
	}

	// create a specific signup success page for google analytics tracking
	public function actionWelcome($id, $returnUrl = '')
	{
		$user = User::model()->findByPk($id);
		if (empty($user)) {
			$this->redirect(array('error'));
		}

		// after initAccount
		if (Yii::app()->user->id == $user->id) {
			$url = (!empty($returnUrl)) ? $returnUrl : $this->createUrl('cpanel/index');
			Notice::page(
				Yii::t(
					'app',
					'Hello {nickname}, your profile is updated successfully.',
					array('{nickname}' => $user->nickname, '{email}' => $user->username)
				),
				Notice_SUCCESS,
				array(
					'urlLabel' => 'Continue', 'url' => $url,
				)
			);
		}
		// traditional signup
		else {
			$url = (!empty($returnUrl)) ? $returnUrl : (($user->signup_type == 'social' ? $this->createUrl('hauth/login') : $this->createUrl('site/login', array('email' => $user->username))));

			Notice::page(
				Yii::t(
					'app',
					"Successfully registered your account '{username}'. Your password has been sent to the desinated email address '{email}'.",
					array('{username}' => $user->username, '{email}' => $user->username)
				),
				Notice_SUCCESS,
				array(
					'urlLabel' => 'Login Now', 'url' => $url,
				)
			);
		}
	}

	public function actionLostPassword()
	{
		throw new CHttpException(404, 'Page not found.');
	}

	public function actionResetLostPassword()
	{
		throw new CHttpException(404, 'Page not found.');
	}

	public function actionTerminateAccount()
	{
		$this->render('accountTerminationInfo');
	}
}
