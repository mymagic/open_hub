<?php
/* @var $this SdgController */
/* @var $model Sdg */

$this->breadcrumbs = array(
	'Sdgs' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Sdg'), 'url' => array('/sdg/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Sdg'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>