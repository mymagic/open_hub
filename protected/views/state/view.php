<?php
/* @var $this StateController */
/* @var $model State */

$this->breadcrumbs = array(
	'States' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage State'), 'url' => array('/state/admin')),
	array('label' => Yii::t('app', 'Create State'), 'url' => array('/state/create')),
	array('label' => Yii::t('app', 'Update State'), 'url' => array('/state/update', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'View State'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		array('name' => 'country_code', 'value' => $model->country->printable_name),
		'title',
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>