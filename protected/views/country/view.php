<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs = array(
	'Countries' => array('index'),
	$model->name,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Country'), 'url' => array('/country/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Country'), 'url' => array('/country/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Country'), 'url' => array('/country/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
);
?>

<h1><?php echo Yii::t('backend', 'View Country'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'code',
		'name',
		'printable_name',
		'iso3',
		'numcode',
		array('name' => 'is_default', 'type' => 'html', 'value' => Html::renderBoolean($model->is_default)),
		array('name' => 'is_highlight', 'type' => 'html', 'value' => Html::renderBoolean($model->is_highlight)),
		array('name' => 'is_active', 'type' => 'html', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>