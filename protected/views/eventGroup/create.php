<?php
/* @var $this EventGroupController */
/* @var $model EventGroup */

$this->breadcrumbs = array(
	'Event Groups' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Group'), 'url' => array('/eventGroup/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Event Group'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>