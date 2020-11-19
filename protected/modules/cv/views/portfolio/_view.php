<?php
/* @var $this CvPortfolioController */
/* @var $data CvPortfolio */
?>

<div class="view panel panel-default">
<div class="panel-heading">
	<b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
	#<?php echo Html::link(Html::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

</div>
<div class="panel-body">

	<b><?php echo Html::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo Html::encode($data->user->username); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo Html::encode($data->slug); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('jobpos_id')); ?>:</b>
	<?php echo Html::encode($data->cvJobpos->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('organization_name')); ?>:</b>
	<?php echo Html::encode($data->organization_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo Html::encode($data->location); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_address_residential')); ?>:</b>
	<?php echo Html::encode($data->text_address_residential); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('latlong_address_residential')); ?>:</b>
	<?php echo Html::encode($data->latlong_address_residential); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('state_code')); ?>:</b>
	<?php echo Html::encode($data->state->title); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('country_code')); ?>:</b>
	<?php echo Html::encode($data->country->printable_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('display_name')); ?>:</b>
	<?php echo Html::encode($data->display_name); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('image_avatar')); ?>:</b>
	<?php echo Html::activeThumb($data, 'image_avatar'); ?><br />

	<b><?php echo Html::encode($data->getAttributeLabel('high_academy_experience_id')); ?>:</b>
	<?php echo Html::encode($data->->); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_oneliner')); ?>:</b>
	<?php echo Html::encode($data->text_oneliner); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('text_short_description')); ?>:</b>
	<?php echo Html::encode($data->text_short_description); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_looking_fulltime')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_looking_fulltime))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_looking_contract')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_looking_contract))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_looking_freelance')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_looking_freelance))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_looking_cofounder')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_looking_cofounder))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_looking_internship')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_looking_internship))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_looking_apprenticeship')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_looking_apprenticeship))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('visibility')); ?>:</b>
	<?php echo Html::encode($data->formatEnumVisibility($data->visibility)); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo Html::encode(Yii::t('core', Yii::app()->format->boolean($data->is_active))); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('json_social')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('json_extra')); ?>:</b>
	<b><?php echo Html::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_added, 'long', 'medium')); ?>
	<br />

	<b><?php echo Html::encode($data->getAttributeLabel('date_modified')); ?>:</b>
	<?php echo Html::encode(Html::formatDateTime($data->date_modified, 'long', 'medium')); ?>
	<br />


</div>
</div>