<?php
/* @var $this EventbriteOrganizationWebhookController */
/* @var $model EventbriteOrganizationWebhook */

$this->breadcrumbs = array(
	'Eventbrite Organization Webhooks' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage EventbriteOrganizationWebhook'), 'url' => array('/eventbrite/eventbriteOrganizationWebhook/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Eventbrite Organization Webhook'); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>