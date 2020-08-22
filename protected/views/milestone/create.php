<?php
/* @var $this MilestoneController */
/* @var $model Milestone */

$this->breadcrumbs = array(
	'Milestones' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage All Milestone'), 'url' => array('/milestone/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Manage Revenue Milestone'), 'url' => array('/milestone/adminRevenue'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'adminRevenue')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Milestone'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>