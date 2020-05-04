<?php
/* @var $this Form2IntakeController */
/* @var $model Form2Intake */

$this->breadcrumbs = array(
	'Form2 Intakes' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Form2Intake'), 'url' => array('/f7/form2Intake/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Form2 Intake'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>