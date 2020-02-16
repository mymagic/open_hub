<?php
/* @var $this ProofController */
/* @var $model Proof */

$this->breadcrumbs=array(
	'Proofs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Proof'), 'url'=>array('/proof/admin')),
	array('label'=>Yii::t('app','Create Proof'), 'url'=>array('/proof/create')),
	array('label'=>Yii::t('app','Update Proof'), 'url'=>array('/proof/update', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete Proof'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Proof'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'ref_table', 'value'=>$model->formatEnumRefTable($model->ref_table)),
		array('name'=>'ref_id', 'value'=>$model->ref_id),
		//array('name'=>'datatype', 'value'=>$model->formatEnumDatatype($data->datatype)),
		'datatype',
		array('label'=>$model->attributeLabel('value'), 'type'=>"html", 'value'=>$model->renderValue("html")),
		'note',
		'user_username',
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>