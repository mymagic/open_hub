<?php
/* @var $this SampleController */
/* @var $model Sample */

$this->breadcrumbs = array(
	'Samples' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Sample'), 'url' => array('/sample/sample/admin')),
	array('label' => Yii::t('app', 'Create Sample'), 'url' => array('/sample/sample/create')),
	array('label' => Yii::t('app', 'View Sample'), 'url' => array('/sample/sample/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Sample'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>