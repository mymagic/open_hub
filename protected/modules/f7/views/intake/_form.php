<?php
/* @var $this IntakeController */
/* @var $model Intake */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'intake-form',
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
			<?php echo $form->bsTextArea($model, 'text_oneliner', array('rows' => 2)); ?>
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


	<div class="form-group <?php echo $model->hasErrors('image_logo') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_logo'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_logo'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_logo'); ?>
			<?php echo $form->bsError($model, 'image_logo'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_started') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_started'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_started', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_started'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_ended') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_ended'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_ended', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_ended'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_highlight') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_highlight'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_highlight'); ?>
			<?php echo $form->bsError($model, 'is_highlight'); ?>
		</div>
	</div>





	<!-- many2many -->

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputPersonas') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputPersonas'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputPersonas'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputStartupStages') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputStartupStages'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputStartupStages', Html::listData(StartupStage::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputStartupStages'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputImpacts') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputImpacts'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputImpacts', Html::listData(Impact::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputImpacts'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputSdgs') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputSdgs'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputSdgs', Html::listData(Sdg::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputSdgs'); ?>
		</div>
	</div>
	<!-- /many2many -->

	<?php // if (Yii::app()->user->accessBackend && Yii::app()->user->isSuperAdmin):?>
	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'superAdmin']])):?>
	<div class="form-group <?php echo $model->hasErrors('tag_backend') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'tag_backend'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'tag_backend', array('id' => 'Intake-tag_backend', 'class' => 'form-control csv_tags')) ?>
			<?php echo $form->bsError($model, 'tag_backend') ?>
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

