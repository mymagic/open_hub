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

class ProfileController extends Controller
{
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view', 'update', 'changePassword'),
				'users' => array('@'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	protected function loadModelByUserId($userId)
	{
		$model = Profile::model()->find('t.user_id=:userId', array(':userId' => $userId));
		if ($model === null) {
			throw new CHttpException(404, 'The requested user does not exist.');
		}

		return $model;
	}

	public function actionIndex()
	{
		$this->redirect(array('view'));
	}

	public function actionView()
	{
		$this->layout = 'cpanel';
		$this->pageTitle = Yii::t('app', 'Account - View');

		if (Yii::app()->user->isGuest) {
			throw new CException(Yii::t('app', 'You must login to view your Account'));
		}
		$this->render('view', array(
			'model' => $this->loadModelByUserId(Yii::app()->user->id)
		));
	}

	public function actionUpdate()
	{
		$this->layout = 'cpanel';
		$this->pageTitle = Yii::t('app', 'Account - Update');
		if (Yii::app()->user->isGuest) {
			throw new CException(Yii::t('app', 'You must login to update your profile'));
		}
		$model = $this->loadModelByUserId(Yii::app()->user->id);

		if (isset($_POST['Profile'])) {
			$model->attributes = $_POST['Profile'];
			//$model->avatar_image_file = CUploadedFile::getInstance($model, 'avatar_image_file');
			if ($model->save()) {
				/*if(is_object($model->avatar_image_file))
				{
					$image = new Image($model->avatar_image_file->tempName);
					$image->resize(160, 160, Image::NONE);
					$image->save($model->upload_path.DIRECTORY_SEPARATOR .'avatar.'.$model->username.'.jpg');

					$model->avatar_image_url = 'uploads/profile/avatar.' . $model->username . '.jpg';
					$model->save();
				}*/

				Notice::flash(Yii::t('notice', 'Your account is updated successfully.'), Notice_SUCCESS);
				$this->redirect(array('view'));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionChangePassword()
	{
		$this->layout = 'cpanel';
		$this->pageTitle = Yii::t('app', 'Account - Change Password');

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
				$modelToSave = $this->loadModelByUserId(Yii::app()->user->id);

				if ($modelToSave->user->matchPassword($model->opassword)) {
					$modelToSave->user->password = $model->cpassword;
					if ($modelToSave->user->save(false)) {
						Notice::flash(Yii::t('notice', 'Your new password is updated successfully.'), Notice_SUCCESS);
						$this->redirect(array('profile/view'));
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
}
