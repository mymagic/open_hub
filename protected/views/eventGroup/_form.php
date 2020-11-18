<?php
/* @var $this EventGroupController */
/* @var $model EventGroup */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'event-group-form',
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


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('image_cover') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_cover'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_cover'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_cover'); ?>
			<?php echo $form->bsError($model, 'image_cover'); ?>
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


	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'url_website'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model, 'url_website'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'slug'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
			<?php echo $form->bsError($model, 'slug'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('genre') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'genre'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'genre'); ?>
			<?php echo $form->bsError($model, 'genre'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('funnel') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'funnel'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'funnel'); ?>
			<?php echo $form->bsError($model, 'funnel'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('participant_type') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'participant_type'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'participant_type'); ?>
			<?php echo $form->bsError($model, 'participant_type'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('group_category') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'group_category'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'group_category'); ?>
			<?php echo $form->bsError($model, 'group_category'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_started') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_started'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_started'); ?>
			<?php echo $form->bsError($model, 'date_started'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_ended') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_ended'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_ended'); ?>
			<?php echo $form->bsError($model, 'date_ended'); ?>
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

