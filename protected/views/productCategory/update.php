<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs = array(
	'Product Categories' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage ProductCategory'), 'url' => array('/productCategory/admin')),
	array('label' => Yii::t('app', 'Create ProductCategory'), 'url' => array('/productCategory/create')),
	array('label' => Yii::t('app', 'View ProductCategory'), 'url' => array('/productCategory/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Product Category'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>