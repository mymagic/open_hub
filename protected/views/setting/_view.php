<?php
/* @var $this SettingController */
/* @var $data Setting */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo Html::encode($data->code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo Html::encode($data->value); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('datatype')); ?>:</b>
	<?php echo Html::encode($data->formatEnumDatatype($data->datatype)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('datatype_value')); ?>:</b>
	<?php echo Html::encode($data->datatype_value); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo Html::encode($data->note); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>