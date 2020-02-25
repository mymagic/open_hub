<?php

class CommentModule extends WebModule
{
	public $defaultController = 'frontend';
	private $_assetsUrl;
	public $abc;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->setComponents(array(
			'request' => array(
			'class' => 'HttpRequest',
			'enableCsrfValidation' => false,
		),
		));

		// import the module-level models and components
		$this->setImport(array(
			'comment.models.*',
		));
	}

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('comment.assets'));
		}

		return $this->_assetsUrl;
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			if (Yii::app()->params['dev'] == true) {
				Yii::app()->assetManager->forceCopy = true;
			}

			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
		}
	}

	//
	// organization
	public function getOrganizationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['comment'][] = array(
					'key' => 'comment',
					'title' => 'Comment',
					'viewPath' => 'modules.comment.views.backend._view-organization-comment',
				);
			}
		}

		return $tabs;
	}

	public function getOrganizationActFeed($organization, $year)
	{
		return null;
	}

	public function getOrganizationActions($model, $realm = 'backend')
	{
		return null;
	}

	//
	// individual
	public function getIndividualViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['comment'][] = array(
					'key' => 'comment',
					'title' => 'Comment',
					'viewPath' => 'modules.comment.views.backend._view-individual-comment',
				);
			}
		}

		return $tabs;
	}

	public function getIndividualActFeed($individual, $year)
	{
		return null;
	}

	public function getIndividualActions($model, $realm = 'backend')
	{
		return null;
	}

	//
	// resource
	public function getResourceViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['comment'][] = array(
					'key' => 'comment',
					'title' => 'Comment',
					'viewPath' => 'modules.comment.views.backend._view-resource-comment',
				);
			}
		}

		return $tabs;
	}

	//
	// event
	public function getEventViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['comment'][] = array(
					'key' => 'comment',
					'title' => 'Comment',
					'viewPath' => 'modules.comment.views.backend._view-event-comment',
				);
			}
		}

		return $tabs;
	}

	public function doOrganizationsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		// process comment
		$sql = sprintf("UPDATE comment SET object_key='organization-%s' WHERE object_key='organization-%s'", $target->id, $source->id);
		Yii::app()->db->createCommand($sql)->execute();

		$transaction->commit();

		return array($source, $target);
	}

	public function doIndividualsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		// process comment
		$sql = sprintf("UPDATE comment SET object_key='individual-%s' WHERE object_key='individual-%s'", $target->id, $source->id);
		Yii::app()->db->createCommand($sql)->execute();

		$transaction->commit();

		return array($source, $target);
	}
}
