<?php
/* @var $this RegistryController */
/* @var $model Registry */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'registry-form',
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


	<div class="form-group <?php echo $model->hasErrors('code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'code'); ?>
			<?php echo $form->bsError($model,'code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('the_value') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'the_value'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'the_value'); ?>
			<?php echo $form->bsError($model,'the_value'); ?>
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

