<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs = array(
	'Pages' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Page'), 'url' => array('admin')),
	array('label' => Yii::t('app', 'Create Page'), 'url' => array('create')),
	array('label' => Yii::t('app', 'Update Page'), 'url' => array('update', 'id' => $model->id)),
	array(
		'label' => Yii::t('app', 'Delete Page'), 'url' => array('delete', 'id' => $model->id),
		// 'visible' => (Yii::app()->user->isDeveloper) ? true : false
		'visible' => (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])) ? true : false
	),
);
?>

<h1><?php echo Yii::t('app', sprintf('View %s', 'Page')); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'slug',
		'menu_code',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('name' => 'is_default', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_default)),
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
		array('name' => 'text_keyword_en', 'type' => 'html', 'value' => nl2br($model->text_keyword_en)),
		array('name' => 'text_description_en', 'type' => 'html', 'value' => nl2br($model->text_description_en)),
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
		array('name' => 'text_keyword_ms', 'type' => 'html', 'value' => nl2br($model->text_keyword_ms)),
		array('name' => 'text_description_ms', 'type' => 'html', 'value' => nl2br($model->text_description_ms)),
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
		array('name' => 'text_keyword_zh', 'type' => 'html', 'value' => nl2br($model->text_keyword_zh)),
		array('name' => 'text_description_zh', 'type' => 'html', 'value' => nl2br($model->text_description_zh)),
		array('name' => 'html_content_zh', 'type' => 'html', 'value' => $model->html_content_zh),
	),
)); ?>

	</div>
	<!-- /中文 -->


</div>
</div>