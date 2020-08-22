<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs = array(
	'Logs' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Log'), 'url' => array('admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('app', sprintf('View %s', 'Log')); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'ip',
		'agent_string',
		'url_referrer',
		'url_current',
		array('name' => 'user_id', 'value' => $model->user->username),
		array('name' => 'is_admin', 'type' => 'html', 'value' => Html::renderBoolean($model->is_admin)),
		array('name' => 'is_member', 'type' => 'html', 'value' => Html::renderBoolean($model->is_member)),
		'controller',
		'action',
		array('name' => 'json_params', 'type' => 'html', 'value' => Html::htmlArea('json_params', nl2br($model->json_params))),
		array('name' => 'text_note', 'type' => 'html', 'value' => Html::htmlArea('text_note', nl2br($model->text_note))),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>


</div>