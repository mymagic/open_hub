<?php
/* @var $this PageController */
/* @var $data Page */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo Html::encode($data->slug); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('menu_code')); ?>:</b>
	<?php echo Html::encode($data->menu_code); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'title')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'title')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'text_keyword')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'text_keyword')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'text_description')); ?>:</b>
	<?php echo Html::encode($data->getAttributeDataByLanguage($data, 'text_description')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabelByLanguage($data, 'html_content')); ?>:</b>
	<?php echo($data->getAttributeDataByLanguage($data, 'html_content')); ?>
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