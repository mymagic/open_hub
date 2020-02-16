<?php
/* @var $this SampleController */
/* @var $data Sample */
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

	<b><?php echo Html::encode($data->getAttributeLabel('sample_group_id')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data->sampleGroup, "title")); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('sample_zone_code')); ?>:</b>
	<?php echo Html::encode($data->sampleZone->label); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'title')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'title')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'text_short_description')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'text_short_description')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'html_content')); ?>:</b>
	<?php echo ($data->getAttributeDataByLanguage($data, 'html_content')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_main')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_main'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('file_backup')); ?>:</b>
	<?php echo Html::encode($data->file_backup); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('price_main')); ?>:</b>
	<?php echo Html::encode($data->price_main); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo Html::encode($data->formatEnumGender($data->gender)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('age')); ?>:</b>
	<?php echo Html::encode($data->age); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('csv_keyword')); ?>:</b>
	<?php echo Html::encode($data->csv_keyword); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo Html::encode($data->ordering); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_posted')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_posted, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_public')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_public))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_member')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_member))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_admin')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_admin))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>