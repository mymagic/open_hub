<?php
/* @var $this EventOrganizationController */
/* @var $data EventOrganization */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('event_code')); ?>:</b>
	<?php echo Html::encode($data->event->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo Html::encode($data->event->id); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('event_vendor_code')); ?>:</b>
	<?php echo Html::encode($data->event_vendor_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('registration_code')); ?>:</b>
	<?php echo Html::encode($data->registration_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization_id')); ?>:</b>
	<?php echo Html::encode($data->organization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization_name')); ?>:</b>
	<?php echo Html::encode($data->organization_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('as_role_code')); ?>:</b>
	<?php echo Html::encode($data->as_role_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_action')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_action, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>