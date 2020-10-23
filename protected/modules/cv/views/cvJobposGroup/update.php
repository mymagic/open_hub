<?php
/* @var $this CvJobposGroupController */
/* @var $model CvJobposGroup */

$this->breadcrumbs=array(
	'Cv Jobpos Groups'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvJobposGroup'), 'url'=>array('/cv/cvJobposGroup/admin')),
	array('label'=>Yii::t('app','Create CvJobposGroup'), 'url'=>array('/cv/cvJobposGroup/create')),
	array('label'=>Yii::t('app','View CvJobposGroup'), 'url'=>array('/cv/cvJobposGroup/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Cv Jobpos Group'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>