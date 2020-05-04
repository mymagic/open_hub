<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs = array(
	'Admins' => array('index'),
	'Create',
);

$this->menu = array(
	array(
		'label' => Yii::t('backend', 'Manage Admin'), 'url' => Yii::app()->createUrl('admin/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('backend', 'Create Admin'), 'url' => Yii::app()->createUrl('admin/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Admin'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>