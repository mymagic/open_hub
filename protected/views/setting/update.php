<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->breadcrumbs=array(
	'Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Setting Panel'), 'url'=>array('panel')),
	array('label'=>Yii::t('app','Manage Setting'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','Create Setting'), 'url'=>array('create')),
	array('label'=>Yii::t('app','Update Setting'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('app','View Setting'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete Setting'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('app', sprintf('Update %s', 'Setting')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>