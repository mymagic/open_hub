<?php
/* @var $this SdgController */
/* @var $model Sdg */

$this->breadcrumbs=array(
	'Sdgs'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Sdg'), 'url'=>array('/sdg/admin')),
	array('label'=>Yii::t('app','Create Sdg'), 'url'=>array('/sdg/create')),
	array('label'=>Yii::t('app','View Sdg'), 'url'=>array('/sdg/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Sdg'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>