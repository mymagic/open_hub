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
class ProofController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/backend', meaning
	 * using two-column layout. See 'protected/views/layouts/backend.php'.
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
				'actions' => array('list', 'view', 'create', 'update', 'admin', 'delete'),
				'users' => array('@'),
				// 'expression' => '$user->isSuperAdmin==true || $user->isAdmin==true',
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
	public function actionCreate($refTable = '', $refId = '')
	{
		$forRecord = null;

		$model = new Proof;
		$model->user_username = Yii::app()->user->username;

		if (!empty($refTable)) {
			$model->ref_table = $refTable;
		}
		if (!empty($refId)) {
			$model->ref_id = $refId;
		}

		if (!empty($model->ref_table) && !empty($model->ref_id)) {
			$forRecord['obj'] = Proof::getForRecord($model->ref_table, $model->ref_id);

			/*if ($model->ref_table == 'idea_rfp') {
				$forRecord['title'] = sprintf('%s of %s', Proof::formatEnumRefTable($refTable), $forRecord['obj']->title);
			} else */{
				$forRecord['title'] = sprintf('%s of %s', Proof::formatEnumRefTable($refTable), $forRecord['obj']->organization->title);
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if ($model->datatype == 'image') {
			$model->imageFile_value = UploadedFile::getInstance($model, 'imageFile_value');
		} elseif ($model->datatype == 'file') {
			$model->uploadFile_value = UploadedFile::getInstance($model, 'uploadFile_value');
		}

		if (isset($_POST['Proof'])) {
			$model->attributes = $_POST['Proof'];

			if ($model->datatype == 'image') {
				$model->imageFile_value = UploadedFile::getInstance($model, 'imageFile_value');
			} elseif ($model->datatype == 'file') {
				$model->uploadFile_value = UploadedFile::getInstance($model, 'uploadFile_value');
			}

			if ($model->save()) {
				if ($model->datatype == 'image' && is_object($model->imageFile_value)) {
					$image = new Image($model->imageFile_value->tempName);
					$saveFileName = sprintf('%s.%s.%s', 'value', $model->id, strtolower(ysUtil::getFileExtension($model->imageFile_value->name)));
					$image->save(sprintf($model->uploadPath . DIRECTORY_SEPARATOR . '%s', $saveFileName));
					$model->value = sprintf('uploads/%s/%s', $model->tableName(), $saveFileName);
					$model->save();

					UploadManager::storeImage($model, 'value', $model->tableName(), null, '', 'value');
				} elseif ($model->datatype == 'file' && is_object($model->uploadFile_value)) {
					UploadManager::storeFile($model, 'value', $model->tableName(), '', 'value');
				}

				if (!empty($forRecord)) {
					$this->redirect($model->getUrl('return2Record'));
				} else {
					$this->redirect(array('view', 'id' => $model->id));
				}
			}
		}

		$this->render('create', array(
			'model' => $model, 'forRecord' => $forRecord
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

		if (!empty($model->ref_table) && !empty($model->ref_id)) {
			$forRecord['obj'] = Proof::getForRecord($model->ref_table, $model->ref_id);

			/*if ($model->ref_table == 'idea_rfp') {
				$forRecord['title'] = sprintf('%s of %s', Proof::formatEnumRefTable($model->ref_table), $forRecord['obj']->title);
			} else */{
				$forRecord['title'] = sprintf('%s of %s', Proof::formatEnumRefTable($model->ref_table), $forRecord['obj']->organization->title);
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if ($model->datatype == 'image') {
			$model->imageFile_value = UploadedFile::getInstance($model, 'imageFile_value');
		} elseif ($model->datatype == 'file') {
			$model->uploadFile_value = UploadedFile::getInstance($model, 'uploadFile_value');
		}

		if (isset($_POST['Proof'])) {
			$model->attributes = $_POST['Proof'];
			$model->user_username = Yii::app()->user->username;

			if ($model->save()) {
				if ($model->datatype == 'image' && is_object($model->imageFile_value)) {
					$image = new Image($model->imageFile_value->tempName);
					$saveFileName = sprintf('%s.%s.%s', 'value', $model->id, strtolower(ysUtil::getFileExtension($model->imageFile_value->name)));
					$image->save(sprintf($model->uploadPath . DIRECTORY_SEPARATOR . '%s', $saveFileName));
					$model->value = sprintf('uploads/%s/%s', $model->tableName(), $saveFileName);
					$model->save();

					UploadManager::storeImage($model, 'value', $model->tableName(), null, '', 'value');
				} elseif ($model->datatype == 'file' && is_object($model->uploadFile_value)) {
					UploadManager::storeFile($model, 'value', $model->tableName(), '', 'value');
				}

				if (!empty($forRecord)) {
					$this->redirect($model->getUrl('return2Record'));
				} else {
					$this->redirect(array('view', 'id' => $model->id));
				}
			}
		}

		$this->render('update', array(
			'model' => $model, 'forRecord' => $forRecord
		));
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
	 * Index
	 */
	public function actionIndex()
	{
		$this->redirect(array('proof/admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$dataProvider = new CActiveDataProvider('Proof');
		$dataProvider->pagination->pageSize = 5;
		$dataProvider->pagination->pageVar = 'page';

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Proof('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Proof'])) {
			$model->attributes = $_GET['Proof'];
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
	 * @param integer $id the ID of the model to be loaded
	 * @return Proof the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Proof::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Proof $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'proof-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
