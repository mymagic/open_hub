<?php
/* @var $this EventOwnerController */
/* @var $model EventOwner */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'event-owner-form',
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


	<div class="form-group <?php echo $model->hasErrors('event_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'event_code'); ?>
		<div class="col-sm-10">
			<?php if ($model->isNewRecord): ?>
				<?php $this->widget('application.components.widgets.EventSelector', array('form' => $form, 'model' => $model, 'attribute' => 'event_code', 'urlAjax' => $this->createUrl('eventOwner/ajaxEvent'))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.EventSelector', array('form' => $form, 'model' => $model, 'data' => array($model->event_code => $model->event->title), 'attribute' => 'event_code', 'urlAjax' => $this->createUrl('eventOwner/ajaxEvent', array('id' => $model->id)))) ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'event_code'); ?>
		</div>
	</div>

	

	<div class="form-group <?php echo $model->hasErrors('organization_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_code'); ?>
		<div class="col-sm-10">
			<?php if ($model->isNewRecord): ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'attribute' => 'organization_code', 'urlAjax' => $this->createUrl('eventOwner/ajaxOrganization'))) ?>
			<?php else: ?>
				<?php $this->widget('application.components.widgets.OrganizationSelector', array('form' => $form, 'model' => $model, 'data' => array($model->organization_code => $model->organization->title), 'attribute' => 'organization_code', 'urlAjax' => $this->createUrl('eventOwner/ajaxOrganization', array('id' => $model->id)))) ?>
			<?php endif; ?>
			<?php echo $form->bsError($model, 'organization_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('department') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'department'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'department'); ?>
			<?php echo $form->bsError($model, 'department'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('as_role_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'as_role_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'as_role_code'); ?>
			<?php echo $form->bsError($model, 'as_role_code'); ?>
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

