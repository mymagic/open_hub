<?php
/* @var $this SampleController */
/* @var $model Sample */

$this->breadcrumbs = array(
	'Samples' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Sample'), 'url' => array('/sample/sample/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Sample'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>