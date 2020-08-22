<?php
/* @var $this EventbriteOrganizationWebhookController */
/* @var $model EventbriteOrganizationWebhook */

$this->breadcrumbs = array(
	'Eventbrite Organization Webhooks' => array('index'),
	$model->id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage EventbriteOrganizationWebhook'), 'url' => array('/eventbrite/eventbriteOrganizationWebhook/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create EventbriteOrganizationWebhook'), 'url' => array('/eventbrite/eventbriteOrganizationWebhook/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update EventbriteOrganizationWebhook'), 'url' => array('/eventbrite/eventbriteOrganizationWebhook/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete EventbriteOrganizationWebhook'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Eventbrite Organization Webhook'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		array('name' => 'organization_code', 'value' => $model->organization->title),
		array('name' => 'as_role_code', 'value' => $model->as_role_code),
		array('name' => 'eventbrite_account_id', 'value' => $model->eventbrite_account_id),
		'eventbrite_oauth_secret',
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>