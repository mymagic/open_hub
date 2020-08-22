<?php
/* @var $this EventbriteOrganizationWebhookController */
/* @var $model EventbriteOrganizationWebhook */

$this->breadcrumbs = array(
	'Eventbrite Organization Webhooks' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('backend', 'Update'),
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
		'label' => Yii::t('app', 'View EventbriteOrganizationWebhook'), 'url' => array('/eventbrite/eventbriteOrganizationWebhook/view', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'view')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Update Eventbrite Organization Webhook'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>