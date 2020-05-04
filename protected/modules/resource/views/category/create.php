<?php
/* @var $this ResourceCategoryController */
/* @var $model ResourceCategory */

$this->breadcrumbs = array(
	'Resource Categories' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ResourceCategory'), 'url' => array('//resource/category/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Resource Category'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>