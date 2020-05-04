<?php
/* @var $this SeolyticController */
/* @var $model Seolytic */

$this->breadcrumbs = array(
	'Seolytics' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Seolytic'), 'url' => array('/seolytic/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Seolytic'), 'url' => array('/seolytic/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Seolytic'), 'url' => array('/seolytic/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Seolytic'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Seolytic'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'path_pattern',
		'js_header',
		'js_footer',
		'css_header',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		'ordering',
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
		'description_en',
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
		'description_ms',
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
		'description_zh',
	),
)); ?>

	</div>
	<?php endif; ?>
	<!-- /中文 -->


</div>
</div>