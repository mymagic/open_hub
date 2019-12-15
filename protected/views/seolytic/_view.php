<?php
/* @var $this SeolyticController */
/* @var $data Seolytic */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('path_pattern')); ?>:</b>
	<?php echo Html::encode($data->path_pattern); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'title')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'title')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'description')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'description')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('js_header')); ?>:</b>
	<?php echo Html::encode($data->js_header); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('js_footer')); ?>:</b>
	<?php echo Html::encode($data->js_footer); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('css_header')); ?>:</b>
	<?php echo Html::encode($data->css_header); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_meta')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo Html::encode($data->ordering); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>