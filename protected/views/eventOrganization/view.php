<?php
/* @var $this EventOrganizationController */
/* @var $model EventOrganization */

$this->breadcrumbs = array(
	'Event Organizations' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Event Organization'), 'url' => array('/eventOrganization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Event Organization'), 'url' => array('/eventOrganization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Event Organization'), 'url' => array('/eventOrganization/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Event Organization'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id, 'returnUrl' => $this->createAbsoluteUrl('/event/view', array('id' => $model->event->id))), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Event Organization'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'event_code', 'value' => Html::link($model->event->title, $this->createUrl('/event/view', array('id' => $model->event->id))), 'type' => 'html'),
		array('name' => 'organization_id', 'value' => Html::link($model->organization->title, $this->createUrl('/organization/view', array('id' => $model->organization->id))), 'type' => 'html'),
		array('name' => 'as_role_code', 'value' => $model->as_role_code),

		array('name' => 'registration_code', 'value' => $model->registration_code),
		'organization_name',
		array('name' => 'event_vendor_code', 'value' => $model->event_vendor_code),

		array('label' => $model->attributeLabel('date_action'), 'value' => Html::formatDateTime($model->date_action, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>