<?php
/* @var $this Form2IntakeController */
/* @var $model Form2Intake */

$this->breadcrumbs = array(
	'Form2 Intakes' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Form2Intake'), 'url' => array('/f7/form2Intake/admin'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Form2Intake'), 'url' => array('/f7/form2Intake/create'), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View Form2Intake'), 'url' => array('/f7/form2Intake/view', 'id' => $model->id), 'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Form2 Intake'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>