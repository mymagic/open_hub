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
class MemberController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *             using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
				'actions' => array('view', 'admin', 'create', 'createConnect',
					'block', 'blockConfirmed', 'unblock', 'unblockConfirmed',
					'terminate', 'terminateConfirmed', 'permit', 'permitConfirmed',
					'resetPassword', 'resetPasswordConfirmed',
				),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isMemberManager==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionCreateConnect()
	{
		$model = new Member('createConnect');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Member'])) {
			$model->attributes = $_POST['Member'];
			//echo "<pre>";print_r($model);exit;
			if ($model->validate()) {
				$exceptionMessage = '';
				$newPassword = ysUtil::generateRandomPassword();

				$user = new User('create');
				$user->profile = new Profile('create');

				$transaction = Yii::app()->db->beginTransaction();

				try {
					// create user
					$user->username = $model->username;
					$user->password = $newPassword;
					$user->signup_type = 'admin';
					$user->signup_ip = Yii::app()->request->userHostAddress;
					$user->is_active = 1;

					$result = $user->save();

					// create profile
					if ($result == true) {
						$user->profile->user_id = $user->id;
						$user->profile->full_name = sprintf('%s %s', $model->first_name, $model->last_name);
						$user->profile->image_avatar = 'uploads/profile/avatar.default.jpg';

						$result = $user->profile->save();

						if ($result == true) {
							$member = new Member();
							$member->user_id = $user->id;
							$member->username = $user->username;
							$result = $member->save();

							// create connect account
							if ($result == true) {
								// connect have no such user
								if (!$this->magicConnect->isUserExists($user->username)) {
									$result = $this->magicConnect->createUser($model->username, $model->first_name, $model->last_name, $newPassword);
									if ($result != true) {
										throw new Exception(Yii::t('app', 'Failed to create user on MaGIC Connect'));
									}
								}
							} else {
								throw new Exception(Yii::t('app', 'Failed to save member into database'));
							}
						} else {
							throw new Exception(Yii::t('app', 'Failed to save profile into database'));
						}
					} else {
						throw new Exception(Yii::t('app', 'Failed to save user into database '));
					}

					$transaction->commit();
				} catch (Exception $e) {
					$exceptionMessage = $e->getMessage();
					$result = false;
					$transaction->rollBack();
				}

				// successfully finish the registration step of the subscription process
				if ($result == true) {
					// continue to the login
					Notice::page(
						Yii::t('notice', "Successfully created member account with username '{username}'. Login password has been sent to the desinated email address '{email}'.", ['{username}' => $model->username, '{email}' => $model->username]),
						Notice_SUCCESS,
						array('urlLabel' => Yii::t('app', 'View Member'), 'url' => $this->createUrl('view', array('id' => $user->id)))
					);
				} else {
					Notice::page(Yii::t('notice', 'Failed to register due to unexpected reason: {exceptionMsg}.', ['{exceptionMsg}' => $exceptionMessage]), Notice_ERROR);
				}
			}
		}

		$this->render('createConnect', array(
			'model' => $model,
		));
	}

	public function actionCreate()
	{
		// magic connect

		$this->redirect('createConnect');

		$model = new Member('create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Member'])) {
			$model->attributes = $_POST['Member'];
			//echo "<pre>";print_r($model);exit;
			if ($model->validate()) {
				$exceptionMessage = '';
				$newPassword = ysUtil::generateRandomPassword();

				$user = new User('create');
				$user->profile = new Profile('create');

				$transaction = Yii::app()->db->beginTransaction();

				try {
					// create user
					$user->username = $model->username;
					$user->password = $newPassword;
					$user->signup_type = 'admin';
					$user->signup_ip = Yii::app()->request->userHostAddress;
					$user->is_active = 1;

					$result = $user->save();

					// create profile
					if ($result == true) {
						$user->profile->user_id = $user->id;
						$user->profile->full_name = $model->full_name;
						$user->profile->image_avatar = 'uploads/profile/avatar.default.jpg';

						$result = $user->profile->save();

						if ($result == true) {
							$member = new Member();
							$member->user_id = $user->id;
							$member->username = $user->username;
							$member->date_joined = time();
							$result = $member->save();
						} else {
							throw new Exception(Yii::t('app', 'Failed to save profile into database'));
						}
					} else {
						throw new Exception(Yii::t('app', 'Failed to save user into database '));
					}

					$transaction->commit();
				} catch (Exception $e) {
					$exceptionMessage = $e->getMessage();
					$result = false;
					$transaction->rollBack();
				}

				// successfully finish the registration step of the subscription process
				if ($result == true) {
					// send new password
					$params['email'] = $user->username;
					$params['password'] = $newPassword;
					$params['link'] = $this->createAbsoluteUrl('site/login');
					$receivers[] = array('email' => $user->username, 'name' => $user->profile->full_name);
					$result = ysUtil::sendTemplateMail($receivers, Yii::t('default', 'Welcome to {site}', array('{site}' => Yii::app()->params['baseDomain'])), $params, '_createMember');

					// continue to the login
					Notice::page(
						Yii::t('notice', "Successfully created member account with username '{username}'. Login password has been sent to the desinated email address '{email}'.", ['{username}' => $model->username, '{email}' => $model->username]),
						Notice_SUCCESS,
						array('urlLabel' => Yii::t('app', 'View Member'), 'url' => $this->createUrl('view', array('id' => $user->id)))
					);
				} else {
					Notice::page(Yii::t('notice', 'Failed to register due to unexpected reason: {exceptionMsg}.', ['{exceptionMsg}' => $exceptionMessage]), Notice_ERROR);
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Displays a particular model.
	 *
	 * @param int $id the ID of the model to be displayed
	 */
	public function actionView($id, $realm = 'backend', $tab = 'comment')
	{
		$member = $this->loadModel($id);
		$model = $member;
		$frauds = null;
		$user = $member->user;
		$username = $user->username;

		// find duplicate mobile
		if (!empty($user->profile->mobile_no)) {
			$sqlSelectDoubleMobile = sprintf("SELECT u.id, u.username, u.is_active FROM user as u, member as m, profile as p WHERE m.username=u.username AND p.user_id=u.id AND p.mobile_no='%s' AND m.username!='%s' GROUP BY u.id ORDER BY u.date_last_login DESC", $user->profile->mobile_no, $username);
			$tmps = Yii::app()->db->createCommand($sqlSelectDoubleMobile)->queryAll();
			foreach ($tmps as $t) {
				$frauds[] = array('type' => 'duplicateMobileNo', 'msg' => Yii::t('backend', 'Duplicate mobile number with user <a href="{link}"><span class="label label-{active}">{username}</span></a>', array('{username}' => $t['username'], '{active}' => $t['is_active'] ? 'success' : 'danger', '{link}' => $this->createUrl('member/view', array('id' => $t['id'])))));
			}
		}

		$actions = array();
		$user = User::model()->findByPk(Yii::app()->user->id);

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			// for backend only
			if (Yii::app()->user->accessBackend && $realm == 'backend') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getMemberActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getMemberActions($model, 'backend'));
				}
			}
			// for frontend only
			if (Yii::app()->user->accessCpanel && $realm == 'cpanel') {
				if (method_exists(Yii::app()->getModule($moduleKey), 'getMemberActions')) {
					$actions = array_merge($actions, (array) Yii::app()->getModule($moduleKey)->getMemberActions($model, 'cpanel'));
				}
			}
		}

		$tabs = self::composeMemberViewTabs($model, $realm);

		$this->render('view', array(
			'model' => $member,
			'member' => $model,
			'actions' => $actions,
			'realm' => $realm,
			'tab' => $tab,
			'tabs' => $tabs,
			'user' => $user,
		));
	}

	public function actionResetPassword($id)
	{
		// magic central only
		Notice::page(Yii::t('backend', 'Please reset user password at MaGIC Account'));

		$member = $this->loadModel($id);

		Notice::page(
			Yii::t('notice', 'Are you sure to reset password for member user {username}?', ['{username}' => $member->user->username]),

			Notice_WARNING,
		array('url' => $this->createUrl('resetPasswordConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
		);
	}

	public function actionResetPasswordConfirmed($id)
	{
		// magic central only
		Notice::page(Yii::t('backend', 'Please reset user password at MaGIC Account'));

		$member = $this->loadModel($id);
		$newPassword = ysUtil::generateRandomPassword(8, 6, true);
		$member->user->password = $newPassword;
		$member->user->stat_reset_password_count = $member->user->stat_reset_password_count + 1;
		$logBackend = Yii::t('app', "{date} '{username}' - Password Reseted to '{newPassword}' ", array('{username}' => Yii::app()->user->username, '{date}' => Html::formatDateTime(time(), 'medium', 'long'), '{newPassword}' => $newPassword), null, Yii::app()->sourceLanguage);
		$member->log_admin_remark = $logBackend . "\n" . $member->log_admin_remark;

		if ($member->user->save() && $member->save(false)) {
			Notice::page(Yii::t('notice', 'Password has been reset successfully. Member user {username} new password is {password}.', ['{username}' => $member->user->username, '{password}' => $newPassword]), Notice_WARNING, array('url' => $this->createUrl('view', array('id' => $id))));
		} else {
			Notice::flash(Yii::t('notice', 'Failed to reset password for member user {username} due to unknown reason.', ['{username}' => $member->user->username]), Notice_ERROR);
			$this->redirect(array('member/view', 'id' => $id));
		}
	}

	public function actionBlock($id)
	{
		$member = $this->loadModel($id);
		if ($member->user->is_active == 1) {
			Notice::page(
				Yii::t('notice', 'Are you sure to block this member user {username}? Blocked member user will not beable to login.', ['{username}' => $member->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('blockConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', 'Member user {username} is already blocked or inactive.', ['{username}' => $member->user->username]), Notice_INFO);
			$this->redirect(array('member/view', 'id' => $id));
		}
	}

	public function actionBlockConfirmed($id)
	{
		$member = $this->loadModel($id);
		$member->user->is_active = 0;
		$logBackend = Yii::t('app', "{date} '{username}' - Blocked ", array('{username}' => Yii::app()->user->username, '{date}' => Html::formatDateTime(time(), 'medium', 'long')), null, Yii::app()->sourceLanguage);
		$member->log_admin_remark = $logBackend . "\n" . $member->log_admin_remark;

		if ($member->user->save(false) && $member->save(false)) {
			Notice::flash(Yii::t('notice', 'Member user {username} is successfully blocked.', ['{username}' => $member->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', 'Failed to block member user {username} due to unknown reason.', ['{username}' => $member->user->username]), Notice_ERROR);
		}

		$this->redirect(array('member/view', 'id' => $id));
	}

	public function actionUnblock($id)
	{
		$member = $this->loadModel($id);
		if ($member->user->is_active == 0) {
			Notice::page(
				Yii::t('notice', 'Are you sure to unblock this member user {username}? Unblocked member user is active and will beable to login again.', ['{username}' => $member->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('unblockConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', 'Member user {username} is already unblocked or active.', ['{username}' => $member->user->username]), Notice_INFO);
			$this->redirect(array('member/view', 'id' => $id));
		}
	}

	public function actionUnblockConfirmed($id)
	{
		$member = $this->loadModel($id);
		$member->user->is_active = 1;
		$logBackend = Yii::t('app', "{date} '{username}' - Unblocked ", array('{username}' => Yii::app()->user->username, '{date}' => Html::formatDateTime(time(), 'medium', 'long')), null, Yii::app()->sourceLanguage);
		$member->log_admin_remark = $logBackend . "\n" . $member->log_admin_remark;

		if ($member->user->save(false) && $member->save(false)) {
			Notice::flash(Yii::t('notice', 'Member user {username} is successfully unblocked.', ['{username}' => $member->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', 'Failed to unblock member user {username} due to unknown reason.', ['{username}' => $member->user->username]), Notice_ERROR);
		}

		$this->redirect(array('member/view', 'id' => $id));
	}

	public function actionTerminate($id)
	{
		$member = $this->loadModel($id);
		if ($member->user->is_active == 1) {
			Notice::page(
				Yii::t('notice', 'Are you sure to terminate this member user {username}? Terminated member user will not be able to login.', ['{username}' => $member->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('terminateConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		}
		// else
		// {
		// 	Notice::flash(Yii::t('app', sprintf("Member user '%s' is already blocked or inactive.", $member->user->username)), Notice_INFO);
		// 	$this->redirect(array('member/view', 'id'=>$id));
		// }
	}

	public function actionTerminateConfirmed($id)
	{
		$member = $this->loadModel($id);
		$member->user->is_active = 0;
		$logBackend = Yii::t('app', "{date} '{username}' - Terminated ", array('{username}' => Yii::app()->user->username, '{date}' => Html::formatDateTime(time(), 'medium', 'long')), null, Yii::app()->sourceLanguage);
		$member->log_admin_remark = $logBackend . "\n" . $member->log_admin_remark;

		if ($member->user->save(false) && $member->save(false) && $member->user->setStatusToTerminateInConnect()) {
			//Add the request to Request table
			//Add the request to Request table
			$request = Request::model()->findByAttributes(array('status' => 'pending', 'type_code' => 'removeUserAccount', 'user_id' => $id));
			if (empty($r)) {
				$request = new Request();
				$request->user_id = $id;
				$request->type_code = 'removeUserAccount';
				$request->title = 'Request to remove account by admin';
				$request->status = 'pending';
				$request->save();
			}

			Notice::flash(Yii::t('notice', 'Member user {username} is successfully terminated.', ['{username}' => $member->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', 'Failed to terminate member user {username} due to unknown reason.', ['{username}' => $member->user->username]), Notice_ERROR);
		}

		$this->redirect(array('member/view', 'id' => $id));
	}

	public function actionPermit($id)
	{
		$member = $this->loadModel($id);
		if ($member->user->is_active == 0) {
			Notice::page(
				Yii::t('notice', 'Are you sure to enable this member user {username}? enabled member will be able to login again.', ['{username}' => $member->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('permitConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		}
		// else
		// {
		// 	Notice::flash(Yii::t('app', sprintf("Member user '%s' is already enabled or active.", $member->user->username)), Notice_INFO);
		// 	$this->redirect(array('member/view', 'id'=>$id));
		// }
	}

	public function actionPermitConfirmed($id)
	{
		$member = $this->loadModel($id);
		$member->user->is_active = 1;
		$logBackend = Yii::t('app', "{date} '{username}' - Enabled ", array('{username}' => Yii::app()->user->username, '{date}' => Html::formatDateTime(time(), 'medium', 'long')), null, Yii::app()->sourceLanguage);
		$member->log_admin_remark = $logBackend . "\n" . $member->log_admin_remark;

		if ($member->user->save(false) && $member->save(false) && $member->user->setStatusToEnableInConnect()) {
			Notice::flash(Yii::t('notice', 'Member user {username} is successfully enabled.', ['{username}' => $member->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', 'Failed to enable member user {username} due to unknown reason.', ['{username}' => $member->user->username]), Notice_ERROR);
		}

		$this->redirect(array('member/view', 'id' => $id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('member/admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Member('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Member'])) {
			$model->attributes = $_GET['Member'];
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
	 * @return Member the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Member::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param Member $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'member-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function composeMemberViewTabs($model, $realm = 'backend')
	{
		$tabs = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getMemberViewTabs')) {
				$tabs = array_merge($tabs, (array) Yii::app()->getModule($moduleKey)->getMemberViewTabs($model, $realm));
			}
		}

		if ($realm == 'backend') {
			/*$tabs['member'][] = array(
				'key' => 'individual',
				'title' => 'Individual',
				'viewPath' => 'views.individualMember.backend._view-member-individual'
			);*/
		}

		ksort($tabs);

		// if (Yii::app()->user->isDeveloper) {
		if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) {
			$tabs['member'][] = array(
				'key' => 'meta',
				'title' => 'Meta <span class="label label-warning">dev</span>',
				'viewPath' => '_view-meta',
			);
		}

		return $tabs;
	}
}
