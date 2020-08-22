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
class SettingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'backend';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index'),
				'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('panel'),
				'users' => array('@'),
				// 'expression' => "\$user->getState('isSuperAdmin')==true",
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('allow', // allow authenticated user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions' => array('view', 'create', 'update', 'admin', 'delete'),
				'users' => array('@'),
				// 'expression' => "\$user->getState('isDeveloper')==true",
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller)',
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Setting;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Setting'])) {
			$model->attributes = $_POST['Setting'];

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Setting'])) {
			$model->attributes = $_POST['Setting'];
			$model->scenario = sprintf('update%s', ucwords($model->datatype));

			if ($model->datatype == 'image') {
				$model->imageFile_value = UploadedFile::getInstance($model, 'imageFile_value');
			}
			if ($model->datatype == 'file') {
				$model->uploadFile_value = UploadedFile::getInstance($model, 'uploadFile_value');
			}

			//print_r($model->uploadFile_value);exit;

			if ($model->validate()) {
				if ($model->save()) {
					if ($model->datatype == 'image' && is_object($model->imageFile_value)) {
						$image = new Image($model->imageFile_value->tempName);
						$saveFileName = sprintf('%s.%s.%s', 'setting', $model->id, strtolower(ysUtil::getFileExtension($model->imageFile_value->name)));
						$image->save(sprintf($model->uploadPath . DIRECTORY_SEPARATOR . '%s', $saveFileName));
						$model->value = sprintf('uploads/%s/%s', $model->tableName(), $saveFileName);
						$model->save();

						UploadManager::storeImage($model, 'value', $model->tableName(), null, '', 'value');
					}
					if ($model->datatype == 'file' && is_object($model->uploadFile_value)) {
						/*$saveFileName = sprintf('%s.%s.%s', 'setting', $model->id, strtolower(ysUtil::getFileExtension($model->uploadFile_value->name)));
						$model->value = sprintf('uploads/%s/%s', $model->tableName(), $saveFileName);
						$model->save();*/

						UploadManager::storeFile($model, 'value', $model->tableName(), '', 'value');
					}
					$this->redirect(array('view', 'id' => $model->id));
				}
			}
			/*else
			{
				$errors = $model->errors;
				print_r($errors);exit;
			}*/
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionPanel()
	{
		// auto create if not found
		$model['seo-meta-title'] = (!Setting::isCodeExists('seo-meta-title')) ? Setting::setSetting('seo-meta-title', '', 'string') : $this->loadModelByCode('seo-meta-title');

		$model['seo-meta-keywords'] = (!Setting::isCodeExists('seo-meta-keywords')) ? Setting::setSetting('seo-meta-keywords', '', 'text') : $this->loadModelByCode('seo-meta-keywords');

		$model['seo-meta-description'] = (!Setting::isCodeExists('seo-meta-description')) ? Setting::setSetting('seo-meta-description', '', 'text') : $this->loadModelByCode('seo-meta-description');

		$model['organization-master-code'] = (!Setting::isCodeExists('organization-master-code')) ? Setting::setSetting('organization-master-code', '', 'string') : $this->loadModelByCode('organization-master-code');

		if (isset($_POST['Setting'])) {
			// seo
			$model['seo-meta-title']->value = $_POST['Setting']['seo-meta-title'];
			$model['seo-meta-title']->save(false);
			$model['seo-meta-keywords']->value = $_POST['Setting']['seo-meta-keywords'];
			$model['seo-meta-keywords']->save(false);
			$model['seo-meta-description']->value = $_POST['Setting']['seo-meta-description'];
			$model['seo-meta-description']->save(false);

			// organization
			$model['organization-master-code']->value = $_POST['Setting']['organization-master-code'];
			$model['organization-master-code']->save(false);

			// when done
			Notice::flash(Yii::t('backend', 'Your settings have been saved successfully'), Notice_SUCCESS);
			$this->redirect(array('setting/panel'));
		}

		$this->render('panel', array('model' => $model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('setting/panel'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Setting('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['Setting'])) $model->attributes=$_GET['Setting'];
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
	 * @param integer $id the ID of the model to be loaded
	 * @return Setting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Setting::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	public function loadModelByCode($code)
	{
		$model = Setting::model()->find('code=:code', array(':code' => $code));
		if ($model === null) {
			throw new CHttpException(404, 'The requested setting does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Setting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'setting-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
