<?php
/* @var $this IndustryKeywordController */
/* @var $model IndustryKeyword */

$this->breadcrumbs=array(
	'Industry Keywords'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage IndustryKeyword'), 'url'=>array('/industryKeyword/admin')),
	array('label'=>Yii::t('app','Create IndustryKeyword'), 'url'=>array('/industryKeyword/create')),
	array('label'=>Yii::t('app','Update IndustryKeyword'), 'url'=>array('/industryKeyword/update', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete IndustryKeyword'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Industry Keyword'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'industry_code', 'value'=>$model->industry->title),
		'title',
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>