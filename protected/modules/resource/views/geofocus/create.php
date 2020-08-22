<?php
/* @var $this ResourceGeofocusController */
/* @var $model ResourceGeofocus */

$this->breadcrumbs = array(
	'Resource Geofocuses' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ResourceGeofocus'), 'url' => array('//resource/geofocus/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Resource Geofocus'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>