<?php

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Resources'), 'url' => array('/resource/resource/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Create Resource'), 'url' => array('/resource/resource/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'create'], 'module' => (object)['id' => 'resource']])
	),

	array(
		'label' => Yii::t('app', 'Manage Award'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'award'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Manage Funding'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'fund'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Manage Legislation'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'legislation'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Manage Media'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'media'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Manage Program'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'program'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Manage Space'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'space'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
	array(
		'label' => Yii::t('app', 'Manage Others'), 'url' => array('/resource/resource/admin', 'Resource[typefor]' => 'other'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'resource', 'action' => (object)['id' => 'admin'], 'module' => (object)['id' => 'resource']])
	),
);
