<?php
/* @var $this ClassificationController */
/* @var $model Classification */

$this->breadcrumbs = array(
	'Classifications' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Classification'), 'url' => array('/classification/admin')),
	array('label' => Yii::t('app', 'Create Classification'), 'url' => array('/classification/create')),
	array('label' => Yii::t('app', 'Update Classification'), 'url' => array('/classification/update', 'id' => $model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Classification'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'slug',
		'code',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>




<ul class="nav nav-tabs">
		
	<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>		
	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>		
	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>		
</ul>
<div class="tab-content">
	
	<!-- English -->
	<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
	<div class="tab-pane active" id="pane-en">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_en',
		array('name' => 'text_short_description_en', 'type' => 'raw', 'value' => nl2br($model->text_short_description_en)),
	),
)); ?>
	
	</div>
	<?php endif; ?>
	<!-- /English -->
		
	
	<!-- Bahasa Melayu -->
	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
	<div class="tab-pane " id="pane-ms">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_ms',
		array('name' => 'text_short_description_ms', 'type' => 'raw', 'value' => nl2br($model->text_short_description_ms)),
	),
)); ?>
	
	</div>
	<?php endif; ?>
	<!-- /Bahasa Melayu -->
		
	
	<!-- 中文 -->
	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
	<div class="tab-pane " id="pane-zh">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		),
)); ?>
	
	</div>
	<?php endif; ?>
	<!-- /中文 -->
		

</div>
</div>