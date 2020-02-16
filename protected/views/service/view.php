<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs=array(
	'Services'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Service'), 'url'=>array('/service/admin')),
	array('label'=>Yii::t('app','Create Service'), 'url'=>array('/service/create')),
	array('label'=>Yii::t('app','Update Service'), 'url'=>array('/service/update', 'id'=>$model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Service'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'slug',
		'title',
		array('name'=>'text_oneliner', 'type'=>'raw', 'value'=>nl2br($model->text_oneliner)),
		array('name'=>'is_bookmarkable', 'type'=>'raw', 'value'=>Html::renderBoolean($model->is_bookmarkable)), 
		array('name'=>'is_active', 'type'=>'raw', 'value'=>Html::renderBoolean($model->is_active)), 
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>