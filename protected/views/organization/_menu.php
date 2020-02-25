<?php

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Organization'), 'url' => array('/organization/admin')),
	array('label' => Yii::t('app', 'Create Organization'), 'url' => array('/organization/create'), 'visible' => Yii::app()->user->isAdmin),
	array('label' => Yii::t('app', 'Merge Organizations'), 'url' => array('/organization/merge'), 'visible' => Yii::app()->user->isAdmin),
	array('label' => Yii::t('app', 'View Organization'), 'url' => array('/organization/view', 'id' => $organization->id)),
	array('label' => Yii::t('app', 'Update Organization'), 'url' => array('/organization/update', 'id' => $organization->id), 'visible' => Yii::app()->user->isAdmin),
	array('label' => sprintf('%s <span class="badge pull-right">%s</span>', Yii::t('app', 'Manage Products'), count($organization->products)), 'type' => 'html', 'url' => array('/product/adminByOrganization', 'organization_id' => $organization->id)),
	array('label' => Yii::t('app', 'Create Product'), 'url' => array('/product/create', 'organization_id' => $organization->id), 'visible' => Yii::app()->user->isAdmin),
	array('label' => sprintf('%s <span class="badge pull-right">%s</span>', Yii::t('app', 'Manage Resources'), count($organization->resources)), 'type' => 'html', 'url' => array('/resource/resource/adminByOrganization', 'organization_id' => $organization->id)),
	array('label' => Yii::t('app', 'Create Resource'), 'url' => array('/resource/resource/create', 'organization_id' => $organization->id), 'visible' => Yii::app()->user->isAdmin),
	//array('label'=>Yii::t('app','Update Product'), 'url'=>array('/product/update', 'organization_id'=>$organization->id, 'id'=>$product->id)),
);
