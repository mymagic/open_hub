<?php

class ResourceModule extends WebModule
{
	public $emailTeam;
	public $defaultController = 'frontend';
	private $_assetsUrl;

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
			'resource.models.*',
			'resource.components.*',
		));
	}

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null) {
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('resource.assets'));
		}

		return $this->_assetsUrl;
	}

	//
	// user
	public function getUserActFeed($user, $year)
	{
		return null;
	}

	//
	// organization
	public function getOrganizationActFeed($organization, $year)
	{
		// todo: check timezone issue
		$timestampStart = mktime(0, 0, 0, 1, 1, $year);
		$timestampEnd = mktime(0, 0, 0, 1, 1, $year + 1);
		$now = HUB::now();

		// find resources
		$sql = sprintf('SELECT r.* FROM resource as r
			INNER JOIN 	resource2organization as r2o ON r2o.resource_id=r.id
			WHERE r2o.organization_id=%s AND r.date_added >=%s AND r.date_added < %s AND
            (r.is_active = 1)', $organization->id, $timestampStart, $timestampEnd);
		//echo $sql;exit;

		$resources = Resource::model()->findAllBySql($sql);
		if (!empty($resources)) {
			foreach ($resources as $resource) {
				$msg = Yii::t('idea', "{organizationTitle} created a resource titled '{resourceTitle}' under {resourceType}.", array('{organizationTitle}' => $organization->title, '{resourceTitle}' => $resource->title, '{resourceType}' => $resource->renderTypeFor()));

				$return[] = array('service' => 'resource', 'timestamp' => $resource->date_added, 'date' => date('r', $resource->date_added), 'msg' => $msg, 'actionLabel' => 'View', 'actionUrl' => Yii::app()->createAbsoluteUrl('/resource/frontend/view', array('id' => $resource->id)));
			}
		}

		return $return;
	}

	public function getNavItems($controller, $forInterface)
	{
		switch ($forInterface) {
			case 'backendNavService': {
					return array(
						array(
							'label' => Yii::t('backend', 'Resource Directory'), 'url' => '#',
							// 'visible' => Yii::app()->user->getState('accessBackend') == true,
							'visible' => Yii::app()->user->getState('accessBackend') == true && (
								HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'overview'], 'module' => (object)['id' => 'resource']]) ||
								HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']]) ||
								HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'category', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']]) ||
								HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'geofocus', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
							),
							'active' => $controller->activeMenuMain == 'resource' ? true : false,
							'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
							'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
							'items' => array(
								array(
									'label' => Yii::t('app', 'Overview'), 'url' => array('/resource/backend/overview'),
									// 'visible' => Yii::app()->user->getState('accessBackend') == true,
									'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'overview'], 'module' => (object)['id' => 'resource']])
								),
								array(
									'label' => Yii::t('app', 'Resources'), 'url' => array('/resource/resource/admin'),
									// 'visible' => Yii::app()->user->getState('accessBackend') == true,
									'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
								),
								array(
									'label' => Yii::t('app', 'Categories'), 'url' => array('/resource/category/admin'),
									// 'visible' => Yii::app()->user->getState('accessBackend') == true,
									'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'category', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
								),
								array(
									'label' => Yii::t('app', 'Geo Focus'), 'url' => array('/resource/geofocus/admin'),
									// 'visible' => Yii::app()->user->getState('accessBackend') == true,
									'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'geofocus', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
								),
							),
						),
					);
					break;
				}
			case 'cpanelNavOrganizationInformation': {
					return array(
						array(
							'label' => Yii::t('app', 'Resources'),
							'url' => Yii::app()->createUrl('/resource/resource/list?organization_id=' . $controller->customParse . '&realm=cpanel'),
							'active' => $controller->activeMenuCpanel == 'resource' ? true : false,
							'visible' => true,
							'icon' => 'fa-file'
						)
					);
					break;
				}
		}
	}

	public function getAsService($interface)
	{
		$btn = '';
		// interface type ex: idea, resource, mentor, activate, atas, sea
		switch ($interface) {
			case 'resource': {
					$btn = array(
						array(
							'title' => 'Explore Resources',
							'url' => Yii::app()->createUrl('/resource')
						)
					);
					break;
				}
		}

		return $btn;
	}

	public function getBackendAdvanceSearch($controller, $searchFormModel)
	{
		$searchModel = new Resource('search');
		$result['resource'] = $searchModel->searchAdvance($searchFormModel->keyword);

		return array(
			'resource' => array(
				'tabLabel' => Yii::t('backend', 'Resource'),
				'itemViewPath' => 'application.modules.resource.views.backend._view-resource-advanceSearch',
				'result' => $result['resource'],
			),
		);
	}

	public function doOrganizationsMerge($source, $target)
	{
		$transaction = Yii::app()->db->beginTransaction();

		// process resource2organization
		$sql = sprintf('UPDATE IGNORE resource2organization SET organization_id=%s WHERE organization_id=%s', $target->id, $source->id);
		Yii::app()->db->createCommand($sql)->execute();
		$sql = sprintf('DELETE FROM resource2organization WHERE organization_id=%s', $source->id);
		Yii::app()->db->createCommand($sql)->execute();

		// process resource2organization_funding
		$sql = sprintf('UPDATE IGNORE resource2organization_funding SET organization_funding_id=%s WHERE organization_funding_id=%s', $target->id, $source->id);
		Yii::app()->db->createCommand($sql)->execute();
		$sql = sprintf('DELETE FROM resource2organization_funding WHERE organization_funding_id=%s', $source->id);
		Yii::app()->db->createCommand($sql)->execute();

		$transaction->commit();

		return array($source, $target);
	}
}
