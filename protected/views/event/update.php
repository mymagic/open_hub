<?php
/* @var $this EventController */
/* @var $model Event */

$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('backend', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Event'), 'url'=>array('/event/admin')),
	array('label'=>Yii::t('app','Create Event'), 'url'=>array('/event/create')),
	array('label'=>Yii::t('app','View Event'), 'url'=>array('/event/view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'Update Event'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>