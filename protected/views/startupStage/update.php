<?php
/* @var $this StartupStageController */
/* @var $model StartupStage */

$this->breadcrumbs = array(
	'Startup Stages' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage StartupStage'), 'url' => array('/startupStage/admin')),
	array('label' => Yii::t('app', 'Create StartupStage'), 'url' => array('/startupStage/create')),
	array('label' => Yii::t('app', 'View StartupStage'), 'url' => array('/startupStage/view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Startup Stage'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>