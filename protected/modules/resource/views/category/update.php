<?php
/* @var $this ResourceCategoryController */
/* @var $model ResourceCategory */

$this->breadcrumbs = array(
	'Resource Categories' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ResourceCategory'), 'url' => array('//resource/category/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create ResourceCategory'), 'url' => array('//resource/category/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'View ResourceCategory'), 'url' => array('//resource/category/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Resource Category'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>