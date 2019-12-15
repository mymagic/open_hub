<?php
/* @var $this CountryController */
/* @var $model Country */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'country-form',
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

<?php echo Notice::inline(Yii::t('notice', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>

	<div class="form-group <?php echo $model->hasErrors('code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'code'); ?>
			<?php echo $form->bsError($model,'code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('name') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'name'); ?>
			<?php echo $form->bsError($model,'name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('printable_name') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'printable_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'printable_name'); ?>
			<?php echo $form->bsError($model,'printable_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('iso3') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'iso3'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'iso3'); ?>
			<?php echo $form->bsError($model,'iso3'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('numcode') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'numcode'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'numcode'); ?>
			<?php echo $form->bsError($model,'numcode'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_default') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_default'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_default'); ?>
			<?php echo $form->bsError($model,'is_default'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_highlight') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_highlight'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_highlight'); ?>
			<?php echo $form->bsError($model,'is_highlight'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model,'is_active'); ?>
		</div>
	</div>



	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->