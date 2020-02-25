<?php
/* @var $this OrganizationFundingController */
/* @var $data OrganizationFunding */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('organization_id')); ?>:</b>
	<?php echo Html::encode($data->organization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_raised')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_raised, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('vc_organization_id')); ?>:</b>
	<?php echo Html::encode($data->vcOrganization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('vc_name')); ?>:</b>
	<?php echo Html::encode($data->vc_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('amount_undisclosed')); ?>:</b>
	<?php echo Html::encode($data->amount_undisclosed); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo Html::encode($data->amount); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('round_type_code')); ?>:</b>
	<?php echo Html::encode($data->formatEnumRoundTypeCode($data->round_type_code)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('source')); ?>:</b>
	<?php echo Html::encode($data->source); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>