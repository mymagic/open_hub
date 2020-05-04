<?php
/* @var $this SampleGroupController */
/* @var $model SampleGroup */

$this->breadcrumbs = array(
	'Sample Groups' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage SampleGroup'), 'url' => array('/sample/sampleGroup/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create SampleGroup'), 'url' => array('/sample/sampleGroup/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update SampleGroup'), 'url' => array('/sample/sampleGroup/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Sample Group'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
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
	),
)); ?>

	</div>
	<?php endif; ?>
	<!-- /中文 -->


</div>
</div>