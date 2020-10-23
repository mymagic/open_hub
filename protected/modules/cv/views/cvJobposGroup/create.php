<?php
/* @var $this CvJobposGroupController */
/* @var $model CvJobposGroup */

$this->breadcrumbs=array(
	'Cv Jobpos Groups'=>array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvJobposGroup'), 'url'=>array('/cv/cvJobposGroup/admin')),
);
?>

<h1><?php echo Yii::t('backend', 'Create Cv Jobpos Group'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>