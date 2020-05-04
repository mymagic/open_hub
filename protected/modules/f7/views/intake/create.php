<?php
/* @var $this IntakeController */
/* @var $model Intake */

$this->breadcrumbs = array(
	'Intakes' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Intake'), 'url' => array('/f7/intake/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Intake'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>