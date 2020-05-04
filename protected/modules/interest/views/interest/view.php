<?php
/* @var $this InterestController */
/* @var $model Interest */

$this->breadcrumbs = array(
	'Interests' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Interest'), 'url' => array('/interest/interest/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array('label' => Yii::t('app', 'Create Interest'), 'url' => array('/interest/interest/create')),
	array('label' => Yii::t('app', 'Update Interest'), 'url' => array('/interest/interest/update', 'id' => $model->id)),
	array(
		'label' => Yii::t('app', 'Delete Interest'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Interest'); ?></h1>

<div class="crud-view">
	<?php $this->widget('application.components.widgets.DetailView', array(
		'data' => $model,
		'attributes' => array(
			'id',
			array('name' => 'user_id', 'value' => $model->user->username),
			'json_extra',
			array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
			array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
			array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
		),
	)); ?>



</div>