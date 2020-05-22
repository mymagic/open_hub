<?php
/* @var $this ChargeController */
/* @var $data Charge */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('code')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->code), array('view', 'id' => $data->code)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo Html::encode($data->id); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo Html::encode($data->amount); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('currency_code')); ?>:</b>
	<?php echo Html::encode($data->currency_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_description')); ?>:</b>
	<?php echo Html::encode($data->text_description); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_started')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_started, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_expired')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_expired, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo Html::encode($data->formatEnumStatus($data->status)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('charge_to')); ?>:</b>
	<?php echo Html::encode($data->charge_to); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('charge_to_code')); ?>:</b>
	<?php echo Html::encode($data->charge_to_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>