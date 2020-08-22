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

class HubCpanel
{
	public function cpanelDefaultNavItems($controller, $forInterface)
	{
		switch ($forInterface) {
			case 'cpanelNavDashboard': {
					return array(
						array(
							'label' => Yii::t('app', 'Activity Feed'),
							'url' => '/cpanel/activity',
							'active' => $controller->activeMenuCpanel == 'activity' ? true : false,
							'visible' => true,
							'icon' => 'fa-rss'
						),
						array(
							'label' => Yii::t('app', 'My Organizations'),
							'url' => '/cpanel/organization',
							'active' => $controller->activeMenuCpanel == 'organization' ? true : false,
							'visible' => true,
							'icon' => 'fa-briefcase'
						),
						array(
							'label' => Yii::t('app', 'Settings'),
							'url' => '/cpanel/profile',
							'active' => $controller->activeMenuCpanel == 'profile' ? true : false,
							'visible' => false,
							'icon' => 'fa-cog'
						),
						array(
							'label' => Yii::t('app', 'Backend'),
							'url' => '/backend',
							'active' => $controller->activeMenuCpanel == 'backend' ? true : false,
							'visible' => Yii::app()->user->accessBackend,
							'icon' => 'fa-lock'
						),
					);
					break;
				}
			case 'cpanelNavSetting': {
					return array(
						array(
							'label' => Yii::t('app', 'Profile'),
							'url' => '/setting/profile',
							'url' => Yii::app()->createUrl('/cpanel/profile'),
							'active' => $controller->activeMenuCpanel == 'profile' ? true : false,
							'visible' => true,
							'icon' => 'fa-users'
						),
						array(
							'label' => Yii::t('app', 'Notification'),
							'url' => Yii::app()->createUrl('/cpanel/notification'),
							'active' => $controller->activeMenuCpanel == 'notification' ? true : false,
							'visible' => true,
							'icon' => 'fa-bell'
						),
						array(
							'label' => Yii::t('app', 'Download Account Information'),
							'url' => Yii::app()->createUrl('/cpanel/download'),
							'active' => $controller->activeMenuCpanel == 'download' ? true : false,
							'visible' => true,
							'icon' => 'fa-download'
						),
					);
					break;
				}
			case 'cpanelNavOrganization': {
					return array(
						array(
							'label' => Yii::t('app', 'Organization List'),
							'url' => Yii::app()->createUrl('/organization/list', array('realm' => 'cpanel')),
							'active' => $controller->activeMenuCpanel == 'list' ? true : false,
							'visible' => true,
							'icon' => 'fa-briefcase'
						),
						array(
							'label' => Yii::t('app', 'Create New'),
							'url' => Yii::app()->createUrl('/organization/create', array('realm' => 'cpanel')),
							'active' => $controller->activeMenuCpanel == 'create' ? true : false,
							'visible' => true,
							'icon' => 'fa-plus-circle'
						),
						array(
							'label' => Yii::t('app', 'Join Existing'),
							'url' => Yii::app()->createUrl('/organization/join', array('realm' => 'cpanel')),
							'active' => $controller->activeMenuCpanel == 'join' ? true : false,
							'visible' => true,
							'icon' => 'fa-user-plus'
						)
					);
					break;
				}
			case 'cpanelNavOrganizationInformation': {
					return array(
						array(
							'label' => Yii::t('app', 'Organization Info'),
							'url' => Yii::app()->createUrl('/organization/view', array('id' => $controller->customParse, 'realm' => 'cpanel')),
							'active' => $controller->activeMenuCpanel == 'information' ? true : false,
							'visible' => true,
							'icon' => 'fa-briefcase'
						),
						array(
							'label' => Yii::t('app', 'Team Members'),
							'url' => Yii::app()->createUrl('/organization/team', array('id' => $controller->customParse)),
							'active' => $controller->activeMenuCpanel == 'team' ? true : false,
							'visible' => true,
							'icon' => 'fa-users'
						),
						array(
							'label' => Yii::t('app', 'Products'),
							'url' => Yii::app()->createUrl('/product/list', array('id' => $controller->customParse, 'realm' => 'cpanel')),
							'active' => $controller->activeMenuCpanel == 'product' ? true : false,
							'visible' => true,
							'icon' => 'fa-th-large'
						)
					);
					break;
				}
		}
	}

	public function cpanelDefaultTitle($forInterface)
	{
		switch ($forInterface) {
			case 'cpanelNavDashboard': {
					return Yii::t('app', 'Dashboard');
					break;
				}
			case 'cpanelNavSetting': {
					return Yii::t('app', 'Settings');
					break;
				}
			case 'cpanelNavOrganization': {
					return Yii::t('app', 'Organization');
					break;
				}
			case 'cpanelNavOrganizationInformation': {
					return Yii::t('app', 'Organization');
					break;
				}
		}
	}

	public function cpanelNavItems($controller, $forInterface)
	{
		$nav = self::cpanelDefaultNavItems($controller, $controller->cpanelMenuInterface);
		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getNavItems')) {
				$nav = array_merge($nav, (array) Yii::app()->getModule($moduleKey)->getNavItems($controller, $controller->cpanelMenuInterface));
			}
		}
		switch ($forInterface) {
			case 'default': {
					$nav = array(
						array(
							'label' => self::cpanelDefaultTitle($controller->cpanelMenuInterface),
							'items' => $nav
						),
					);
					break;
				}
			case 'company-information': {
					$organization = Organization::model()->findByPk($controller->customParse);
					$orgName = $organization->title;
					$nav = array(
						array(
							'label' => $orgName,
							'items' => $nav
						),
					);
					break;
				}
			default: {
					break;
				}
		}

		return $nav;
	}
}
