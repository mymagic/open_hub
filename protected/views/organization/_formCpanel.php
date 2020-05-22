<?php
/* @var $this OrganizationController */
/* @var $model Organization */
/* @var $form CActiveForm */
?>

<div class="form-new org-padding">

	<?php $form = $this->beginWidget('ActiveForm', array(
		'id' => 'organization-form',
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

	<div class="row">
		<div class="col-sm-12">
			<?php echo Notice::inline(Yii::t('notice', 'Fields with <span class="required">*</span> are required.')); ?>
			<?php if ($model->hasErrors()) : ?>
				<?php echo $form->bsErrorSummary($model); ?>
			<?php endif; ?>

		</div>
	</div>



	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'title'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_oneliner') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'text_oneliner'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'text_oneliner'); ?>
			<?php echo $form->bsError($model, 'text_oneliner'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'text_short_description'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_description'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'url_website'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model, 'url_website'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('email_contact') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'email_contact'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'email_contact'); ?>
			<p class="help-block"><?php echo Yii::t('app', 'Who should we notify for activities happens to this organization in the system') ?></p>
			<?php echo $form->bsError($model, 'email_contact'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'inputIndustries'); ?>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>

	<hr />

	<div class="form-group <?php echo $model->hasErrors('legalform_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'legalform_id'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsForeignKeyDropDownList($model, 'legalform_id', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'legalform_id'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('legal_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'legal_name'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'legal_name'); ?>
			<p class="help-block"><?php echo Yii::t('app', 'How should we address your company/organization legally for purposes like invoice and etc') ?></p>
			<?php echo $form->bsError($model, 'legal_name'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('company_number') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'company_number'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'company_number'); ?>
			<?php echo $form->bsError($model, 'company_number'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('year_founded') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'year_founded'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'year_founded'); ?>
			<?php echo $form->bsError($model, 'year_founded'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_logo') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'image_logo'); ?>
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-10">
					<?php echo Html::activeFileField($model, 'imageFile_logo'); ?>
					<?php echo $form->bsError($model, 'image_logo'); ?>
				</div>
				<div class="col-sm-2 text-left">
					<?php echo Html::activeThumb($model, 'image_logo'); ?>
				</div>
			</div>
		</div>
	</div>

	<div id="input-hidden-extra">
		<?php
		if ($model->inputPersonas !== null) :
			foreach ($model->inputPersonas as $val) :
				echo Html::activeHiddenField($model, 'inputPersonas[]', ['value' => $val]);
			endforeach;
		endif;
		if ($model->inputImpacts !== null) :
			foreach ($model->inputImpacts as $val) :
				echo Html::activeHiddenField($model, 'inputImpacts[]', ['value' => $val]);
			endforeach;
		endif;
		if ($model->inputSdgs !== null) :
			foreach ($model->inputSdgs as $val) :
				echo Html::activeHiddenField($model, 'inputSdgs[]', ['value' => $val]);
			endforeach;
		endif;
		?>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<div class="pull-right margin-top-lg">
				<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create Organization') : Yii::t('core', 'Save'), array('class' => 'btn btn-sd btn-sd-pad btn-sd-green')); ?>
			</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>

</div>
<!-- form -->
<!-- </div> -->