<?php
/* @var $this ChargeController */
/* @var $model Charge */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'charge-form',
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

	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('currency_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'currency_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'currency_code'); ?>
			<?php echo $form->bsError($model, 'currency_code'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('amount') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'amount'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'amount'); ?>
			<?php echo $form->bsError($model, 'amount'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('charge_to') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'charge_to'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'charge_to'); ?>
			<?php echo $form->bsError($model, 'charge_to'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('charge_to_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'charge_to_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'charge_to_code'); ?>
			<?php echo $form->bsError($model, 'charge_to_code'); ?>
		</div>
	</div>



	<div class="form-group <?php echo $model->hasErrors('date_started') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_started'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_started'); ?>
			<?php echo $form->bsError($model, 'date_started'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_expired') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_expired'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_expired'); ?>
			<?php echo $form->bsError($model, 'date_expired'); ?>
		</div>
	</div>

	<?php if (!$model->isNewRecord): ?>
	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
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