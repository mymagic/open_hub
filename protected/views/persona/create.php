<?php
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs = array(
	'Personas' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Persona'), 'url' => array('/persona/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Persona'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>