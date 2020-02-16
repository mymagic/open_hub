<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage City'), 'url'=>array('/city/admin')),
	array('label'=>Yii::t('app','Create City'), 'url'=>array('/city/create')),
	array('label'=>Yii::t('app','View City'), 'url'=>array('/city/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update City'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>