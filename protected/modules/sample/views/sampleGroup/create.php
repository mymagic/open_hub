<?php
/* @var $this SampleGroupController */
/* @var $model SampleGroup */

$this->breadcrumbs = array(
	'Sample Groups' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage SampleGroup'), 'url' => array('/sample/sampleGroup/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Sample Group'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>