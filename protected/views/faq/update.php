<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Faq'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','Create Faq'), 'url'=>array('create')),
	array('label'=>Yii::t('app','View Faq'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete Faq'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('app', sprintf('Update %s', 'Faq')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>