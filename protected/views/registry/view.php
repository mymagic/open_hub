<?php
/* @var $this RegistryController */
/* @var $model Registry */

$this->breadcrumbs=array(
	'Registries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Registry'), 'url'=>array('/registry/admin')),
	array('label'=>Yii::t('app','Create Registry'), 'url'=>array('/registry/create')),
	array('label'=>Yii::t('app','Update Registry'), 'url'=>array('/registry/update', 'id'=>$model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Registry'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'the_value',
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>