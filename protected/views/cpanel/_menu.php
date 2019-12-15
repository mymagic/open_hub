<?php
$organizationItems = null;
$manageItems = null;
$supportItems = null;
$accountItems = null;
$manageOrgItems = null;

if (!empty($organization) && !empty($organization->id)) {
	$organizationItems = array(
		// array('label'=>sprintf('%s', Yii::t('app', 'Change Company')), 'url'=>array('/organization/select'), 'active'=>($this->activeSubMenuCpanel=='select')?true:null),
		array('label' => sprintf('%s', Yii::t('app', 'View')), 'url' => array('/organization/view', 'id' => $organization->id, 'realm' => $realm), 'active' => ($this->activeSubMenuCpanel == 'view') ? true : null),
		array('label' => sprintf('%s', Yii::t('app', 'Update')), 'url' => array('/organization/update', 'id' => $organization->id, 'realm' => $realm), 'active' => ($this->activeSubMenuCpanel == 'update') ? true : null),
		array('label' => sprintf('%s', Yii::t('app', 'Manage Products')), 'url' => array('/product/adminByOrganization', 'organization_id' => $organization->id, 'realm' => $realm), 'active' => ($this->activeSubMenuCpanel == 'product-adminByOrganization') ? true : null),
		array('label' => sprintf('%s', Yii::t('app', 'Create Product')), 'url' => array('/product/create', 'organization_id' => $organization->id, 'realm' => $realm), 'active' => ($this->activeSubMenuCpanel == 'product-create') ? true : null),
		array('label' => sprintf('%s', Yii::t('app', 'Manage Resources')), 'url' => array('/resource/resource/adminByOrganization', 'organization_id' => $organization->id, 'realm' => $realm), 'active' => ($this->activeSubMenuCpanel == 'resource-adminByOrganization') ? true : null),
		array('label' => sprintf('%s', Yii::t('app', 'Create Resource')), 'url' => array('/resource/resource/create', 'organization_id' => $organization->id, 'realm' => $realm), 'active' => ($this->activeSubMenuCpanel == 'resource-create') ? true : null),
	);
}

$manageItems = array(
	array('label' => sprintf('%s', Yii::t('app', 'Wizard')), 'url' => array('/wizard'), 'active' => ($this->activeSubMenuCpanel == 'wizard')),
	array('label' => sprintf('%s', Yii::t('app', 'Services')), 'url' => array('/cpanel/services'), 'active' => ($this->activeSubMenuCpanel == 'services')),
	array('label' => sprintf('%s', Yii::t('app', 'Activity Feed')), 'url' => array('/cpanel/activityfeed'), 'active' => ($this->activeSubMenuCpanel == 'activityfeed')),

);

$supportItems = array(
	array('label' => sprintf('%s', Yii::t('app', 'Guideline')), 'url' => array('/cpanel/guidelines'), 'active' => ($this->activeSubMenuCpanel == 'guide'))
);

$manageOrgItems = array(
	array(
		'label' => sprintf('%s', $organization->title ?: Yii::t('app', 'Manage')), 'url' => array('/organization/select'),
		'submenuOptions' => array('class' => 'nav hidden nav-second-level new-dash-bg stay-open'),
		'active' => ($this->activeMenuCpanel == 'organization') ? true : null, 'items' => $organizationItems

	),
);

$accountItems = array(
	//array('label'=>sprintf('%s', Yii::t('app', 'ATAS')), 'url'=>('//atasbe.mymagic.my'),'linkOptions' => array('target'=>'_blank'),'active'=>($this->activeSubMenuCpanel=='atas')),
	//array('label'=>sprintf('%s', Yii::t('app', 'Billings & Payment')), 'url'=>array('/charge/list'),'active'=>($this->activeSubMenuCpanel=='charges')),
	array('label' => sprintf('%s', Yii::t('app', 'Profile')), 'url' => Yii::app()->params['connectUrl'] . '/profile', 'linkOptions' => array('target' => '_blank'), 'active' => ($this->activeSubMenuCpanel == 'profile')),
	array('label' => sprintf('%s', Yii::t('app', 'Settings')), 'url' => array('/cpanel/setting'), 'linkOptions' => array(), 'active' => ($this->activeSubMenuCpanel == 'setting')),
	array('label' => sprintf('%s', Yii::t('app', 'Backend')), 'url' => array('/backend'), 'linkOptions' => array('target' => '_blank'), 'visible' => Yii::app()->user->accessBackend),
	array('label' => sprintf('%s', Yii::t('app', 'Logout')), 'url' => array('/site/logout'), 'active' => ($this->activeSubMenuCpanel == 'logout')),
);

$this->menu = array(
	// array('label'=>sprintf('<i class="fa fa-home"></i> <span class="nav-label">%s</span>', 'MaGIC Central'), 'url'=>array('/site/index')),
	// array('label'=>sprintf('<i class="fa fa-dashboard"></i> <span class="nav-label">%s</span>', Yii::t('app', 'Control Panel')), 'url'=>array('/cpanel/index')),
	// organization
	array(
		'label' => sprintf('<i class="hidden-desk fa fa-th-large"></i> <span class="nav-label">%s</span>', 'Explore'), 'url' => array('/site/manage'), 'submenuOptions' => array('class' => 'nav nav-second-level new-dash-bg stay-open'),
		'linkOptions' => array('class' => 'uppr no-link'), 'itemOptions' => array('class' => 'less-pad'),
		'items' => $manageItems
	),
	array(
		'label' => sprintf('<i class="hidden-desk fa fa-info-circle"></i> <span class="nav-label">%s</span>', 'Support'), 'url' => array('/site/support'), 'submenuOptions' => array('class' => 'nav nav-second-level new-dash-bg stay-open'),
		'linkOptions' => array('class' => 'uppr no-link'), 'itemOptions' => array('class' => 'less-pad'),
		'items' => $supportItems
	),
	array(
		'label' => sprintf('<i class="hidden-desk fa fa-info-circle"></i> <span class="nav-label">%s</span>', 'Company'), 'url' => array('/site/support'), 'submenuOptions' => array('class' => 'nav nav-second-level new-dash-bg stay-open'),
		'linkOptions' => array('class' => 'uppr no-link'), 'itemOptions' => array('class' => 'less-pad'),
		'items' => $manageOrgItems
	),
	array(
		'label' => sprintf('<i class="hidden-desk fa fa-user"></i> <span class="nav-label">%s</span>', 'Account'), 'url' => array('/organization/profile'), 'submenuOptions' => array('class' => 'nav nav-second-level new-dash-bg stay-open'), 'active' => ($this->activeMenuCpanel == 'account') ? true : null,
		'linkOptions' => array('class' => 'uppr no-link'), 'itemOptions' => array('class' => 'less-pad'),
		'items' => $accountItems
	),



	// array('label'=>sprintf('<i class="fa fa-money"></i> <span class="nav-label">%s</span>', Yii::t('app', 'My Charges')), 'url'=>array('/charge/list')),
	// array('label'=>sprintf('<i class="fa fa-user"></i> <span class="nav-label">%s</span>', Yii::t('app', 'My Account')), 'url'=>Yii::app()->params['connectUrl'].'/profile', 'linkOptions' => array('target'=>'_blank')),
	/*array('label'=>sprintf('<i class="fa fa-user"></i> <span class="nav-label">%s</span>', Yii::t('app', 'Account')), 'url'=>'',
			'submenuOptions' => array('class'=>'nav nav-second-level'), 
			'active'=>($this->activeMenuCpanel=='account')?true:null,
			'linkOptions' => array(), 'itemOptions' => array('class'=>''),
			'items'=>array
			(
				array('label'=>sprintf('%s', Yii::t('default', 'View Account')), 'url'=>array('/profile/view')),
				//array('label'=>sprintf('%s', Yii::t('default', 'Update Profile')), 'url'=>array('/profile/update')),
				array('label'=>sprintf('%s', Yii::t('default', 'Change Password')), 'url'=>array('/profile/changePassword')),
			)
		),*/
	// array('label'=>sprintf('<i class="fa fa-sign-out"></i> <span class="nav-label">%s</span>', Yii::t('app', 'Logout')), 'url'=>array('/site/logout')),
);
