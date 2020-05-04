<?php
/* @var $this SampleController */
/* @var $model Sample */

$this->breadcrumbs = array(
	'Samples' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Sample'), 'url' => array('/sample/sample/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Sample'), 'url' => array('/sample/sample/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Sample'), 'url' => array('/sample/sample/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Sample'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Sample'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		array('name' => 'sample_group_id', 'value' => $model->getAttributeDataByLanguage($model->sampleGroup, 'title')),
		array('name' => 'sample_zone_code', 'value' => $model->sampleZone->label),
		array('name' => 'image_main', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_main')),
		array('name' => 'file_backup', 'type' => 'raw', 'value' => Html::activeFile($model, 'file_backup')),
		'price_main',
		array('name' => 'gender', 'value' => $model->formatEnumGender($model->gender)),
		'age',
		array('name' => 'csv_keyword', 'type' => 'raw', 'value' => \Html::csvArea('csv_keyword', $model->csv_keyword)),
		'ordering',
		array('label' => $model->attributeLabel('date_posted'), 'value' => Html::formatDateTime($model->date_posted, 'long', 'medium')),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('name' => 'is_public', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_public)),
		array('name' => 'is_member', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_member)),
		array('name' => 'is_admin', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_admin)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>




<ul class="nav nav-tabs">

	<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>
	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>
	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>
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
		array('name' => 'html_content_en', 'type' => 'raw', 'value' => $model->html_content_en),
	),
)); ?>

	</div>
	<?php endif; ?>
	<!-- /English -->


	<!-- Bahasa -->
	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
	<div class="tab-pane " id="pane-ms">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_ms',
		array('name' => 'text_short_description_ms', 'type' => 'raw', 'value' => nl2br($model->text_short_description_ms)),
		array('name' => 'html_content_ms', 'type' => 'raw', 'value' => $model->html_content_ms),
	),
)); ?>

	</div>
	<?php endif; ?>
	<!-- /Bahasa -->


	<!-- 中文 -->
	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
	<div class="tab-pane " id="pane-zh">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
			'title_zh',
		array('name' => 'text_short_description_zh', 'type' => 'raw', 'value' => nl2br($model->text_short_description_zh)),
		array('name' => 'html_content_zh', 'type' => 'raw', 'value' => $model->html_content_zh),
	),
)); ?>

	</div>
	<?php endif; ?>
	<!-- /中文 -->


</div>
</div>