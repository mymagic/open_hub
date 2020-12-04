<?php
/* @var $this OrganizationRevenueController */
/* @var $model OrganizationRevenue */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'organization-revenue-form',
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
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model,
				'data' => array($model->organization_id => $model->organization->title), 'attribute' => 'organization_id', 'urlAjax' => $this->createUrl('organizationRevenue/ajaxOrganization'))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->organization_id => $model->organization->title), 'attribute' => 'organization_id', 'urlAjax' => $this->createUrl('organizationRevenue/ajaxOrganization', array('id' => $model->id)))) ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('year_reported') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'year_reported'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsNumberField($model, 'year_reported'); ?>
			<?php echo $form->bsError($model, 'year_reported'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('amount') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'amount'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsNumberField($model, 'amount'); ?>
			<?php echo $form->bsError($model, 'amount'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('amount_profit') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'amount_profit'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsNumberField($model, 'amount_profit'); ?>
			<?php echo $form->bsError($model, 'amount_profit'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('amount_profit_before_tax') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'amount_profit_before_tax'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsNumberField($model, 'amount_profit_before_tax'); ?>
			<?php echo $form->bsError($model, 'amount_profit_before_tax'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('source') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'source'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'source'); ?>
			<p class="help-block">From where this information is acquired? eg: Survey 2018</p>
			<?php echo $form->bsError($model, 'source'); ?>
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

