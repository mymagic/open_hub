<?php
/* @var $this MilestoneController */
/* @var $model Milestone */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'milestone-form',
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


	<div class="form-group <?php echo $model->hasErrors('organization_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'organization_id', array('class' => 'chosen', 'nullable' => true)); ?>
			<?php echo $form->bsError($model, 'organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('preset_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'preset_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'preset_code'); ?>
			<?php echo $form->bsError($model, 'preset_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_description'); ?>
		</div>
	</div>

	<div class="form-group hidden <?php echo $model->hasErrors('viewMode') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'viewMode'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'viewMode'); ?>
			<?php echo $form->bsError($model, 'viewMode'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('source') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'source'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'source'); ?>
			<?php echo $form->bsError($model, 'source'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_disclosed') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_disclosed'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_disclosed'); ?>
			<?php echo $form->bsError($model, 'is_disclosed'); ?>
		</div>
	</div>
	<div class="form-group <?php echo $model->hasErrors('is_star') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_star'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_star'); ?>
			<?php echo $form->bsError($model, 'is_star'); ?>
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

