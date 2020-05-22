<?php
/* @var $this Resource2OrganizationFundingController */
/* @var $data Resource2OrganizationFunding */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('resource_id')); ?>:</b>
	<?php echo Html::encode($data->resource->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization_funding_id')); ?>:</b>
	<?php echo Html::encode($data->organizationFunding->id); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('as_role_code')); ?>:</b>
	<?php echo Html::encode($data->as_role_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>