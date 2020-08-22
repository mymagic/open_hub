<?php
/* @var $this RequestController */
/* @var $model Request */

$this->breadcrumbs = array(
	'Requests' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Request'), 'url' => array('/request/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Request'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>