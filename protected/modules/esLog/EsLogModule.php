<?php

class EsLogModule extends WebModule
{
	public $defaultController = 'backend';
	private $_assetsUrl;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$this->setComponents(array(
			'request' => array(
				'class' => 'HttpRequest',
				'enableCsrfValidation' => false,
			)
		));

		// import the module-level models and components
		$this->setImport(array(
			'esLog.models.*',
			'esLog.components.*',
		));
	}

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('esLog.assets'));
		}

		return $this->_assetsUrl;
	}

	public function getDashboardViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['esLog'][] = array(
					'key' => 'esLog',
					'title' => 'Log',
					'viewPath' => 'modules.esLog.views.backend._view-dashboard-esLog'
				);
			}
		}

		return $tabs;
	}

	public function getOrganizationViewTabs($model, $realm = 'backend')
	{
		$tabs = array();
		if ($realm == 'backend') {
			if (Yii::app()->user->accessBackend) {
				$tabs['esLog'][] = array(
					'key' => 'esLog',
					'title' => 'Log',
					'viewPath' => 'modules.esLog.views.backend._view-organization-esLog'
				);
			}
		} elseif ($realm == 'cpanel') {
			$tabs['esLog'][] = array(
				'key' => 'esLog',
				'title' => 'Log',
				'viewPath' => 'modules.esLog.views.cpanel._view-organization-esLog'
			);
		}

		return $tabs;
	}

	public function getOrganizationActions($model, $realm = 'backend')
	{
		return null;
	}

	public function getUserActFeed($user, $year)
	{
		return null;
	}

	public function getOrganizationActFeed($organization, $year)
	{
		return null;
	}
}
