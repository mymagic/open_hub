<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'member-form',
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
		
	<div class="form-group">
		<?php echo $form->bsLabelEx2($model->user, 'username'); ?>
		<div class="col-sm-10">
			<?php echo $model->user->username; ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('user.profile.full_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model->user->profile, 'full_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsPhoneTextField($model->user->profile, 'full_name'); ?>
			<?php echo $form->bsError($model->user->profile, 'full_name'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('ic') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'ic'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ic'); ?>
			<?php echo $form->bsError($model, 'ic'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('dob') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'dob'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'dob', array('placeholder' => 'yyyy-mm-dd')); ?>
			<?php echo $form->bsError($model, 'dob'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('account_bankname') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'account_bankname'); ?>
		<div class="col-sm-10">
			<?php if (Bank::isCodeExists($model->account_bankname)): ?>
				<?php echo $form->bsForeignKeyDropDownList($model, 'account_bankname', array('nullable' => true)); ?>
			<?php else: ?>
				<?php echo $form->bsTextField($model, 'account_bankname'); ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'account_bankname'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('account_number') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'account_number'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'account_number'); ?>
			<?php echo $form->bsError($model, 'account_number'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('account_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'account_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'account_name'); ?>
			<?php echo $form->bsError($model, 'account_name'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('user.email') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model->user, 'email'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEmailTextField($model->user, 'email'); ?>
			<?php echo $form->bsError($model->user, 'email'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('user.profile.mobile_no') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model->user->profile, 'mobile_no'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsPhoneTextField($model->user->profile, 'mobile_no'); ?>
			<?php echo $form->bsError($model->user->profile, 'mobile_no'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_receive_sms') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_receive_sms'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_receive_sms'); ?>
			<?php echo $form->bsError($model, 'is_receive_sms'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('is_receive_newsletter') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_receive_newsletter'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_receive_newsletter'); ?>
			<?php echo $form->bsError($model, 'is_receive_newsletter'); ?>
		</div>
	</div>
		
		
	<div class="form-group <?php echo $model->hasErrors('text_admin_remark') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_admin_remark'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_admin_remark'); ?>
			<?php echo $form->bsError($model, 'text_admin_remark'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('text_admin_alert') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_admin_alert'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_admin_alert'); ?>
			<?php echo $form->bsError($model, 'text_admin_alert'); ?>
		</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('text_detail') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_detail'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_detail'); ?>
			<?php echo $form->bsError($model, 'text_detail'); ?>
		</div>
	</div>
		


	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->