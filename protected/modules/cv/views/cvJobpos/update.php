<?php
/* @var $this CvJobposController */
/* @var $model CvJobpos */

$this->breadcrumbs=array(
	'Cv Jobposes'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage CvJobpos'), 'url'=>array('/cv/cvJobpos/admin')),
	array('label'=>Yii::t('app','Create CvJobpos'), 'url'=>array('/cv/cvJobpos/create')),
	array('label'=>Yii::t('app','View CvJobpos'), 'url'=>array('/cv/cvJobpos/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Cv Jobpos'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>