<?php
/* @var $this IndividualController */
/* @var $model Individual */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'individual-form',
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


	<div class="form-group <?php echo $model->hasErrors('full_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'full_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_name'); ?>
			<?php echo $form->bsError($model, 'full_name'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('gender') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'gender'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'gender'); ?>
			<?php echo $form->bsError($model, 'gender'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_photo') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_photo'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_photo'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_photo'); ?>
			<?php echo $form->bsError($model, 'image_photo'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('country_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'country_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'country_code', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'country_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('state_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'state_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'state_code', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'state_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('ic_number') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'ic_number'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'ic_number'); ?>
			<?php echo $form->bsError($model, 'ic_number'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('mobile_number') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'mobile_number'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'mobile_number'); ?>
			<?php echo $form->bsError($model, 'mobile_number'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_address_residential') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_address_residential'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_address_residential', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_address_residential'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('can_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'can_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'can_code', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'can_code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputPersonas') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputPersonas'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputPersonas'); ?>
		</div>
	</div>

	<?php // if (Yii::app()->user->accessBackend && Yii::app()->user->isSuperAdmin):?>
	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'superAdmin']])):?>
	<div class="form-group <?php echo $model->hasErrors('tag_backend') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'tag_backend'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'tag_backend', array('id' => 'Individual-tag_backend', 'class' => 'form-control csv_tags')) ?>
			<?php echo $form->bsError($model, 'tag_backend') ?>
		</div>
	</div>
	<?php endif; ?>

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

