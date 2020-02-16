<?php
/* @var $this IndustryKeywordController */
/* @var $model IndustryKeyword */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'industry-keyword-form',
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


	<div class="form-group <?php echo $model->hasErrors('industry_code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'industry_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'industry_code', array('params'=>array('key'=>'code'))); ?>
			<?php echo $form->bsError($model,'industry_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model,'title'); ?>
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

