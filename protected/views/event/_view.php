<?php
/* @var $this EventController */
/* @var $data Event */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo Html::encode($data->code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('event_group_code')); ?>:</b>
	<?php echo Html::encode($data->event_group->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_short_desc')); ?>:</b>
	<?php echo Html::encode($data->text_short_desc); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('url_website')); ?>:</b>
	<?php echo Html::encode($data->url_website); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_started')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_started, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_ended')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_ended, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_paid_event')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_paid_event))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('genre')); ?>:</b>
	<?php echo Html::encode($data->genre); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('funnel')); ?>:</b>
	<?php echo Html::encode($data->funnel); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('vendor')); ?>:</b>
	<?php echo Html::encode($data->vendor); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('vendor_code')); ?>:</b>
	<?php echo Html::encode($data->vendor_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('at')); ?>:</b>
	<?php echo Html::encode($data->at); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('address_country_code')); ?>:</b>
	<?php echo Html::encode($data->country->printable_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('address_state_code')); ?>:</b>
	<?php echo Html::encode($data->state->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('full_address')); ?>:</b>
	<?php echo Html::encode($data->full_address); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('latlong_address')); ?>:</b>
	<?php echo Html::encode($data->latlong_address); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('email_contact')); ?>:</b>
	<?php echo Html::encode($data->email_contact); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_original')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>