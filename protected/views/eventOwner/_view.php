<?php
/* @var $this EventOwnerController */
/* @var $data EventOwner */
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

	<b><?php echo Html::encode($data->getAttributeLabel('organization_code')); ?>:</b>
	<?php echo Html::encode($data->organization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo Html::encode($data->department); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>