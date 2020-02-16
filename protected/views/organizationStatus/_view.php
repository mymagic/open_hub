<?php
/* @var $this OrganizationStatusController */
/* @var $data OrganizationStatus */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('organization_id')); ?>:</b>
	<?php echo Html::encode($data->organization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_reported')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_reported, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo Html::encode($data->status); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('source')); ?>:</b>
	<?php echo Html::encode($data->source); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_note')); ?>:</b>
	<?php echo Html::encode($data->text_note); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>