<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs = array(
	'Pages' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('app', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Page'), 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create Page'), 'url' => array('create')),
	array('label' => Yii::t('app', 'View Page'), 'url' => array('view', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Page'), 'url' => array('delete', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('app', sprintf('Update %s', 'Page')); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>