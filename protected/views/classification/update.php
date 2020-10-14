<?php
/* @var $this ClassificationController */
/* @var $model Classification */

$this->breadcrumbs=array(
	'Classifications'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Classification'), 'url'=>array('/classification/admin')),
	array('label'=>Yii::t('app','Create Classification'), 'url'=>array('/classification/create')),
	array('label'=>Yii::t('app','View Classification'), 'url'=>array('/classification/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Classification'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>