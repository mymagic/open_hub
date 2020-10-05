<?php
/* @var $this OrganizationFundingController */
/* @var $model OrganizationFunding */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'organization-funding-form',
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


	<div class="form-group <?php echo $model->hasErrors('organization_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_id'); ?>
		<div class="col-sm-10">
			<?php if ($model->isNewRecord): ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'attribute' => 'organization_id', 'urlAjax' => $this->createUrl('organizationFunding/ajaxOrganization'))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->organization_id => $model->organization->title), 'attribute' => 'organization_id', 'urlAjax' => $this->createUrl('organizationFunding/ajaxOrganization', array('id' => $model->id)))) ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_raised') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'date_raised'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_raised'); ?>
			<?php echo $form->bsError($model, 'date_raised'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('vc_organization_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'vc_organization_id'); ?>
		<div class="col-sm-10">
			<?php if ($model->isNewRecord): ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'attribute' => 'vc_organization_id', 'urlAjax' => $this->createUrl('organizationFunding/ajaxOrganization'))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->vc_organization_id => $model->vcOrganization->title), 'attribute' => 'vc_organization_id', 'urlAjax' => $this->createUrl('organizationFunding/ajaxOrganization', array('id' => $model->id)))) ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'vc_organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('vc_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'vc_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'vc_name'); ?>
			<?php echo $form->bsError($model, 'vc_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_amount_undisclosed') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_amount_undisclosed'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_amount_undisclosed'); ?>
			<?php echo $form->bsError($model, 'is_amount_undisclosed'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('amount') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'amount'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'amount'); ?>
			<?php echo $form->bsError($model, 'amount'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('round_type_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'round_type_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'round_type_code'); ?>
			<?php echo $form->bsError($model, 'round_type_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('source') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'source'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'source'); ?>
			<?php echo $form->bsError($model, 'source'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_publicized') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_publicized'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_publicized'); ?>
			<?php echo $form->bsError($model, 'is_publicized'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
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

