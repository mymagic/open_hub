<?php
/* @var $this InterestController */
/* @var $model Interest */
/* @var $form CActiveForm */
?>

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

<div class="px-8 py-6 shadow-panel mt-4 mb-6">

	<h2>Help us to serve you better</h2>
	<p>Update your interest to get better programme and service recommendations.</p>

	<div class="mt-4">

		<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
			<div class="col-sm-12">
				<label>Industry</label>
				<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
				<?php echo $form->bsError($model, 'inputIndustries'); ?>
				<!-- <span class="help-block m-b-none">help text</span> -->
			</div>
		</div>


		<div class="form-group <?php echo $model->hasErrors('inputSdgs') ? 'has-error' : '' ?>">
			<div class="col-sm-12">
				<label>Sustainable Development Goals</label>
				<?php echo $form->dropDownList($model, 'inputSdgs', Html::listData(Sdg::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
				<?php echo $form->bsError($model, 'inputSdgs'); ?>
				<!-- <span class="help-block m-b-none">help text</span> -->

			</div>
		</div>

		<div class="form-group <?php echo $model->hasErrors('inputStartupStages') ? 'has-error' : '' ?>">
			<div class="col-sm-12">
				<label>Startup Stage</label>
				<?php echo $form->dropDownList($model, 'inputStartupStages', Html::listData(StartupStage::getForeignReferList()), array('class' => 'js-multi-select js-states form-control', 'multiple' => 'multiple')); ?>
				<?php echo $form->bsError($model, 'inputStartupStages'); ?>
				<!-- <span class="help-block m-b-none">help text</span> -->

			</div>
		</div>

	</div>

</div>


<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10 flex justify-end">
		<?php echo $form->bsBtnSubmit(Yii::t('core', 'Update Interest')); ?>
	</div>
</div>

<?php $this->endWidget(); ?>