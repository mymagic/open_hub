<?php
/* @var $this SampleZoneController */
/* @var $model SampleZone */

$this->breadcrumbs=array(
	'Sample Zones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage SampleZone'), 'url'=>array('/sample/sampleZone/admin')),
	array('label'=>Yii::t('app','Create SampleZone'), 'url'=>array('/sample/sampleZone/create')),
	array('label'=>Yii::t('app','Update SampleZone'), 'url'=>array('/sample/sampleZone/update', 'id'=>$model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'View Sample Zone'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'label',
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>