<?php
/* @var $this EventbriteOrganizationWebhookController */
/* @var $data EventbriteOrganizationWebhook */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('organization_code')); ?>:</b>
	<?php echo Html::encode($data->organization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('as_role_code')); ?>:</b>
	<?php echo Html::encode($data->as_role_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('eventbrite_account_id')); ?>:</b>
	<?php echo Html::encode($data->eventbrite_account_id); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('eventbrite_oauth_secret')); ?>:</b>
	<?php echo Html::encode($data->eventbrite_oauth_secret); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>