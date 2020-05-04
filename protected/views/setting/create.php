<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs = array(
	'Settings' => array('index'),
	'Create',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Setting Panel'), 'url' => array('panel'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'panel')
	),
	array(
		'label' => Yii::t('app', 'Manage Setting'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Setting'), 'url' => array('create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('app', sprintf('Create %s', 'Setting')); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>