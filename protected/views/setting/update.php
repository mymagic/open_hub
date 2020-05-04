<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs = array(
	'Settings' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('app', 'Update'),
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
	array(
		'label' => Yii::t('app', 'Update Setting'), 'url' => array('update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'View Setting'), 'url' => array('view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
	array(
		'label' => Yii::t('app', 'Delete Setting'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>

<h1><?php echo Yii::t('app', sprintf('Update %s', 'Setting')); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>