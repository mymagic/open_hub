<?php
/* @var $this IndividualOrganizationController */
/* @var $data IndividualOrganization */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('individual_id')); ?>:</b>
	<?php echo Html::encode($data->individual->full_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization_code')); ?>:</b>
	<?php echo Html::encode($data->organization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('as_role_code')); ?>:</b>
	<?php echo Html::encode($data->as_role_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('job_position')); ?>:</b>
	<?php echo Html::encode($data->job_position); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_started')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_started, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_ended')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_ended, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<?php echo Html::encode($data->json_extra); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>