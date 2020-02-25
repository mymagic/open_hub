<?php
/* @var $this JunkController */
/* @var $model Junk */

$this->breadcrumbs = array(
	'Junks' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label' => Yii::t('app', 'Manage Junk'), 'url' => array('/junk/admin')),
	array('label' => Yii::t('app', 'Create Junk'), 'url' => array('/junk/create')),
	array('label' => Yii::t('app', 'Update Junk'), 'url' => array('/junk/update', 'id' => $model->id)),
	array('label' => Yii::t('app', 'Delete Junk'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?'))),
);
?>

<h1><?php echo Yii::t('backend', 'View Junk'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		array('label' => $model->attributeLabel('content'), 'type' => 'raw', 'value' => sprintf('<textarea class="full-width" rows="20">%s</textarea>', $model->renderContent())),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>