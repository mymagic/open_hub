<?php
/* @var $this SampleGroupController */
/* @var $model SampleGroup */

$this->breadcrumbs = array(
	'Sample Groups' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage SampleGroup'), 'url' => array('/sample/sampleGroup/admin')),
	array('label' => Yii::t('app', 'Create SampleGroup'), 'url' => array('/sample/sampleGroup/create')),
	array('label' => Yii::t('app', 'View SampleGroup'), 'url' => array('/sample/sampleGroup/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Sample Group'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>