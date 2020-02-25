<?php
/* @var $this RequestController */
/* @var $model Request */

$this->breadcrumbs = array(
	'Requests' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Request'), 'url' => array('/request/admin')),
	array('label' => Yii::t('app', 'Create Request'), 'url' => array('/request/create')),
	array('label' => Yii::t('app', 'Update Request'), 'url' => array('/request/update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Request'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>


<h1><?php echo Yii::t('backend', 'View Request'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'user_id', 'value' => $model->user->username),
		'type_code',
		'title',
		array('name' => 'json_data', 'type' => 'raw', 'value' => nl2br($model->json_data)),
		array('name' => 'status', 'value' => $model->formatEnumStatus($model->status)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>