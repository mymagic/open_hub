<?php
/* @var $this CvExperienceController */
/* @var $data CvExperience */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('cv_portfolio_id')); ?>:</b>
	<?php echo Html::encode($data->cvPortfolio->display_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('genre')); ?>:</b>
	<?php echo Html::encode($data->formatEnumGenre($data->genre)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo Html::encode($data->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization_name')); ?>:</b>
	<?php echo Html::encode($data->organization_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo Html::encode($data->location); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('full_address')); ?>:</b>
	<?php echo Html::encode($data->full_address); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('latlong_address')); ?>:</b>
	<?php echo Html::encode($data->latlong_address); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('state_code')); ?>:</b>
	<?php echo Html::encode($data->state->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('country_code')); ?>:</b>
	<?php echo Html::encode($data->country->printable_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_short_description')); ?>:</b>
	<?php echo Html::encode($data->text_short_description); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('year_start')); ?>:</b>
	<?php echo Html::encode($data->year_start); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('month_start')); ?>:</b>
	<?php echo Html::encode($data->formatEnumMonthStart($data->month_start)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('year_end')); ?>:</b>
	<?php echo Html::encode($data->year_end); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('month_end')); ?>:</b>
	<?php echo Html::encode($data->formatEnumMonthEnd($data->month_end)); ?>
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