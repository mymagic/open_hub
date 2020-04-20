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
class AdminController extends Controller
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
				'actions' => array('admin', 'create', 'createConnect', 'view',
					'block', 'blockConfirmed', 'unblock', 'unblockConfirmed',
					'resetPassword', 'resetPasswordConfirmed',
				),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdminManager==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('removeRole', 'removeRoleConfirmed', 'addRole', 'addRoleConfirmed'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isRoleManager==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
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

	public function actionResetPassword($id)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot reset password of an admin with super admin role, without having a super admin role by yourself'));
		}

		Notice::page(
			Yii::t('notice', "Are you sure to reset password for admin user '{username}'?", ['{username}' => $admin->user->username]),

			Notice_WARNING,
		array('url' => $this->createUrl('resetPasswordConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
		);
	}

	public function actionResetPasswordConfirmed($id)
	{
		$admin = $this->loadModel($id);

		// cannot change super admin's account if this admin manager do not have a super admin role as well
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot reset password of an admin with super admin role, without having a super admin role by yourself'));
		}

		$newPassword = ysUtil::generateRandomPassword();
		$admin->user->password = $newPassword;
		$admin->user->stat_reset_password_count = $admin->user->stat_reset_password_count + 1;

		if ($admin->user->save()) {
			Notice::page(Yii::t('notice', "Password has been reset successfully. Admin user '{username}' new password is '{password}'.", ['{username}' => $admin->user->username, '{password}' => $newPassword]), Notice_WARNING, array('url' => $this->createUrl('view', array('id' => $id))));
		} else {
			Notice::flash(Yii::t('notice', "Failed to reset password for admin user '{username}' due to unknown reason.", ['{username}' => $admin->user->username]), Notice_ERROR);
			$this->redirect(array('admin/view', 'id' => $id));
		}
	}

	public function actionBlock($id)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot block an admin with super admin role, without having a super admin role by yourself'));
		}

		if ($admin->user->is_active == 1) {
			Notice::page(
				Yii::t('notice', "Are you sure to block this admin user '{username}'? Blocked admin user will not beable to login.", ['{username}' => $admin->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('blockConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "Admin user '{username}' is already blocked or inactive.", ['{username}' => $admin->user->username]), Notice_INFO);
			$this->redirect(array('admin/view', 'id' => $id));
		}
	}

	public function actionBlockConfirmed($id)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot block an admin with super admin role, without having a super admin role by yourself'));
		}

		$admin->user->is_active = 0;

		if ($admin->user->save()) {
			Notice::flash(Yii::t('notice', "Admin user '{username}' is successfully blocked.", ['{username}' => $admin->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to block admin user '{username}' due to unknown reason.", ['{username}' => $admin->user->username]), Notice_ERROR);
		}

		$this->redirect(array('admin/view', 'id' => $id));
	}

	public function actionUnblock($id)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot unblock an admin with super admin role, without having a super admin role by yourself'));
		}

		if ($admin->user->is_active == 0) {
			Notice::page(
				Yii::t('notice', "Are you sure to unblock this admin user '{username}'? Unblocked admin user is active and will beable to login again.", ['{username}' => $admin->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('unblockConfirmed', array('id' => $id)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "Admin user '{username}' is already unblocked or active.", ['{username}' => $admin->user->username]), Notice_INFO);
			$this->redirect(array('admin/view', 'id' => $id));
		}
	}

	public function actionUnblockConfirmed($id)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot unblock an admin with super admin role, without having a super admin role by yourself'));
		}

		$admin->user->is_active = 1;

		if ($admin->user->save()) {
			Notice::flash(Yii::t('notice', "Admin user '{username}' is successfully unblocked.", ['{username}' => $admin->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to unblock admin user '{username}' due to unknown reason.", ['{username}' => $admin->user->username]), Notice_ERROR);
		}

		$this->redirect(array('admin/view', 'id' => $id));
	}

	public function actionRemoveRole($id, $roleCode)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot remove role from an admin with super admin role, without having a super admin role by yourself'));
		}

		if ($admin->user->hasRole($roleCode)) {
			Notice::page(
				Yii::t('notice', "Are you sure to remove role '{role}' from admin user '{username}'? Admin user without a specific role will not beable to perform certain tasks.", ['{role}' => $roleCode, '{username}' => $admin->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('removeRoleConfirmed', array('id' => $id, 'roleCode' => $roleCode)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "User '{username}' has no role '{role}' to remove.", ['{username}' => $admin->user->username, '{role}' => $roleCode]), Notice_INFO);
			$this->redirect(array('admin/view', 'id' => $id));
		}
	}

	public function actionRemoveRoleConfirmed($id, $roleCode)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasRole('superAdmin') && !$this->user->hasRole('superAdmin')) {
			Notice::page(Yii::t('notice', 'You cannot remove role from an admin with super admin role, without having a super admin role by yourself'));
		}

		if ($admin->user->removeRole($roleCode)) {
			Notice::flash(Yii::t('notice', "Role '{role}' is now removed from admin user '{username}' successfully. Changes will effect when the user relogin to the system.", ['{role}' => $roleCode, '{username}' => $admin->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to remove role '{role}' from admin user '{username}' due to unknown reason.", ['role' => $roleCode, '{username}' => $admin->user->username]), Notice_ERROR);
		}

		$this->redirect(array('admin/view', 'id' => $id));
	}

	public function actionAddRole($id, $roleCode)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->hasNoRole($roleCode)) {
			Notice::page(
				Yii::t('notice', "Are you sure to add role '{role}' to admin user '{username}'? Admin user with a specific role will beable to perform certain tasks.", ['{role}' => $roleCode, '{username}' => $admin->user->username]),
				Notice_WARNING,
			array('url' => $this->createUrl('addRoleConfirmed', array('id' => $id, 'roleCode' => $roleCode)), 'cancelUrl' => $this->createUrl('view', array('id' => $id)))
			);
		} else {
			Notice::flash(Yii::t('notice', "User '{username}' already has role '{role}' assigned.", ['{username}' => $admin->user->username, '{role}' => $roleCode]), Notice_INFO);
			$this->redirect(array('admin/view', 'id' => $id));
		}
	}

	public function actionAddRoleConfirmed($id, $roleCode)
	{
		$admin = $this->loadModel($id);
		if ($admin->user->addRole($roleCode)) {
			Notice::flash(Yii::t('notice', "Role '{role}' is now added to admin user '{username}' successfully. Changes will effect when the user relogin to the system.", ['{role}' => $roleCode, '{username}' => $admin->user->username]), Notice_SUCCESS);
		} else {
			Notice::flash(Yii::t('notice', "Failed to add role '{role}' to admin user '{username}' due to unknown reason.", ['{role}' => $roleCode, '{username}' => $admin->user->username]), Notice_ERROR);
		}

		$this->redirect(array('admin/view', 'id' => $id));
	}

	public function actionCreateConnect()
	{
		$model = new Admin('createConnect');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Admin'])) {
			$model->attributes = $_POST['Admin'];

			$exceptionMessage = '';
			$newPassword = ysUtil::generateRandomPassword();

			$transaction = Yii::app()->db->beginTransaction();

			try {
				// if user already exists
				if (!User::isUniqueUsername($model->username)) {
					$user = User::username2obj($model->username);
					$result = true;
				} else {
					if ($model->validate()) {
						$user = new User('create');
						$user->profile = new Profile('create');

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

							// create connect account
							if ($result == true) {
								// connect have no such user
								if (!$this->magicConnect->isUserExists($user->username)) {
									$result = $this->magicConnect->createUser($model->username, $model->first_name, $model->last_name, $newPassword);
								}
							} else {
								throw new Exception(Yii::t('app', 'Failed to save member into database'));
							}
						} else {
							throw new Exception(Yii::t('app', 'Failed to save user into database '));
						}
					} else {
						$result = false;
					}
				}

				// create admin
				if ($result == true) {
					$admin = new Admin();
					$admin->user_id = $user->id;
					$admin->username = $user->username;
					$result = $admin->save();
				} else {
					throw new Exception(Yii::t('app', 'Failed to save profile into database'));
				}

				// create member
				if (!Member::username2obj($user->username)) {
					$member = new Member();
					$member->user_id = $user->id;
					$member->username = $user->username;
					$member->date_joined = time();
					$member->save();
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
					Yii::t('notice', "Successfully created admin account with username '{username}'. Login password has been sent to the desinated email address '{email}'. Please remember to add role to the admin user.", array('{username}' => $model->username, '{email}' => $model->username)),
					Notice_SUCCESS,
					array('urlLabel' => Yii::t('app', 'View Admin'), 'url' => $this->createUrl('view', array('id' => $user->id)))
				);
			} else {
				Notice::page(Yii::t('notice', "Failed to register due to unexpected reason: '{exceptionMsg}'.", ['{exceptionMsg}' => $exceptionMessage]), Notice_ERROR);
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

		$model = new Admin('create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Admin'])) {
			$model->attributes = $_POST['Admin'];

			if ($model->validate()) {
				$exceptionMessage = '';
				$newPassword = ysUtil::generateRandomPassword();

				$transaction = Yii::app()->db->beginTransaction();

				try {
					// if user already exists
					if (!User::isUniqueUsername($model->username)) {
						$user = User::username2obj($model->username);
						$result = true;
					} else {
						$user = new User('create');
						$user->profile = new Profile('create');

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
						} else {
							throw new Exception(Yii::t('app', 'Failed to save user into database '));
						}
					}

					// create admin
					if ($result == true) {
						$admin = new Admin();
						$admin->user_id = $user->id;
						$admin->username = $user->username;
						$result = $admin->save();
					} else {
						throw new Exception(Yii::t('app', 'Failed to save profile into database'));
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
					$params['link'] = $this->createAbsoluteUrl('backend/login');
					$receivers[] = array('email' => $user->username, 'name' => $user->profile->full_name);
					$result = ysUtil::sendTemplateMail($receivers, Yii::t('default', 'Welcome to {site}', array('{site}' => Yii::app()->params['baseDomain'])), $params, '_createAdmin');

					// continue to the login
					Notice::page(
						Yii::t('notice', "Successfully created admin account with username '{username}'. Login password has been sent to the desinated email address '{email}'. Please remember to add role to the admin user.", array('{username}' => $model->username, '{email}' => $model->username)),
						Notice_SUCCESS,
						array('urlLabel' => Yii::t('app', 'View Admin'), 'url' => $this->createUrl('view', array('id' => $user->id)))
					);
				} else {
					Notice::page(Yii::t('notice', "Failed to register due to unexpected reason: '{exceptionMsg}'.", ['{exceptionMsg}' => $exceptionMessage]), Notice_ERROR);
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('admin/admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Admin('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Admin'])) {
			$model->attributes = $_GET['Admin'];
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
	 * @return Admin the loaded model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Admin::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param Admin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
