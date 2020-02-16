<?php
/* @var $this EmbedController */
/* @var $data Embed */
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

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'title')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'title')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'text_description')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'text_description')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'html_content')); ?>:</b>
	<?php echo ($data->getAttributeDataByLanguage($data, 'html_content')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'image_main')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_main_en'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_note')); ?>:</b>
	<?php echo Html::encode($data->text_note); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_title_enabled')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_title_enabled))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_text_description_enabled')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_text_description_enabled))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_html_content_enabled')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_html_content_enabled))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_image_main_enabled')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_image_main_enabled))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_default')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_default))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>