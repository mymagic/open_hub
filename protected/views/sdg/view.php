<?php
/* @var $this SdgController */
/* @var $model Sdg */

$this->breadcrumbs = array(
	'Sdgs' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Sdg'), 'url' => array('/sdg/admin')),
	array('label' => Yii::t('app', 'Create Sdg'), 'url' => array('/sdg/create')),
	array('label' => Yii::t('app', 'Update Sdg'), 'url' => array('/sdg/update', 'id' => $model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Sdg'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		'title',
		array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
		array('name' => 'image_cover', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_cover')),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>