<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs = array(
	'Bulletins' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'List Bulletin'), 'url' => array('index')),
	array('label' => Yii::t('app', 'Create Bulletin'), 'url' => array('create')),
	array('label' => Yii::t('app', 'Update Bulletin'), 'url' => array('update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Bulletin'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => Yii::t('app', 'Manage Bulletin'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', sprintf('View %s', 'Bulletin')); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'image_main', 'type' => 'html', 'value' => Html::activeThumb($model, 'image_main')),
		array('label' => $model->attributeLabel('date_posted'), 'value' => Html::formatDateTime($model->date_posted, 'long', 'medium')),
		array('name' => 'is_active',  'value' => Yii::t('core', Yii::app()->format->boolean($model->is_active))),
		array('name' => 'is_public',  'value' => Yii::t('core', Yii::app()->format->boolean($model->is_public))),
		array('name' => 'is_member',  'value' => Yii::t('core', Yii::app()->format->boolean($model->is_member))),
		array('name' => 'is_admin',  'value' => Yii::t('core', Yii::app()->format->boolean($model->is_admin))),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
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
	'data' => $model,
	'attributes' => array(
			'title_en',
		array('name' => 'text_short_description_en', 'type' => 'html', 'value' => nl2br($model->text_short_description_en)),
		array('name' => 'html_content_en', 'type' => 'html', 'value' => $model->html_content_en),
	),
)); ?>
	
	</div>
	<!-- /English -->
		
	
	<!-- Bahasa -->
	<div class="tab-pane " id="pane-ms">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_ms',
		array('name' => 'text_short_description_ms', 'type' => 'html', 'value' => nl2br($model->text_short_description_ms)),
		array('name' => 'html_content_ms', 'type' => 'html', 'value' => $model->html_content_ms),
	),
)); ?>
	
	</div>
	<!-- /Bahasa -->
		
	
	<!-- 中文 -->
	<div class="tab-pane " id="pane-zh">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_zh',
		array('name' => 'text_short_description_zh', 'type' => 'html', 'value' => nl2br($model->text_short_description_zh)),
		array('name' => 'html_content_zh', 'type' => 'html', 'value' => $model->html_content_zh),
	),
)); ?>
	
	</div>
	<!-- /中文 -->
		

</div>
</div>