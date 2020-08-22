<?php
/* @var $this SubmissionController */
/* @var $model FormSubmission */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'submission-form',
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


	<div class="form-group <?php echo $model->hasErrors('status') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'status'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'status'); ?>
			<?php echo $form->bsError($model, 'status'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('stage') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'stage'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'stage'); ?>
			<?php echo $form->bsError($model, 'stage'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('date_submitted') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_submitted'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTimeTextField($model, 'date_submitted', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_submitted'); ?>
		</div>
	</div>


	<?php // if (Yii::app()->user->isDeveloper):?>
	<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])): ?>
	<div class="form-group <?php echo $model->hasErrors('json_data') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'json_data'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'json_data', array('rows' => 10, 'readonly' => 'readonly')); ?>
			<?php echo $form->bsError($model, 'json_data'); ?>
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


<?php Yii::app()->clientScript->registerScript('js-f7-submission-_form', <<<JS

document.getElementById('FormSubmission_json_data').value = JSON.stringify(JSON.parse(document.getElementById('FormSubmission_json_data').value), undefined, 10);
JS
, CClientScript::POS_READY); ?>