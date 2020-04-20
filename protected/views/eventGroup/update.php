<?php
/* @var $this EventGroupController */
/* @var $model EventGroup */

$this->breadcrumbs = array(
	'Event Groups' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage EventGroup'), 'url' => array('/eventGroup/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create EventGroup'), 'url' => array('/eventGroup/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View EventGroup'), 'url' => array('/eventGroup/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'view')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Event Group'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>