<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs = array(
	'Cities' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage City'), 'url' => array('/city/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create City'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>