<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'event-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-horizontal crud-form',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
	)
)); ?>

<?php echo Notice::inline(Yii::t('notice', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if ($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('event_group_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'event_group_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'event_group_code', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'event_group_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'code', array('required' => false)); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'code', array('nullable' => true)); ?>
			<p class="help-block">Leave blank for auto generated UUID code. If specify, use only lowercase alpha numerical.</p>
			<?php echo $form->bsError($model, 'code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_desc') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_short_desc'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_desc', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_desc'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'url_website'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model, 'url_website'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_started') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_started'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_started'); ?>
			<?php echo $form->bsError($model, 'date_started'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_ended') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_ended'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_ended'); ?>
			<?php echo $form->bsError($model, 'date_ended'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_paid_event') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_paid_event'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_paid_event', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'is_paid_event'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('genre') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'genre'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'genre'); ?>
			<?php echo $form->bsError($model, 'genre'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('funnel') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'funnel'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'funnel'); ?>
			<?php echo $form->bsError($model, 'funnel'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('vendor') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'vendor'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'vendor'); ?>
			<span class="help-block"><?php echo Yii::t('backend', 'software system provider for this event. eg: bizzabo, eventbrite') ?></span>
			<?php echo $form->bsError($model, 'vendor'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('vendor_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'vendor_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'vendor_code'); ?>
			<?php echo $form->bsError($model, 'vendor_code'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('at') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'at'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'at'); ?>
			<?php echo $form->bsError($model, 'at'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('full_address') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'full_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_address'); ?>
			<?php echo $form->bsError($model, 'full_address'); ?>
		</div>
	</div>

	<?php if (!$model->isNewRecord): ?>
	<div class="form-group <?php echo $model->hasErrors('latlong_address') ? 'has-error' : '' ?>">
	<?php echo $form->bsLabelEx2($model, 'latlong_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsGeoPointField($model, 'latlong_address', array('readonly' => 'readonly', 'isGeoCodingEnabled' => true, 'geoCodingAddress' => $model->full_address, 'mapZoom' => 10)); ?>
			<p class="help-block">Please double click on map to set the marker</p>
			<?php echo $form->bsError($model, 'latlong_address'); ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="form-group <?php echo $model->hasErrors('email_contact') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'email_contact'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'email_contact'); ?>
			<?php echo $form->bsError($model, 'email_contact'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_cancelled') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_cancelled'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_cancelled'); ?>
			<?php echo $form->bsError($model, 'is_cancelled'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_survey_enabled') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_survey_enabled'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_survey_enabled'); ?>
			<?php echo $form->bsError($model, 'is_survey_enabled'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>





	<!-- many2many -->

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputPersonas') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputPersonas'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputPersonas'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputStartupStages') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputStartupStages'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputStartupStages', Html::listData(StartupStage::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputStartupStages'); ?>
		</div>
	</div>
	<!-- /many2many -->

	<?php // if (Yii::app()->user->accessBackend && Yii::app()->user->isSuperAdmin):?>
	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'superAdmin']])):?>
	<div class="form-group <?php echo $model->hasErrors('tag_backend') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'tag_backend'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'tag_backend', array('id' => 'Event-tag_backend', 'class' => 'form-control csv_tags')) ?>
			<?php echo $form->bsError($model, 'tag_backend') ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScript('google-map', '

	$(document).on("change", "#Event_full_address", function(){updateEventAddress2LatLong();});
'); ?>
