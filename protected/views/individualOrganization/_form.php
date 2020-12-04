<?php
/* @var $this IndividualOrganizationController */
/* @var $model IndividualOrganization */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'individual-organization-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-horizontal crud-form',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
	),
)); ?>

<?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if ($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('individual_id') ? 'has-error' : ''; ?>">
		<?php echo $form->bsLabelEx2($model, 'individual_id'); ?>
		<div class="col-sm-10">
			<?php if ($model->isNewRecord): ?>
				<?php $this->widget('application.components.widgets.IndividualSelector', array('form' => $form, 'model' => $model, 'data' => array($model->individual_id => $model->individualTitle), 'attribute' => 'individual_id', 'urlAjax' => $this->createUrl('individualOrganization/ajaxIndividual'))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.IndividualSelector', array('form' => $form, 'model' => $model, 'data' => array($model->individual_id => $model->individual->full_name), 'attribute' => 'individual_id', 'urlAjax' => $this->createUrl('individualOrganization/ajaxIndividual', array('id' => $model->id)))) ?>
			<?php endif; ?>	
			<?php echo $form->bsError($model, 'individual_id'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('organization_code') ? 'has-error' : ''; ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_code'); ?>
		<div class="col-sm-10">
		<?php if ($model->isNewRecord): ?>
			<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->organization_code => $model->organizationTitle), 'attribute' => 'organization_code', 'urlAjax' => $this->createUrl('individualOrganization/ajaxOrganization'))) ?>
		<?php else: ?>
			<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->organization_code => $model->organization->title), 'attribute' => 'organization_code', 'urlAjax' => $this->createUrl('individualOrganization/ajaxOrganization', array('id' => $model->id)))) ?>
		<?php endif; ?>
		<?php echo $form->bsError($model, 'organization_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('as_role_code') ? 'has-error' : ''; ?>">
		<?php echo $form->bsLabelEx2($model, 'as_role_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'as_role_code'); ?>
			<?php echo $form->bsError($model, 'as_role_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('job_position') ? 'has-error' : ''; ?>">
		<?php echo $form->bsLabelEx2($model, 'job_position'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'job_position'); ?>
			<?php echo $form->bsError($model, 'job_position'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_started') ? 'has-error' : ''; ?>">
		<?php echo $form->bsLabelEx2($model, 'date_started'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_started', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_started'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_ended') ? 'has-error' : ''; ?>">
		<?php echo $form->bsLabelEx2($model, 'date_ended'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_ended', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'date_ended'); ?>
		</div>
	</div>



		
	<!-- many2many -->
	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
			<?php if (!$model->isNewRecord): ?><a class="btn btn-danger" href="<?php echo $this->createUrl('individual/view', array('id' => $model->individual->id)); ?>">Cancel</a><?php endif; ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

