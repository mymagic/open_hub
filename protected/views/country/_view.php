<?php
/* @var $this CountryController */
/* @var $data Country */
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

	<b><?php echo Html::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo Html::encode($data->name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('printable_name')); ?>:</b>
	<?php echo Html::encode($data->printable_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('iso3')); ?>:</b>
	<?php echo Html::encode($data->iso3); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('numcode')); ?>:</b>
	<?php echo Html::encode($data->numcode); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_default')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_default))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_highlight')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_highlight))); ?>
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