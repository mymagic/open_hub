<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs = array(
	'Events' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event'), 'url' => array('/event/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Event'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>