<?php
/* @var $this BulletinController */
/* @var $data Bulletin */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo CHtml::encode($data->getAttributeLabel('title_en')); ?>:</b>
	<?php echo CHtml::encode($data->title_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title_ms')); ?>:</b>
	<?php echo CHtml::encode($data->title_ms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title_zh')); ?>:</b>
	<?php echo CHtml::encode($data->title_zh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_short_description_en')); ?>:</b>
	<?php echo CHtml::encode($data->text_short_description_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_short_description_ms')); ?>:</b>
	<?php echo CHtml::encode($data->text_short_description_ms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_short_description_zh')); ?>:</b>
	<?php echo CHtml::encode($data->text_short_description_zh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_content_en')); ?>:</b>
	<?php echo($data->html_content_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_content_ms')); ?>:</b>
	<?php echo($data->html_content_ms); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('html_content_zh')); ?>:</b>
	<?php echo($data->html_content_zh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_main')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_main'); ?><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_posted')); ?>:</b>
	<?php echo CHtml::encode(Html::formatDateTime($data->date_posted, 'long', 'medium')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_public')); ?>:</b>
	<?php echo CHtml::encode(Yii::t('core', Yii::app()->format->boolean($data->is_public))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_member')); ?>:</b>
	<?php echo CHtml::encode(Yii::t('core', Yii::app()->format->boolean($data->is_member))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_admin')); ?>:</b>
	<?php echo CHtml::encode(Yii::t('core', Yii::app()->format->boolean($data->is_admin))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo CHtml::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo CHtml::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>