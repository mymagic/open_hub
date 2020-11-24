<?php
/* @var $this CvPortfolioController */
/* @var $model CvPortfolio */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'cv-portfolio-form',
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

<?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if ($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('user_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'user_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextHolder($model->user, 'username'); ?>
			<?php echo $form->bsError($model, 'user_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'slug'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
			<?php echo $form->bsError($model, 'slug'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('organization_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'organization_name'); ?>
			<?php echo $form->bsError($model, 'organization_name'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_address_residential') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_address_residential'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_address_residential', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_address_residential'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('display_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'display_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'display_name'); ?>
			<?php echo $form->bsError($model, 'display_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_avatar') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_avatar'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_avatar'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_avatar'); ?>
			<?php echo $form->bsError($model, 'image_avatar'); ?>
			</div>
		</div>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_oneliner') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_oneliner'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'text_oneliner'); ?>
			<?php echo $form->bsError($model, 'text_oneliner'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_looking_fulltime') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_looking_fulltime'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_looking_fulltime'); ?>
			<?php echo $form->bsError($model, 'is_looking_fulltime'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_looking_contract') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_looking_contract'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_looking_contract'); ?>
			<?php echo $form->bsError($model, 'is_looking_contract'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_looking_freelance') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_looking_freelance'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_looking_freelance'); ?>
			<?php echo $form->bsError($model, 'is_looking_freelance'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_looking_cofounder') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_looking_cofounder'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_looking_cofounder'); ?>
			<?php echo $form->bsError($model, 'is_looking_cofounder'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_looking_internship') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_looking_internship'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_looking_internship'); ?>
			<?php echo $form->bsError($model, 'is_looking_internship'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_looking_apprenticeship') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_looking_apprenticeship'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_looking_apprenticeship'); ?>
			<?php echo $form->bsError($model, 'is_looking_apprenticeship'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('visibility') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'visibility'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'visibility'); ?>
			<?php echo $form->bsError($model, 'visibility'); ?>
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

<?php Yii::app()->clientScript->registerScript('google-map', '

	$(document).on("change", "#CvPortfolio_text_address_residential", function(){updateCvPortfolioAddressResidential2LatLong();});
'); ?>
