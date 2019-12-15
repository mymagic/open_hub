<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs=array(
	'Charges'=>array('index'),
	$model->title=>array('view','id'=>$model->code),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Charge'), 'url'=>array('/charge/admin')),
	array('label'=>Yii::t('app','Create Charge'), 'url'=>array('/charge/create')),
	array('label'=>Yii::t('app','View Charge'), 'url'=>array('/charge/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Charge'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>