<?php
/* @var $this EventbriteOrganizationWebhookController */
/* @var $model EventbriteOrganizationWebhook */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'eventbrite-organization-webhook-form',
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


	<div class="form-group <?php echo $model->hasErrors('organization_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_code'); ?>
		<div class="col-sm-10">
			<?php if ($model->isNewRecord): ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'attribute' => 'organization_code', 'urlAjax' => $this->createUrl('/organization/ajaxOrganization', array('key' => 'code')))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->organization_code => $model->organization->title), 'attribute' => 'organization_code', 'urlAjax' => $this->createUrl('/organization/ajaxOrganization', array('key' => 'code')))) ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'organization_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('as_role_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'as_role_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'as_role_code'); ?>
			<?php echo $form->bsError($model, 'as_role_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('eventbrite_account_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'eventbrite_account_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'eventbrite_account_id'); ?>
			<?php echo $form->bsError($model, 'eventbrite_account_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('eventbrite_oauth_secret') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'eventbrite_oauth_secret'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'eventbrite_oauth_secret'); ?>
			<?php echo $form->bsError($model, 'eventbrite_oauth_secret'); ?>
		</div>
	</div>

	<?php if (!$model->isNewRecord): ?>
	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>
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

