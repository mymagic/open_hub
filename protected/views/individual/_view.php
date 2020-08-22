<?php
/* @var $this IndividualController */
/* @var $data Individual */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('full_name')); ?>:</b>
	<?php echo Html::encode($data->full_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo Html::encode($data->gender); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_photo')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_photo'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('country_code')); ?>:</b>
	<?php echo Html::encode($data->country_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('state_code')); ?>:</b>
	<?php echo Html::encode($data->state_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('ic_number')); ?>:</b>
	<?php echo Html::encode($data->ic_number); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_address_residential')); ?>:</b>
	<?php echo Html::encode($data->text_address_residential); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('can_code')); ?>:</b>
	<?php echo Html::encode($data->can_code); ?>
	<br />

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