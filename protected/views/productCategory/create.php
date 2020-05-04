<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs = array(
	'Product Categories' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ProductCategory'), 'url' => array('/productCategory/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Product Category'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>