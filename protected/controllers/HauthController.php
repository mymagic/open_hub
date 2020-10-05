<?php

class HauthController extends Controller
{
	public $defaultAction = 'login';
	public $debugMode = true;

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	// important! all providers will access this action, is the route of 'base_url' in config
	public function actionEndpoint()
	{
		// when user click cancel on facebook signup
		// $_GET: Array ( [hauth_done] => Facebook [error] => access_denied [error_code] => 200 [error_description] => Permissions error [error_reason] => user_denied [state] => 19a659b741fb5a7391ec86115ee079fc ) access endpoint
		//print_r($_GET);echo "access endpoint";exit;
		if (Yii::app()->request->getParam('error') == 'access_denied') {
			$solution = '';
			switch (Yii::app()->request->getParam('error_reason')) {
				case 'user_denied': { $solution = Yii::t('app', 'Please go back and click ok to accept the app permission.'); break;}
			}
			Notice::page(Yii::t('app', 'We have an error here: {msg}. {solution}', array('{msg}' => $_GET['error_description'], '{solution}' => $solution)));
		}
		Yii::app()->hybridAuth->endPoint();
	}

	public function actionLink($provider = 'Facebook')
	{
		//if(Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider))
		if (!Yii::app()->hybridAuth->isAllowedProvider($provider)) {
			$this->redirect(Yii::app()->homeUrl);
		}

		if ($this->debugMode) {
			Yii::app()->hybridAuth->showError = true;
		}

		if (Yii::app()->hybridAuth->isAdapterUserConnected($provider)) {
			$hauthSocialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);

			if (isset($hauthSocialUser)) {
				$jsonSocialParams = json_encode($hauthSocialUser);
				// get an user object
				//$user = User::username2id($hauthSocialUser->emailVerified);
				$user = User::model()->findByPk(Yii::app()->user->id);

				// both email must be same
				if ($hauthSocialUser->emailVerified == $user->username && !empty($hauthSocialUser->emailVerified) && $user) {
					// check if provider exists
					$userSocial = UserSocial::getObjByProviderId($hauthSocialUser->emailVerified, strtolower($provider), $hauthSocialUser->identifier);

					// if not exists, create new
					if (!empty($userSocail)) {
						$userSocial->json_social_params = $jsonSocialParams;
					}
					// else, update
					else {
						$userSocial = new UserSocial;
						$userSocial->username = $user->username;
						$userSocial->social_provider = strtolower($provider);
						$userSocial->social_identifier = $hauthSocialUser->identifier;
						$userSocial->json_social_params = $jsonSocialParams;
					}

					if ($userSocial->validate() && $userSocial->save()) {
						Notice::flash(Yii::t('app', 'Your user account has been successfully linked up with {provider}', array('{provider}' => ucwords($provider))), Notice_SUCCESS);
					} else {
						Notice::flash($this->modelErrors2String($userSocial->getErrors()), Notice_ERROR);
					}

					$this->redirect(array('profile/social'));
				} else {
					Notice::page(Yii::t('app', "Failed to link up your user account with {provider}. You need to login {provider} with email '{username}'. Please make sure it is set as primary and verified.", array('{provider}' => ucwords($provider), '{email}' => $hauthSocialUser->emailVerified, '{username}' => $user->username)), Notice_ERROR, array('url' => $this->createUrl('profile/social')));
				}

				// find user from db model with social user info
				//$user = User::model()->findBySocial($provider, $hauthSocialUser->identifier);
			} else {
				//echo "cant get social user";exit;
			}
		}

		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionLogin($provider = 'Facebook', $redirect = '')
	{
		$isNewSignup = false;

		if (!empty($redirect)) {
			Yii::app()->user->returnUrl = $redirect;
		}
		if (!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider)) {
			Notice::flash(Yii::t('app', 'Either you are already login or the provider is invalid or disabled'), Notice_ERROR);
			$this->redirect(Yii::app()->homeUrl);
		}

		if ($this->debugMode) {
			Yii::app()->hybridAuth->showError = true;
		}

		if (Yii::app()->hybridAuth->isAdapterUserConnected($provider)) {
			$hauthSocialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);

			if (isset($hauthSocialUser)) {
				if (!empty($hauthSocialUser->emailVerified)) {
					// find user from db model with social user info
					$userSocial = UserSocial::getObjByProviderId($hauthSocialUser->emailVerified, $provider, $hauthSocialUser->identifier);

					// userSocial not found, perform auto link
					if (empty($userSocial)) {
						$jsonSocialParams = json_encode($hauthSocialUser);
						//print_r($jsonSocialParams);exit;
						//print_r($hauthSocialUser);exit;

						// find user with the same email and matching social identifier
						$user = User::model()->find(
							't.username=:email AND t.is_active=1 AND t.stat_login_success_count>=0',
						array(':email' => $hauthSocialUser->emailVerified)
						);

						// user not found
						if (empty($user)) {
							// create user and link
							$input['email'] = $hauthSocialUser->emailVerified;
							$input['cemail'] = $hauthSocialUser->emailVerified;

							$result = HUB::createLocalMember($hauthSocialUser->emailVerified, $hauthSocialUser->displayName, strtolower($provider), array('user' => array(
								'social_provider' => strtolower($provider),
								'social_identifier' => $hauthSocialUser->identifier, 'json_social_params' => $jsonSocialParams)
							));

							if ($result['status'] == 'success') {
								$user = $result['data']['user'];
								$isNewSignup = true;
							} else {
								Notice::page(Yii::t('app', 'Failed to create user locally.'), Notice_ERROR);
							}
						}

						// user exists
						if (!empty($user)) {
							$userSocial = new UserSocial;
							$userSocial->username = $user->username;
							$userSocial->social_provider = strtolower($provider);
							$userSocial->social_identifier = $hauthSocialUser->identifier;
							$userSocial->json_social_params = $jsonSocialParams;
							if ($userSocial->validate() && $userSocial->save()) {
								// login
								$identity = new UserIdentity($userSocial->username, $userSocial->social_identifier);
								$identity->authenticate('social');

								if ($identity->errorCode === UserIdentity::ERROR_NONE) {
									$duration = 0;
									if (Yii::app()->user->login($identity, $duration)) {
										$this->afterLogin();
									}
								}
							} else {
								Notice::page(
								Yii::t('app', "Failed to login system using your social account '{email}'. You might wanto link them up in member control panel \ profile page.", array('{email}' => $hauthSocialUser->emailVerified)),
								Notice_ERROR,
									array('url' => $this->createUrl('site/login'))
								);
							}
						}
						// create user failed
						else {
							// Notice::page(Yii::t('app', "User not found."), Notice_ERROR, array('url'=>$this->createUrl('site/login')));
						}
					}
					// linked userSocial found
					else {
						// login user
						$identity = new UserIdentity($userSocial->username, $userSocial->social_identifier);
						$identity->socialProvider = strtolower($provider);
						$identity->authenticate('social');

						if ($identity->errorCode === UserIdentity::ERROR_NONE) {
							$duration = 0;
							if (Yii::app()->user->login($identity, $duration)) {
								$this->afterLogin();
							}
						} else {
							Notice::page(Yii::t('app', 'Failed to create user session due to unknown issue'));
						}
					}
				}
				// emailVerified is empty
				else {
					Notice::page(Yii::t('app', "Failed to login system using your social account. Please make sure your social account's email are verified."), Notice_ERROR, array('url' => $this->createUrl('site/login')));
				}
			}
		} else {
			Notice::page('Provider not connected');
		}

		$this->redirect(Yii::app()->homeUrl);
	}

	// deprecated
	public function actionSignup($provider = 'Facebook')
	{
		$this->setFrontendLayoutParams();

		$lProvider = strtolower($provider);
		$this->layout = '//layouts/frontend';

		if (!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider)) {
			$this->redirect(Yii::app()->homeUrl);
		}

		if (Yii::app()->hybridAuth->isAdapterUserConnected($provider)) {
			$hauthSocialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
			if (isset($hauthSocialUser)) {
				// check is the facebook id already linked with an existing account?
				$existingUser = User::model()->findBySocial($lProvider, $hauthSocialUser->identifier);
				if (!empty($existingUser)) {
					Notice::page(
						Yii::t(
							'app',
							'Your \'{provider}\' account already tied up with account \'{username}\'.',
							array('{provider}' => $provider, '{username}' => $existingUser->username)
						),
						Notice_INFO,
						array(
							'urlLabel' => 'Login Now', 'url' => $this->createUrl('hauth/login'),
						)
					);
				}

				//$model['embedMemberBenefits'] = Embed::model()->getByCode('member-benefits');
				$model['form'] = new SignupForm;
				$model['form']->email = $hauthSocialUser->emailVerified;
				$model['form']->full_name = $hauthSocialUser->displayName;
				$model['form']->mobile_no = $hauthSocialUser->phone;

				//print_r($hauthSocialUser);
				if (isset($_POST['SignupForm'])) {
					$model['form']->attributes = $_POST['SignupForm'];
					$model['form']->email = $hauthSocialUser->emailVerified;
					$model['form']->cemail = $hauthSocialUser->emailVerified;

					$captcha = Yii::app()->getController()->createAction('captcha');
					$model['form']->verifyCode = $captcha->verifyCode;

					// if the model is validated
					if ($model['form']->validate()) {
						try {
							$params['fullName'] = $model['form']->full_name;
							$params['mobileNo'] = $model['form']->mobile_no;

							$params['social_provider'] = $provider;
							$params['signup_type'] = $provider;
							$params['socialUser'] = $hauthSocialUser;

							// todo: change
							$result = RDS::registerNewMember($model['form']->email, $model['form']->cemail, $params);
						} catch (Exception $exceptionMessage) {
							$msg = $exceptionMessage->getMessage();
							Notice::page($msg, Notice_ERROR);
						}

						if ($result) {
							// continue to the login
							Notice::page(
								Yii::t(
									'app',
									"Successfully registered your account '{username}'. Your password has been sent to the desinated email address '{email}'.",
									array('{username}' => $model['form']->email, '{email}' => $model['form']->email)
								),
								Notice_SUCCESS,
								array(
									'urlLabel' => 'Login Now', 'url' => $this->createUrl('hauth/login', array('provider' => $provider)),
								)
							);
						} else {
							Notice::page(Yii::t('app', 'Failed to register due to unknown reason.'), Notice_ERROR);
						}
					}
				} else {
					//$model['form']->nickname = substr($hauthSocialUser->displayName, 0, 12);
				}

				$this->render('signup', array('model' => $model, 'provider' => $provider));

				return;
			} else {
				Notice::page(Yii::t('app', 'Failed to retrieve account info from {provider}', array('{provider}' => $provider)), Notice_ERROR);
			}
		} else {
			Notice::page(Yii::t('app', 'Invalid Provider'), Notice_ERROR);
		}
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionLogout()
	{
		if (Yii::app()->hybridAuth->getConnectedProviders()) {
			Yii::app()->hybridAuth->logoutAllProviders();
		}

		Yii::app()->user->logout();
	}

	public function actionTest()
	{
		try {
			echo !isset(Yii::app()->hybridAuth) ? 'no found' : 'found';
			exit;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
