<?php
/* @var $this StartupStageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Startup Stages',
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage StartupStage'), 'url' => array('/startupStage/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create StartupStage'), 'url' => array('/startupStage/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Startup Stages'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
