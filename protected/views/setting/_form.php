<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'setting-form',
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
			<?php echo $form->bsTextField($model, 'code', array('disabled'=>$model->isNewRecord?false:true)); ?>
			<?php echo $form->bsError($model,'code'); ?>
		</div>
	</div>

	<?php if(!$model->isNewRecord): ?>
	<?php if($model->datatype == 'boolean'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsBooleanList($model, 'value'); ?>
				<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div>
	<?php elseif($model->datatype == 'enum'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsEnumDropDownList($model, 'value'); ?>
				<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div>
	<?php elseif($model->datatype == 'string' || $model->datatype == 'integer' || $model->datatype == 'float'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsTextField($model, 'value'); ?>
				<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div>
	<?php elseif($model->datatype == 'html'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsHtmlMiniEditor($model, 'value'); ?>
				<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div>
	<?php elseif($model->datatype == 'date'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsDateTextField($model, 'value'); ?>
				<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div>
	<?php elseif($model->datatype == 'image'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
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
	<?php elseif($model->datatype == 'file'): ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10"><div class="row">
				<div class="col-sm-2 text-left">
					<?php //echo !empty($model->file_pitch_deck)?Html::link(Html::faIcon('fa-file-o').' '.Yii::t('app', "Uploaded File"), $this->generateUrlGetUploadedFile($model->file_pitch_deck), array('target'=>'_blank')):'' ?>
				</div>
				<div class="col-sm-8">
					<?php echo Html::activeFileField($model, 'uploadFile_value'); ?>
				<?php echo $form->bsError($model,'value'); ?>
				</div>
			</div></div>
		</div>
	<?php else: ?>
		<div class="form-group <?php echo $model->hasErrors('value') ? 'has-error':'' ?>">
			<?php echo $form->bsLabelEx2($model,'value'); ?>
			<div class="col-sm-10">
				<?php echo $form->bsTextArea($model, 'value', array('rows'=>5)); ?>
				<?php echo $form->bsError($model,'value'); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php endif; ?>

	<div class="form-group <?php echo $model->hasErrors('datatype') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'datatype'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'datatype', array('disabled'=>$model->isNewRecord?false:true)); ?>
			<?php echo $form->bsError($model,'datatype'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('datatype_value') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'datatype_value'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'datatype_value', array('rows'=>5, 'disabled'=>$model->isNewRecord?false:true)); ?>
			<?php echo $form->bsError($model,'datatype_value'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('note') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'note'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'note', array('rows'=>5)); ?>
			<?php echo $form->bsError($model,'note'); ?>
		</div>
	</div>



	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->