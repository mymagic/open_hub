<?php
/* @var $this Form2IntakeController */
/* @var $model Form2Intake */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'form2-intake-form',
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


	<div class="form-group <?php echo $model->hasErrors('intake_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'intake_id'); ?>
		<div class="col-sm-10">
			<?php $params = array(); if ($model->isNewRecord && !empty(Yii::app()->getRequest()->getQuery('intakeId'))) {
	$params['disabled'] = 'disabled';
} ?>
			<?php echo $form->bsForeignKeyDropDownList($model, 'intake_id', $params); ?>
			<?php echo $form->bsError($model, 'intake_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('form_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'form_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'form_id'); ?>
			<?php echo $form->bsError($model, 'form_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_primary') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_primary'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_primary'); ?>
			<?php echo $form->bsError($model, 'is_primary'); ?>
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
	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

