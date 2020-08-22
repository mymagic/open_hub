<?php
/* @var $this ResourceController */
/* @var $data Resource */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('orid')); ?>:</b>
	<?php echo Html::encode($data->orid); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo Html::encode($data->slug); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('html_content')); ?>:</b>
	<?php echo($data->html_content); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_logo')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_logo'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('url_website')); ?>:</b>
	<?php echo Html::encode($data->url_website); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('latlong_address')); ?>:</b>
	<?php echo Html::encode($data->latlong_address); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('full_address')); ?>:</b>
	<?php echo Html::encode($data->full_address); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('typefor')); ?>:</b>
	<?php echo Html::encode($data->formatEnumTypefor($data->typefor)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('owner')); ?>:</b>
	<?php echo Html::encode($data->owner); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_featured')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_featured))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
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