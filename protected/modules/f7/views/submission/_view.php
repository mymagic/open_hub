<?php
/* @var $this FormController */
/* @var $data Form */
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

	<b><?php echo Html::encode($data->getAttributeLabel('form_code')); ?>:</b>
	<?php echo Html::encode($data->form_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_data')); ?>:</b>
	<?php echo Html::encode($data->json_data); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo Html::encode($data->status); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('stage')); ?>:</b>
	<?php echo Html::encode($data->stage); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_short_description')); ?>:</b>
	<?php echo Html::encode($data->text_short_description); ?>
	<br />
	
	<b><?php echo Html::encode($data->getAttributeLabel('date_submitted')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_submitted, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />

</div>
</div>