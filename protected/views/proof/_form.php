<?php
/* @var $this ProofController */
/* @var $model Proof */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'proof-form',
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

	<div class="form-group <?php echo $model->hasErrors('ref_table') ? 'has-error':'' ?> <?php echo (empty($forRecord))?:'hidden' ?>">
		<?php echo $form->bsLabelEx2($model,'ref_table'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'ref_table', array('readonly'=>!empty($_GET['refTable']) || !$model->isNewRecord?'disabled':'')); ?>
			<?php echo $form->bsError($model,'ref_table'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('ref_id') ? 'has-error':'' ?> <?php echo (empty($forRecord))?:'hidden' ?>">
		<?php echo $form->bsLabelEx2($model,'ref_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ref_id', array('readonly'=>!empty($_GET['refId']) || !$model->isNewRecord ?'disabled':'')); ?>
			<?php echo $form->bsError($model,'ref_id'); ?>
		</div>
	</div>

	<?php if($model->isNewRecord): ?>
	<div class="form-group <?php echo $model->hasErrors('datatype') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'datatype'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'datatype'); ?>
			<?php echo $form->bsError($model,'datatype'); ?>
		</div>
	</div>
	<?php endif; ?>

	
	<div id="formGroup-value" class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'value'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'value'); ?>
			<?php echo $form->bsError($model,'value'); ?>
		</div>
	</div>
	
	<div id="formGroup-imageFileValue" class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'imageFile_value'); ?>
		<div class="col-sm-10"><div class="row">
			<div class="col-sm-2 text-left">
				<?php echo Html::activeThumb($model, 'value'); ?>
			</div>
			<div class="col-sm-8">
				<?php echo Html::activeFileField($model, 'imageFile_value'); ?>
			<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div></div>
	</div>

	<div id="formGroup-uploadFileValue" class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'uploadFile_value'); ?>
		<div class="col-sm-10"><div class="row">
			<div class="col-sm-2 text-left">
			</div>
			<div class="col-sm-8">
				<?php echo Html::activeFileField($model, 'uploadFile_value'); ?>
			<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div></div>
	</div>

	


	<div class="form-group <?php echo $model->hasErrors('note') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'note'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'note'); ?>
			<?php echo $form->bsError($model,'note'); ?>
		</div>
	</div>

		
	<!-- many2many -->
	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
			<?php if(!empty($forRecord)): ?>
				<?php echo Html::btnDanger(Yii::t('core', 'Cancel'), $model->getUrl('return2Record')) ?>
			<?php endif; ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php
Yii::app()->clientScript->registerScript('proof-_form', <<<EOD
    $('#Proof_datatype').change(function() {
		$('#formGroup-value, #formGroup-imageFileValue, #formGroup-uploadFileValue').hide();
		if($(this).val() == 'image') $('#formGroup-imageFileValue').show();
		if($(this).val() == 'file') $('#formGroup-uploadFileValue').show();
		if($(this).val() == 'string') $('#formGroup-value').show();
		
	});
	$('#Proof_datatype').trigger('change');
EOD
);
?>