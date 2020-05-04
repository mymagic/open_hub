<?php
/* @var $this ProductCategoryController */
/* @var $model ProductCategory */

$this->breadcrumbs = array(
	'Product Categories' => array('index'),
	$model->title,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage ProductCategory'), 'url' => array('/productCategory/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create ProductCategory'), 'url' => array('/productCategory/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update ProductCategory'), 'url' => array('/productCategory/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
);
?>

<h1><?php echo Yii::t('backend', 'View Product Category'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'title',
		array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
		array('name' => 'image_cover', 'type' => 'raw', 'value' => Html::activeThumb($model, 'image_cover')),
		'ordering',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>

<?php if (!empty($model->_metaStructures)):?>
<h2><?php echo Yii::t('core', 'Meta Data') ?></h2>
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => $model->metaItems2DetailViewArray(),
)); ?>
<?php endif; ?>


</div>