<?php
/* @var $this InterestController */
/* @var $model Interest */
/* @var $form CActiveForm */
?>


<div class="">

	<?php $form = $this->beginWidget('ActiveForm', array(
		'id' => 'interest-form',
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
	<?php if ($model->hasErrors()) : ?>
		<?php echo $form->bsErrorSummary($model); ?>
	<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('user_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'user_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'user_id'); ?>
			<?php echo $form->bsError($model, 'user_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('json_extra') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'json_extra'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'json_extra', array('rows' => 5)); ?>
			<?php echo $form->bsError($model, 'json_extra'); ?>
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

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('inputSdgs') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputSdgs'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputSdgs', Html::listData(Sdg::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputSdgs'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputClusters') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputClusters'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputClusters', Html::listData(Cluster::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputClusters'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputStartupStages') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputStartupStages'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputStartupStages', Html::listData(StartupStage::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputStartupStages'); ?>
		</div>
	</div>


	<!-- /many2many -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->