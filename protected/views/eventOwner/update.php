<?php
/* @var $this EventOwnerController */
/* @var $model EventOwner */

$this->breadcrumbs = array(
	'Event Owners' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage EventOwner'), 'url' => array('/eventOwner/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create EventOwner'), 'url' => array('/eventOwner/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View EventOwner'), 'url' => array('/eventOwner/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState("rolesAssigned"), Yii::app()->controller, 'view')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Event Owner'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>