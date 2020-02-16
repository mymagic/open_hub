<?php
/* @var $this ChallengeController */
/* @var $data Challenge */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('owner_organization_id')); ?>:</b>
	<?php echo Html::encode($data->ownerOrganization->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('creator_user_id')); ?>:</b>
	<?php echo Html::encode($data->creatorUser->username); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_short_description')); ?>:</b>
	<?php echo Html::encode($data->text_short_description); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('html_content')); ?>:</b>
	<?php echo ($data->html_content); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_cover')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_cover'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_header')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_header'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('url_video')); ?>:</b>
	<?php echo Html::encode($data->url_video); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('url_application_form')); ?>:</b>
	<?php echo Html::encode($data->url_application_form); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('html_deliverable')); ?>:</b>
	<?php echo ($data->html_deliverable); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('html_criteria')); ?>:</b>
	<?php echo ($data->html_criteria); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('prize_title')); ?>:</b>
	<?php echo Html::encode($data->prize_title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('html_prize_detail')); ?>:</b>
	<?php echo ($data->html_prize_detail); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_open')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_open, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_close')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_close, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo Html::encode($data->ordering); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_remark')); ?>:</b>
	<?php echo Html::encode($data->text_remark); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo Html::encode($data->formatEnumStatus($data->status)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('timezone')); ?>:</b>
	<?php echo Html::encode($data->timezone); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_publish')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_publish))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_highlight')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_highlight))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('process_by')); ?>:</b>
	<?php echo Html::encode($data->process_by); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_submit')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_submit, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_process')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_process, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>