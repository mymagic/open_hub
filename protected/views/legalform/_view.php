<?php
/* @var $this LegalformController */
/* @var $data Legalform */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('country_code')); ?>:</b>
	<?php echo Html::encode($data->country->printable_name); ?>
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