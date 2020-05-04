<?php

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Organization'), 'url' => Yii::app()->createUrl('organization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'admin']])
	),
	array(
		'label' => Yii::t('app', 'Create Organization'), 'url' => Yii::app()->createUrl('organization/create'),
		// 'visible' => Yii::app()->user->isAdmin,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'craete']])
	),
	array(
		'label' => Yii::t('app', 'Merge Organizations'), 'url' => Yii::app()->createUrl('organization/merge'),
		// 'visible' => Yii::app()->user->isAdmin,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'merge']])
	),
	array(
		'label' => Yii::t('app', 'View Organization'), 'url' => Yii::app()->createUrl('organization/view', ['id' => $organization->id]),
		// 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'view')
	),
	array(
		'label' => Yii::t('app', 'Update Organization'), 'url' => Yii::app()->createUrl('organization/update', ['id' => $organization->id]),
		// 'visible' => Yii::app()->user->isAdmin,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'update']])
	),
	array(
		'label' => sprintf('%s <span class="badge pull-right">%s</span>', Yii::t('app', 'Manage Products'), count($organization->products)), 'type' => 'html', 'url' => Yii::app()->createUrl('product/adminByOrganization', ['organization_id' => $organization->id]),
		// 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)['id'=>'product','action'=>(object)['id'=>'adminByOrganization']])
	),
	array(
		'label' => Yii::t('app', 'Create Product'), 'url' => Yii::app()->createUrl('product/create', ['organization_id' => $organization->id]),
		// 'visible' => Yii::app()->user->isAdmin,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'product', 'action' => (object)['id' => 'create']])
	),
	array(
		'label' => sprintf('%s <span class="badge pull-right">%s</span>', Yii::t('app', 'Manage Resources'), count($organization->resources)), 'type' => 'html', 'url' => Yii::app()->createUrl('resource/resource/adminByOrganization', ['organization_id' => $organization->id]),
		// 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)['id'=>'resource','action'=>(object)['id'=>'adminByOrganization'] ,'module'=>(object)['id'=>'resource']])
	),
	array(
		'label' => Yii::t('app', 'Create Resource'), 'url' => Yii::app()->createUrl('resource/resource/create', ['organization_id' => $organization->id]),
		// 'visible' => Yii::app()->user->isAdmin,
		// ResourceController allowed create to be accessed by any user logged in the system
		// 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), (object)['id'=>'resource','action'=>(object)['id'=>'create'] ,'module'=>(object)['id'=>'resource']])
	),
	//array('label'=>Yii::t('app','Update Product'), 'url'=>array('/product/update', 'organization_id'=>$organization->id, 'id'=>$product->id)),
);
