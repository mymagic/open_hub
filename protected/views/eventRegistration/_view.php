<?php
/* @var $this EventRegistrationController */
/* @var $data EventRegistration */
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

	<b><?php echo Html::encode($data->getAttributeLabel('event_vendor_code')); ?>:</b>
	<?php echo Html::encode($data->event_vendor_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('registration_code')); ?>:</b>
	<?php echo Html::encode($data->registration_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('full_name')); ?>:</b>
	<?php echo Html::encode($data->full_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo Html::encode($data->first_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo Html::encode($data->last_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo Html::encode($data->email); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo Html::encode($data->phone); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization')); ?>:</b>
	<?php echo Html::encode($data->organization); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo Html::encode($data->formatEnumGender($data->gender)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('age_group')); ?>:</b>
	<?php echo Html::encode($data->age_group); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('where_found')); ?>:</b>
	<?php echo Html::encode($data->where_found); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('persona')); ?>:</b>
	<?php echo Html::encode($data->persona); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('paid_fee')); ?>:</b>
	<?php echo Html::encode($data->paid_fee); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_attended')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_attended))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_registered')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_registered, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_payment')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_payment, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_original')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>