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

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends BaseController
{
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	public $menuMain = array();
	public $menuUser = array();
	public $menuSub = array();
	public $menuCategory = array();
	public $menuSide = array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 *            be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 *            for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	public $activeMenuMain = '';
	public $activeMenuSub = '';
	public $activeMenuCpanel = '';
	public $activeSubMenuCpanel = '';
	public $cpanelMenuInterface = '';
	public $magicConnect = null;
	public $mixPanel = null;

	public function init()
	{
		parent::init();

		Yii::app()->session['accessBackend'] = false;
		Yii::app()->session['accessCpanel'] = false;

		if (empty($this->magicConnect)) {
			$httpOrHttps = Yii::app()->getRequest()->isSecureConnection ? 'https:' : 'http:';
			$this->magicConnect = new MyMagic\Connect\Client();
			$this->magicConnect->verifySsl = false;
			$this->magicConnect->setConnectUrl($httpOrHttps . Yii::app()->params['connectUrl']);
		}

		if (empty($this->mixPanel) && Yii::app()->params['enableMixPanel']) {
			$this->mixPanel = Mixpanel::getInstance(Yii::app()->params['mixpanelToken']);
			if (!empty($this->user) && !empty(($this->user->username))) {
				$this->mixPanel->identify(Yii::app()->user->username);
			}
		}

		$this->layoutParams['bodyClass'] = 'gray-bg';
		$this->layoutParams['hideFlashes'] = false;

		if (Yii::app()->params['environment'] == 'staging') {
			// Notice::flash('This is a staging environment for testing purposes only. Data you inserted here is not persistent!', Notice_WARNING);
			Notice::flash(Yii::t('notice', 'This is a staging environment for testing purposes only. Data you inserted here is not persistent!'), Notice_WARNING);
		}

		if (Yii::app()->params['environment'] == 'development') {
			Notice::flash('This is a development environment for developer use only.', Notice_WARNING);
		}
	}

	protected function initBackendMenu()
	{
		$navItems['service'] = $navItems['dev'] = array();

		$modules = YeeModule::getActiveParsableModules();
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getNavItems')) {
				$navItems['service'] = CMap::mergeArray($navItems['service'], Yii::app()->getModule($moduleKey)->getNavItems($this, 'backendNavService'));
			}
			if (method_exists(Yii::app()->getModule($moduleKey), 'getNavItems')) {
				$navItems['dev'] = CMap::mergeArray($navItems['dev'], Yii::app()->getModule($moduleKey)->getNavItems($this, 'backendNavDev'));
			}
		}

		$navItems = array(
			array(
				'label' => Yii::t('app', 'User') . ' <b class="caret"></b>', 'url' => '#',
				'visible' => Yii::app()->user->getState('accessBackend') == true &&
					!HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'ecosystem'], 'checkAccess' => true]) && (
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'member', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'admin', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'connect']])
				),
				'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
				'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
				'items' => array(
					array(
						'label' => Yii::t('app', 'Member'), 'url' => Yii::app()->createUrl('member/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') || Yii::app()->user->getState('isMemberManager')
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'member', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Admin'), 'url' => Yii::app()->createUrl('admin/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') || Yii::app()->user->getState('isAdminManager')
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'admin', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Connect'), 'url' => Yii::app()->createUrl('backend/connect'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') || Yii::app()->user->getState('isDeveloper')
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'connect']])
					)
				),
			),
			array(
				'label' => Yii::t('backend', 'Commons') . ' <b class="caret"></b>', 'url' => '#',
				'visible' => Yii::app()->user->getState('accessBackend') == true && (
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'overview']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organizationFunding', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organizationRevenue', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organizationStatus', 'action' => (object)['id' => 'admin']])
				),
				'active' => $this->activeMenuMain == 'common' ? true : false,
				'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
				'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
				'items' => array(
					array(
						'label' => Yii::t('backend', 'Organization'), 'url' => '#',
						'visible' => Yii::app()->user->getState('accessBackend') == true,
						'active' => $this->activeMenuMain == 'organization' ? true : false,
						'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => array(
							array(
								'label' => Yii::t('app', 'Overview'), 'url' => Yii::app()->createUrl('organization/overview'),
								'visible' => Yii::app()->user->getState('accessBackend') == true
							),
							array(
								'label' => Yii::t('app', 'Manage All'), 'url' => Yii::app()->createUrl('organization/admin'),
								'visible' => Yii::app()->user->getState('accessBackend') == true
							),
							array(
								'label' => Yii::t('app', 'Manage Funding'), 'url' => Yii::app()->createUrl('organizationFunding/admin'),
								// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true || Yii::app()->user->getState('isSensitiveDataAdmin') == true
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organizationFunding', 'action' => (object)['id' => 'admin']]) || Yii::app()->user->getState('accessSensitiveData') == true
							),
							//array('label' => Yii::t('app', 'Manage Revenue'), 'url' => array('/milestone/adminRevenue'), 'visible' => Yii::app()->user->getState('accessBackend') == true && !Yii::app()->user->getState('isEcosystem')),
							array(
								'label' => Yii::t('app', 'Manage Revenue'), 'url' => Yii::app()->createUrl('organizationRevenue/admin'),
								// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true || Yii::app()->user->getState('isSensitiveDataAdmin') == true
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organizationRevenue', 'action' => (object)['id' => 'admin']]) || Yii::app()->user->getState('accessSensitiveData') == true
							),
							array(
								'label' => Yii::t('app', 'Manage Status'), 'url' => Yii::app()->createUrl('organizationStatus/admin'),
								// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true || Yii::app()->user->getState('isSensitiveDataAdmin') == true
								'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organizationStatus', 'action' => (object)['id' => 'admin']]) || Yii::app()->user->getState('accessSensitiveData') == true
							),
						),
					),
					// array('label'=>Yii::t('app', 'Charge'), 'url'=>array('/charge/admin'), 'visible'=>Yii::app()->user->getState('accessBackend')==true),
					array(
						'label' => Yii::t('app', 'Individual'), 'url' => array('/individual/admin'),
						// 'visible' => Yii::app()->user->getState('accessBackend') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'individual', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('backend', 'Event'), 'url' => '#',
						// 'visible' => Yii::app()->user->getState('accessBackend') == true,
						'visible' => Yii::app()->user->getState('accessBackend') == true && (
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'overview']]) ||
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'eventGroup', 'action' => (object)['id' => 'admin']]) ||
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'admin']]) ||
							HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'eventRegistration', 'action' => (object)['id' => 'admin']])
						),
						'active' => $this->activeMenuMain == 'educ8' ? true : false,
						'itemOptions' => array('class' => 'dropdown-submenu'), 'submenuOptions' => array('class' => 'dropdown-menu'),
						'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
						'items' => array(
							array(
								'label' => Yii::t('app', 'Overview'), 'url' => array('/event/overview'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true
								'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'overview']])
							),
							array(
								'label' => Yii::t('app', 'Event Group'), 'url' => array('/eventGroup/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true
								'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'eventGroup', 'action' => (object)['id' => 'admin']])
							),
							array(
								'label' => Yii::t('app', 'Event'), 'url' => array('/event/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true
								'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'event', 'action' => (object)['id' => 'admin']])
							),
							/*array(
								'label' => Yii::t('app', 'Event Registration'), 'url' => array('/eventRegistration/admin'),
								// 'visible' => Yii::app()->user->getState('accessBackend') == true
								'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'eventRegistration', 'action' => (object)['id' => 'admin']])
							),*/
						),
					),
				),
			),
			array(
				'label' => Yii::t('backend', 'Services') . ' <b class="caret"></b>', 'url' => '#',
				// 'visible' => Yii::app()->user->getState('accessBackend') == true && !Yii::app()->user->getState('isEcosystem'),
				'visible' => Yii::app()->user->getState('accessBackend') == true && !HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'ecosystem'], 'checkAccess' => true]),
				'active' => $this->activeMenuMain == 'service' ? true : false,
				'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
				'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
				'items' => $navItems['service'],
			),

			array(
				'label' => Yii::t('backend', 'Master Data') . ' <b class="caret"></b>', 'url' => '#',
				// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true,
				'visible' => (
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'productCategory', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'cluster', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'persona', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'industry', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'impact', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'sdg', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'startupStage', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'legalform', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'country', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'state', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'city', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'service', 'action' => (object)['id' => 'admin']])
				),
				'active' => $this->activeMenuMain == 'masterData' ? true : false,
				'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
				'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
				'items' => array(
					array(
						'label' => Yii::t('app', 'Product Category'), 'url' => array('/productCategory/admin'),
						//'visible' => Yii::app()->user->getState('isSuperAdmin') == true,
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'productCategory', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Cluster'), 'url' => array('/cluster/admin'),
						//'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'cluster', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Persona'), 'url' => array('/persona/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'persona', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Industry'), 'url' => array('/industry/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'industry', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Impact'), 'url' => array('/impact/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'impact', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'SDG'), 'url' => array('/sdg/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'sdg', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Startup Stages'), 'url' => array('/startupStage/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'startupStage', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Legal Form'), 'url' => array('/legalform/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'legalform', 'action' => (object)['id' => 'admin']])
					),

					array(
						'label' => Yii::t('app', 'Country'), 'url' => array('/country/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'country', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'State'), 'url' => array('/state/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'state', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'City'), 'url' => array('/city/admin'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') == true
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'city', 'action' => (object)['id' => 'admin']])
					),

					// developer only
					array(
						'label' => Yii::t('app', 'Service') . ' <span class="label label-warning">dev</span>', 'url' => array('/service/admin'),
						// 'visible' => Yii::app()->user->getState('isDeveloper'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'service', 'action' => (object)['id' => 'admin']])
					),
				),
			),
			array(
				'label' => Yii::t('app', 'Site') . ' <b class="caret"></b>', 'url' => '#',
				// 'visible' => Yii::app()->user->getState('accessBackend') == true && (Yii::app()->user->isSuperAdmin || Yii::app()->user->isContentManager),
				'visible' => Yii::app()->user->getState('accessBackend') == true && (
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'embed', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'lingual', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'setting', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'registry', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'request', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'seolytic', 'action' => (object)['id' => 'admin']]) ||
					HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'default', 'action' => (object)['id' => 'index'], 'module' => (object)['id' => 'sys']])
				),
				'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
				'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
				'items' => array(
					//array('label'=>Yii::t('app', 'Page'), 'url'=>array('/page/admin'),),
					array(
						'label' => Yii::t('app', 'Embed'), 'url' => array('/embed/admin'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'embed', 'action' => (object)['id' => 'admin']])
					),
					//array('label'=>Yii::t('app', 'Faq'), 'url'=>array('/faq/admin'),),
					array(
						'label' => Yii::t('app', 'Lingual'), 'url' => array('/lingual/admin'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'lingual', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Setting'), 'url' => array('/setting/admin'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'setting', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Registry'), 'url' => array('/registry/admin'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'registry', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'Request'), 'url' => array('/request/admin'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'request', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('app', 'SEO'), 'url' => array('/seolytic/admin'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'seolytic', 'action' => (object)['id' => 'admin']])
					),
					array(
						'label' => Yii::t('backend', 'System'), 'url' => array('/sys/default'),
						// 'visible' => Yii::app()->user->getState('isSuperAdmin') && Yii::app()->hasModule('sys'),
						'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'default', 'action' => (object)['id' => 'index'], 'module' => (object)['id' => 'sys']]) && Yii::app()->hasModule('sys')
					),
				),
			),
			array(
				'label' => '<span class="label label-warning">' . Yii::t('backend', 'Dev') . '</span> <b class="caret"></b>', 'url' => '#',
				// 'visible' => Yii::app()->user->getState('accessBackend') == true && Yii::app()->user->getState('isDeveloper'),
				'visible' => Yii::app()->user->getState('accessBackend') == true && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']]),
				'active' => $this->activeMenuMain == 'dev' ? true : false,
				'itemOptions' => array('class' => 'dropdown'), 'submenuOptions' => array('class' => 'dropdown-menu'),
				'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
				'items' => $navItems['dev'],
			),
		);

		$this->menuMain = $navItems;

		//
		// user menu
		// my account
		$navUserItems[] = array('label' => Yii::t('app', 'My Account'), 'url' => array('/backend/me'), 'visible' => Yii::app()->user->getState('accessBackend') == true, 'items');
		foreach ($modules as $moduleKey => $moduleParams) {
			if (method_exists(Yii::app()->getModule($moduleKey), 'getNavItems')) {
				$moduleNavs = Yii::app()->getModule($moduleKey)->getNavItems($this, 'backendNavUserService');

				foreach ($moduleNavs as $moduleNav) {
					$navUserItems[] = $moduleNav;
				}
			}
		}
		// logout
		$navUserItems[] =
			array('label' => Yii::t('app', 'Logout'), 'url' => array('/backend/logout'), 'linkOptions' => array('title' => Yii::app()->user->username, 'data-toggle' => 'tooltip', 'data-placement' => 'bottom'), 'visible' => !Yii::app()->user->isGuest);

		$this->menuUser = $navUserItems;
	}

	protected function initFrontendMenu()
	{
		// for side menu
		/*$this->menuSide=array(
			'aboutus'=>array('label'=>Yii::t('app','About Us'), 'url'=>array('site/aboutus')),
			'bulletin'=>array('label'=>Yii::t('app','Bulletin'), 'url'=>array('bulletin/index')),
			'faq'=>array('label'=>Yii::t('app','FAQ'), 'url'=>array('faq/index')),
			'tnc'=>array('label'=>Yii::t('app','Terms and Conditions'), 'url'=>array('site/tnc')),
			'copyright'=>array('label'=>Yii::t('app','Copyright'), 'url'=>array('site/copyright')),
			'link'=>array('label'=>Yii::t('app','Friendly Link'), 'url'=>array('site/link')),
			'contact'=>array('label'=>Yii::t('app','Contact Us'), 'url'=>array('site/contact')),
		);*/

		//
		// user menu
		// my account
		if (!Yii::app()->user->isGuest) {
			// cpanel dashboard
			$navUserItems[] = array('label' => Yii::t('app', 'Dashboard'), 'url' => array('/cpanel/index'), 'visible' => true, 'items');
			// profile
			$navUserItems[] = array('label' => Yii::t('app', 'Settings'), 'url' => array('/cpanel/profile'), 'visible' => true, 'items');
			// logout
			$navUserItems[] =
				array('label' => Yii::t('app', 'Logout'), 'url' => array('/site/logout'), 'linkOptions' => array('title' => Yii::app()->user->username, 'data-toggle' => 'tooltip', 'data-placement' => 'bottom'), 'visible' => !Yii::app()->user->isGuest);

			$this->menuUser = $navUserItems;
		}
	}

	protected function initCpanelMenu()
	{
		/*$this->menuSide=array(
			//array('label'=>'<i class="fa fa-fw fa-dashboard"></i>&nbsp;'.Yii::t('app','Control Panel'), 'url'=>array('cpanel/index')),
			'profile'=>array('label'=>'<i class="fa fa-fw fa-user"></i>&nbsp;'.Yii::t('app','My Profile'), 'url'=>array('cpanel/profile')),
			'author'=>array('label'=>'<i class="fa fa-fw fa-pencil"></i>&nbsp;'.Yii::t('app','My Author'), 'url'=>array('cpanel/author')),
			'changePassword'=>array('label'=>'<i class="fa fa-fw fa-key"></i>&nbsp;'.Yii::t('app','Change Password'), 'url'=>array('profile/changePassword')),
		);

		if(isset(Yii::app()->user->accessBackend) && Yii::app()->user->accessBackend)
		{
			$this->menuSide['backend'] = array('label'=>'<i class="fa fa-fw fa-bug"></i>&nbsp;'.Yii::t('app','Backend'), 'url'=>array('backend/index'));
		}

		$this->menuSide['logout'] = array('label'=>'<i class="fa fa-fw fa-sign-out"></i>&nbsp;'.Yii::t('app','Logout'), 'url'=>array('site/logout'));*/
	}

	public function generateUrlGetUploadedFile($path, $absolute = false)
	{
		if ($path == '') {
			return '';
		}

		$parts = pathinfo($path);
		list($uploadDir, $params['dir']) = explode('/', $parts['dirname']);
		list($params['code'], $params['uid']) = explode('.', $parts['filename']);
		$params['format'] = $parts['extension'];
		if ($absolute) {
			return $this->createAbsoluteUrl('/api/getUploadedFile', $params);
		} else {
			return $this->createUrl('/api/getUploadedFile', $params);
		}
	}

	public function renderBreadcrumb($home2Icon = false)
	{
		echo $this->renderPartial('//site/_breadcrumb', array('home2Icon' => $home2Icon));
	}

	//
	// esLog
	// legacy purpose, use component instead
	public function esLog($msg, $context, $data, $username = '', $custom = array(), $dateLog = '')
	{
		return Yii::app()->esLog->log($msg, $context, $data, $username, $custom, $dateLog);
	}

	public function mixPanelTrack($action, $params)
	{
		if (!empty($this->mixPanel)) {
			$this->mixPanel->track($action, $params);
		}
	}

	public function beforeAction($action)
	{
		if (in_array($_SERVER['HTTP_ORIGIN'], Yii::app()->params->allowedDomains)) {
			header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			header('Access-Control-Allow-Credentials: true');
		}

		if (
			Yii::app()->getModule('interest')
			&& !Yii::app()->user->isGuest
			&& Yii::app()->db->schema->getTable('interest', true)
			&& Yii::app()->db->schema->getTable('interest_user2sdg', true)
			&& Yii::app()->db->schema->getTable('interest_user2cluster', true)
			&& Yii::app()->db->schema->getTable('interest_user2startup_stage', true)
		) {
			if (empty(Interest::model()->find('user_id=:userId', array(':userId' => Yii::app()->user->id)))) {
				if (
					!($action->controller->getId() === 'site' && $action->getId() === 'error') &&
					!($action->controller->getId() === 'site' && $action->getId() === 'logout') &&
					!($action->controller->getId() === 'welcome' && $action->getId() === 'index') &&
					!($action->controller->getId() === 'api' && $action->getId() === 'member') &&
					!($action->controller->getId() === 'welcome' && $action->getId() === 'skip') &&
					!($action->controller->getId() === 'v1')
				) {
					$this->redirect('/interest/welcome');
				}
			}
		}

		return parent::beforeAction($action);
	}

	public function piwikTrack($category, $action, $params)
	{
		/*foreach($params as $key=>$value)
		{
			$this->layoutParams['piwik']['events'][] = array('category'=>$category, 'action'=>$action, 'key'=>$key, 'value'=>$value);
		}*/
	}

	// todo: password protect the class
	public function outputJsonMessage($msg, $meta = array())
	{
		self::outputJson('', $msg, 'success', $meta);
	}

	public function outputJsonSuccess($data, $meta = array(), $msg = '')
	{
		self::outputJson($data, $msg, 'success', $meta);
	}

	public function outputJsonFail($msg, $meta = array())
	{
		$data = array();
		self::outputJson($data, $msg, 'fail', $meta);
	}

	public function outputJsonPipe($result)
	{
		self::outputJson($result['data'], $result['msg'], ($result['status'] == 'success' || $result['success'] == true) ? true : false, $result['meta']);
	}

	// status can be boolean or string of success|fail
	public function outputJson($data, $msg = '', $status = 'fail', $meta = array())
	{
		// try 1: last line not working
		//header('Access-Control-Allow-Origin: http:'.Yii::app()->params['masterUrl']);
		//header('Access-Control-Allow-Origin: https:'.Yii::app()->params['masterUrl']);
		//header('Access-Control-Allow-Origin: http:'.Yii::app()->params['baseUrl']);
		//header('Access-Control-Allow-Origin: https:'.Yii::app()->params['baseUrl']);

		// try 2: totally not working
		/*$httpOrigin = $_SERVER['HTTP_ORIGIN'];
		if (
			$httpOrigin == "http:".Yii::app()->params['masterUrl']  ||
			$httpOrigin == "https:".Yii::app()->params['masterUrl'] ||
			$httpOrigin == "http:".Yii::app()->params['baseUrl']  ||
			$httpOrigin == "https:".Yii::app()->params['baseUrl']  ||
		)
		{
			header("Access-Control-Allow-Origin: $httpOrigin");
		}*/

		if ($status === true) {
			$status = 'success';
		}
		if ($status === false) {
			$status = 'fail';
		}
		self::outputJsonRaw(array('status' => $status, 'meta' => $meta, 'msg' => $msg, 'data' => $data));
	}

	public function outputJsonRaw($data)
	{
		$this->layout = false;
		// todo: dangerous http origin, need to limit it
		header('Access-Control-Allow-Origin: *');
		header('Content-type: application/json');
		$this->renderJSON($data);
		Yii::app()->end();
	}

	protected function beforeRender($view)
	{
		/*$tmp = (parse_url(Yii::app()->request->hostInfo));
		if ($this->isFrontend && !empty(Yii::app()->params['backendDomain']) && strstr($tmp['host'], Yii::app()->params['backendDomain']) && Yii::app()->params['blockFrontendOnBackendDomain']) {
			header('HTTP/1.0 404 Not Found');
			Yii::app()->end();
		}*/

		$seolytic = HubSeolytic::getMatchingSeolytic(Yii::app()->request->url);
		if (!empty($seolytic)) {
			if (!empty($seolytic->getAttributeDataByLanguage($seolytic, 'title'))) {
				Yii::app()->clientScript->registerMetaTag($seolytic->getAttributeDataByLanguage($seolytic, 'title'), 'title', null, array(), 'title');
			}

			if (!empty($seolytic->getAttributeDataByLanguage($seolytic, 'description'))) {
				Yii::app()->clientScript->registerMetaTag($seolytic->getAttributeDataByLanguage($seolytic, 'description'), 'description', null, array(), 'description');

				Yii::app()->clientScript->registerMetaTag($seolytic->getAttributeDataByLanguage($seolytic, 'description'), null, null, array('property' => 'og:description'), 'og:description');
			}

			if (!empty($seolytic->css_header)) {
				Yii::app()->clientScript->registerCss(sprintf('seolytic-css-%s', $seolytic->id), $seolytic->css_header);
			}
			if (!empty($seolytic->js_header)) {
				Yii::app()->clientScript->registerScript(sprintf('seolytic-jsHeader-%s', $seolytic->id), $seolytic->js_header, CClientScript::POS_HEAD);
			}
			if (!empty($seolytic->js_footer)) {
				Yii::app()->clientScript->registerScript(sprintf('seolytic-jsFooter-%s', $seolytic->id), $seolytic->js_footer, CClientScript::POS_END);
			}
		}

		return true;
	}
}
