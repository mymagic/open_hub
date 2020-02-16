<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	'Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('app','Setting Panel'), 'url'=>array('panel')),
	array('label'=>Yii::t('app','Manage Setting'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','Create Setting'), 'url'=>array('create')),
);
?>

<h1><?php echo Yii::t('app', sprintf('Create %s', 'Setting')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>