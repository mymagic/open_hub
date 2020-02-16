<?php
/* @var $this EmbedController */
/* @var $model Embed */

$this->breadcrumbs=array(
	'Embeds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Embed'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','Create Embed'), 'url'=>array('create'), 'visible'=>Yii::app()->user->isDeveloper),
	array('label'=>Yii::t('app','View Embed'), 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('app', sprintf('Update %s', 'Embed')); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>