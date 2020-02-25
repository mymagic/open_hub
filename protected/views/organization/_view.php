<?php
/* @var $this OrganizationController */
/* @var $data Organization */
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

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('legalform_id')); ?>:</b>
	<?php echo Html::encode($data->legalform->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('company_number')); ?>:</b>
	<?php echo Html::encode($data->company_number); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_logo')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_logo'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('url_website')); ?>:</b>
	<?php echo Html::encode($data->url_website); ?>
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