<?php
/* @var $this EmbedController */
/* @var $model Embed */

$this->breadcrumbs = array(
	'Embeds' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Embed'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Embed'), 'url' => array('create'),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Embed'), 'url' => array('update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Embed'), 'url' => array('delete', 'id' => $model->id),
		// 'visible' => Yii::app()->user->isDeveloper,
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>

<h1><?php echo Yii::t('app', sprintf('View %s', 'Embed')); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		array('name' => 'text_note', 'type' => 'html', 'value' => nl2br($model->text_note)),
		array('name' => 'is_title_enabled', 'type' => 'html', 'value' => Html::renderBoolean($model->is_title_enabled)),
		array('name' => 'is_text_description_enabled', 'type' => 'html', 'value' => Html::renderBoolean($model->is_text_description_enabled)),
		array('name' => 'is_html_content_enabled', 'type' => 'html', 'value' => Html::renderBoolean($model->is_html_content_enabled)),
		array('name' => 'is_image_main_enabled', 'type' => 'html', 'value' => Html::renderBoolean($model->is_image_main_enabled)),
		array('name' => 'is_default', 'type' => 'html', 'value' => Html::renderBoolean($model->is_default)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



<ul class="nav nav-tabs">
		<?php if (array_key_exists('en', Yii::app()->params['languages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab">English</a></li><?php endif; ?>
		<?php if (array_key_exists('ms', Yii::app()->params['languages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab">Bahasa</a></li><?php endif; ?>
		<?php if (array_key_exists('zh', Yii::app()->params['languages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab">中文</a></li><?php endif; ?>

</ul>
<div class="tab-content">

	<?php if (array_key_exists('en', Yii::app()->params['languages'])): ?>
	<!-- English -->
	<div class="tab-pane active" id="pane-en">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'title_en',
		array('name' => 'text_description_en', 'type' => 'html', 'value' => nl2br($model->text_description_en)),
		array('name' => 'html_content_en', 'type' => 'html', 'value' => Html::wysiwygHtml($model->html_content_en)),
		array('name' => 'image_main_en', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_main_en'))
	),
)); ?>

	</div>
	<!-- /English -->
	<?php endif; ?>

	<?php if (array_key_exists('ms', Yii::app()->params['languages'])): ?>
	<!-- Bahasa -->
	<div class="tab-pane " id="pane-ms">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'title_ms',
		array('name' => 'text_description_ms', 'type' => 'html', 'value' => nl2br($model->text_description_ms)),
		array('name' => 'html_content_ms', 'type' => 'html', 'value' => Html::wysiwygHtml($model->html_content_ms)),
		array('name' => 'image_main_ms', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_main_ms'))
	),
)); ?>

	</div>
	<!-- /Bahasa -->
	<?php endif; ?>

	<?php if (array_key_exists('zh', Yii::app()->params['languages'])): ?>
	<!-- 中文 -->
	<div class="tab-pane " id="pane-zh">

	<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'title_zh',
		array('name' => 'text_description_zh', 'type' => 'html', 'value' => nl2br($model->text_description_zh)),
		array('name' => 'html_content_zh', 'type' => 'html', 'value' => Html::wysiwygHtml($model->html_content_zh)),
		array('name' => 'image_main_zh', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_main_zh'))
	),
)); ?>

	</div>
	<!-- /中文 -->
	<?php endif; ?>


</div>
</div>