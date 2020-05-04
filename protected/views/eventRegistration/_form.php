<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'event-registration-form',
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



	<div class="form-group <?php echo $model->hasErrors('event_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'event_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'event_code'); ?>
			<?php echo $form->bsError($model, 'event_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('event_vendor_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'event_vendor_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'event_vendor_code'); ?>
			<?php echo $form->bsError($model, 'event_vendor_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('registration_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'registration_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'registration_code'); ?>
			<?php echo $form->bsError($model, 'registration_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('full_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'full_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_name'); ?>
			<?php echo $form->bsError($model, 'full_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('first_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'first_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'first_name'); ?>
			<?php echo $form->bsError($model, 'first_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('last_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'last_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'last_name'); ?>
			<?php echo $form->bsError($model, 'last_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('email') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'email'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'email'); ?>
			<?php echo $form->bsError($model, 'email'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('phone') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'phone'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'phone'); ?>
			<?php echo $form->bsError($model, 'phone'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('organization') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'organization'); ?>
			<?php echo $form->bsError($model, 'organization'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('gender') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'gender'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'gender'); ?>
			<?php echo $form->bsError($model, 'gender'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('age_group') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'age_group'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'age_group'); ?>
			<?php echo $form->bsError($model, 'age_group'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('where_found') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'where_found'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'where_found'); ?>
			<?php echo $form->bsError($model, 'where_found'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('persona') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'persona'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'persona'); ?>
			<?php echo $form->bsError($model, 'persona'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('paid_fee') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'paid_fee'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'paid_fee'); ?>
			<?php echo $form->bsError($model, 'paid_fee'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_attended') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_attended'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_attended'); ?>
			<?php echo $form->bsError($model, 'is_attended'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_registered') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_registered'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_registered'); ?>
			<?php echo $form->bsError($model, 'date_registered'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_payment') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_payment'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_payment'); ?>
			<?php echo $form->bsError($model, 'date_payment'); ?>
		</div>
	</div>


	<?php // if (Yii::app()->user->accessBackend && Yii::app()->user->isDeveloper):?>
	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])):?>
	<?php echo Notice::inline(Yii::t('notice', 'Meta Data Only accessible by developer role'), Notice_WARNING) ?>
	<?php $this->renderPartial('../../yeebase/views/metaStructure/_sharedForm', ['form' => $form, 'model' => $model]); ?>
	<?php endif; ?>
	<!-- many2many -->
	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

