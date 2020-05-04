<?php
/* @var $this StartupStageController */
/* @var $model StartupStage */

$this->breadcrumbs = array(
	'Startup Stages' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage StartupStage'), 'url' => array('/startupStage/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Startup Stage'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>