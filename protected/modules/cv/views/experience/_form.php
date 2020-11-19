<?php
/* @var $this CvExperienceController */
/* @var $model CvExperience */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'cv-experience-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array
	(
		'class'=>'form-horizontal crud-form',
		'role'=>'form',
		'enctype'=>'multipart/form-data',
	)
)); ?>

<?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('cv_portfolio_id') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'cv_portfolio_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'cv_portfolio_id'); ?>
			<?php echo $form->bsError($model,'cv_portfolio_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('genre') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'genre'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'genre'); ?>
			<?php echo $form->bsError($model,'genre'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model,'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('organization_name') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'organization_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'organization_name'); ?>
			<?php echo $form->bsError($model,'organization_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('location') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'location'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'location'); ?>
			<?php echo $form->bsError($model,'location'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('full_address') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'full_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'full_address', array('rows'=>5)); ?>
			<?php echo $form->bsError($model,'full_address'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('latlong_address') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'latlong_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'latlong_address'); ?>
			<?php echo $form->bsError($model,'latlong_address'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('state_code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'state_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'state_code'); ?>
			<?php echo $form->bsError($model,'state_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('country_code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'country_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'country_code'); ?>
			<?php echo $form->bsError($model,'country_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_short_description',array('rows'=>2)); ?>
			<?php echo $form->bsError($model,'text_short_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('year_start') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'year_start'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'year_start'); ?>
			<?php echo $form->bsError($model,'year_start'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('month_start') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'month_start'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'month_start'); ?>
			<?php echo $form->bsError($model,'month_start'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('year_end') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'year_end'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'year_end'); ?>
			<?php echo $form->bsError($model,'year_end'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('month_end') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'month_end'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'month_end'); ?>
			<?php echo $form->bsError($model,'month_end'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model,'is_active'); ?>
		</div>
	</div>




		
	<!-- many2many -->
	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScript('google-map', '

	$(document).on("change", "#CvExperience_full_address", function(){updateCvExperienceAddress2LatLong();});
'); ?>
