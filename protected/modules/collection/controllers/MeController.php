<?php

class MeController extends Controller
{
	public $layout = 'backend';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // deny all users
				'users' => array('@'),
				// 'expression' => '$user->isAdmin==true || $user->isSuperAdmin==true',
				'expression' => 'HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)["id"=>"custom","action"=>(object)["id"=>"admin"]])',
		),
		array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->redirect(array('list'));
	}

	public function actionList($id = '')
	{
		$this->pageTitle = 'My Collections';
		$user = HUB::getUserByUsername(Yii::app()->user->username);
		$collections = HubCollection::getActiveUserCollections($user, 999);
		$this->render('list', array('collections' => $collections, 'id' => $id));
	}

	public function actionView($id, $viewMode = 'standalone')
	{
		$model = HubCollection::getCollectionById($id);
		if ($model->creator_user_id != Yii::app()->user->id) {
			Notice::page('Invalid Access');
		}
		$this->pageTitle = $model->title;

		if ($viewMode == 'partial') {
			$this->renderPartial('view', array('model' => $model, 'viewMode' => $viewMode));
		} else {
			$this->render('view', array('model' => $model, 'viewMode' => $viewMode));
		}
	}

	public function actionAddItem2Collection($tableName, $refId)
	{
		//$this->layout = '//layouts/plain';
		//$this->layoutParams['hideFlashes'] = true;
		$status = 'fail';
		$data = null;

		$item = new CollectionItem();
		$item->table_name = $tableName;
		$item->ref_id = $refId;

		$model = new AddItem2CollectionForm();
		$this->performAjaxValidationCollection($model);
		if (isset($_POST['AddItem2CollectionForm'])) {
			try {
				$user = HUB::getUserByUsername(Yii::app()->user->username);
				$item = HubCollection::addCollectionItem($user, $tableName, $refId, $_POST['AddItem2CollectionForm']['collection'], $_POST['AddItem2CollectionForm']['collectionSub']);
				$msg = Yii::t('collection', "Successfully added '{itemTitle}' to collection '{collectionTitle}' \ '{collectionSubTitle}'", array('{itemTitle}' => $item->getItemObjectTitle(), '{collectionTitle}' => $item->collectionSub->collection->title, '{collectionSubTitle}' => $item->collectionSub->title));
				$status = 'success';
				$data = $item->toApi();
			} catch (Exception $e) {
				$msg = $e->getMessage();
			}

			$this->renderJSON(array('status' => $status, 'msg' => $msg, 'data' => $data));
		}

		$model->tableName = $tableName;
		$model->itemId = $refId;

		Yii::app()->clientScript->scriptMap = array('jquery.min.js' => false);
		$this->renderPartial('_addItem2Collection', array('tableName' => $tableName, 'refId' => $refId, 'item' => $item, 'model' => $model), false, true);
	}

	protected function performAjaxValidationCollection($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'collection-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetCollections()
	{
		$return = $meta = array();

		$user = HUB::getUserByUsername(Yii::app()->user->username);
		$collections = HubCollection::getActiveUserCollections($user, 999);

		foreach ($collections as $collection) {
			$return[] = $collection->toApi();
		}

		$this->outputJsonSuccess($return, $meta);
	}

	public function actionDeleteCollection($id)
	{
		$status = 'fail';
		$msg = '';
		$return = $meta = array();

		$user = HUB::getUserByUsername(Yii::app()->user->username);
		try {
			$collections = HubCollection::deleteCollection($user, $id);
			$status = 'success';
		} catch (Exception $e) {
			$msg = $e->getMessage();
		}
		$this->outputJson($return, $msg, $status, $meta);
	}
}
