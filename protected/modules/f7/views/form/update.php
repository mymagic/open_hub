<?php
/* @var $this FormController */
/* @var $model Form */

$this->breadcrumbs = array(
	'Forms' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Form'), 'url' => array('/f7/form/admin')),
	array('label' => Yii::t('app', 'Create Form'), 'url' => array('/f7/form/create')),
	array('label' => Yii::t('app', 'View Form'), 'url' => array('/f7/form/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Form'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>