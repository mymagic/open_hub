<?php
/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'service-form',
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


	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'slug'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
			<p class="help-block">Must match with module code</p>
			<?php echo $form->bsError($model, 'slug'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_oneliner') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_oneliner'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'text_oneliner', array('maxlength' => 200)); ?>
			<p class="help-block">Maximum 200 characters</p>
			<?php echo $form->bsError($model, 'text_oneliner'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_bookmarkable') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_bookmarkable'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_bookmarkable'); ?>
			<p class="help-block">Only bookmarkable services are show in member cpanel</p>
			<?php echo $form->bsError($model, 'is_bookmarkable'); ?>
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

