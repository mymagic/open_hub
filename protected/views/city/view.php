<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs = array(
	'Cities' => array('index'),
	$model->title,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage City'), 'url' => array('/city/admin')),
	array('label' => Yii::t('app', 'Create City'), 'url' => array('/city/create')),
	array('label' => Yii::t('app', 'Update City'), 'url' => array('/city/update', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('backend', 'View City'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'state_code', 'value' => $model->state->title),
		'title',
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>