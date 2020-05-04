<?php
/* @var $this MilestoneController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Milestones',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Milestone'), 'url' => array('/milestone/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Milestone'), 'url' => array('/milestone/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Milestones'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
