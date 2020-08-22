<?php
/* @var $this IndividualController */
/* @var $model Individual */

$this->breadcrumbs = array(
	'Individuals' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Individual'), 'url' => array('/individual/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Individual'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>