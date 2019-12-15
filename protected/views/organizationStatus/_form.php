<?php
/* @var $this OrganizationStatusController */
/* @var $model OrganizationStatus */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'organization-status-form',
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


	<div class="form-group <?php echo $model->hasErrors('organization_id') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'organization_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'organization_id', array('class'=>'chosen', 'params'=>array('mode'=>$model->isNewRecord?'isActiveId':''))); ?>
			<?php echo $form->bsError($model,'organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_reported') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'date_reported'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_reported'); ?>
			<?php echo $form->bsError($model,'date_reported'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('status') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'status'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'status'); ?>
			<?php echo $form->bsError($model,'status'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('source') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'source'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'source'); ?>
			<?php echo $form->bsError($model,'source'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model,'is_active'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_note') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'text_note'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_note',array('rows'=>2)); ?>
			<?php echo $form->bsError($model,'text_note'); ?>
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

