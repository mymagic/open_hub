<?php
/* @var $this EventbriteOrganizationWebhookController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Eventbrite Organization Webhooks',
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
);
?>

<h1><?php echo Yii::t('backend', 'Eventbrite Organization Webhooks'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
