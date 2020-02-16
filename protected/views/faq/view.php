<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('app','Manage Faq'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','Create Faq'), 'url'=>array('create')),
	array('label'=>Yii::t('app','Update Faq'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('app','Delete Faq'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'csrf'=>Yii::app()->request->enableCsrfValidation, 'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'))),

);
?>

<h1><?php echo Yii::t('app', sprintf('View %s', 'Faq')); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ordering',
		array('name'=>'is_active', 'type'=>'html', 'value'=>Html::renderBoolean($model->is_active)), 
		array('label'=>$model->attributeLabel('date_added'), 'value'=>Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label'=>$model->attributeLabel('date_modified'), 'value'=>Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



<ul class="nav nav-tabs">
	<li class="active"><a href="#pane-en" data-toggle="tab">English</a></li>
		<li class=""><a href="#pane-ms" data-toggle="tab">Bahasa</a></li>
		<li class=""><a href="#pane-zh" data-toggle="tab">中文</a></li>
	
</ul>
<div class="tab-content">
	
	<!-- English -->
	<div class="tab-pane active" id="pane-en">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'title_en',
		array('name'=>'html_content_en', 'type'=>'html', 'value'=>$model->html_content_en),
	),
)); ?>
	
	</div>
	<!-- /English -->
		
	
	<!-- Bahasa -->
	<div class="tab-pane " id="pane-ms">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'title_ms',
		array('name'=>'html_content_ms', 'type'=>'html', 'value'=>$model->html_content_ms),
	),
)); ?>
	
	</div>
	<!-- /Bahasa -->
		
	
	<!-- 中文 -->
	<div class="tab-pane " id="pane-zh">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'title_zh',
		array('name'=>'html_content_zh', 'type'=>'html', 'value'=>$model->html_content_zh),
	),
)); ?>
	
	</div>
	<!-- /中文 -->
		

</div>
</div>