<?php
$this->breadcrumbs=array(
    'Resource Directory'=>array('//resource'),
    'Create New Organization'
);

?>

<section class="container margin-top-lg">


<div class="col col-sm-9">
<h2>Create New Organization</h2>
<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'organization-form',
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


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'title'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model,'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_oneliner') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'text_oneliner'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'text_oneliner'); ?>
			<?php echo $form->bsError($model,'text_oneliner'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'text_short_description'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows'=>2)); ?>
			<?php echo $form->bsError($model,'text_short_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('legalform_id') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'legalform_id'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsForeignKeyDropDownList($model, 'legalform_id', array('nullable'=>true)); ?>
			<?php echo $form->bsError($model,'legalform_id'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('legal_name') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'legal_name'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'legal_name'); ?>
			<p class="help-block">How should we address your company legally for purposes like invoice and etc</p>
			<?php echo $form->bsError($model,'legal_name'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('company_number') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'company_number'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'company_number'); ?>
			<?php echo $form->bsError($model,'company_number'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_logo') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'image_logo'); ?>
		<div class="col-sm-9">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_logo'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_logo'); ?>
			<?php echo $form->bsError($model,'image_logo'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'url_website'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model,'url_website'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('email_contact') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model,'email_contact'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'email_contact'); ?>
			<p class="help-block">Who should we notify for activities happens to this company in the system</p>
			<?php echo $form->bsError($model,'email_contact'); ?>
		</div>
	</div>


	<div class="form-group">
		<div class="pull-right margin-top-lg">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create Company') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</section>