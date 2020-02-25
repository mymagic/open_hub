<?php
/* @var $this PersonaController */
/* @var $model Persona */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'persona-form',
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


	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'slug'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
			<?php echo $form->bsError($model, 'slug'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>


	<ul class="nav nav-tabs">
		
		<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>		
		<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>		
		<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>		
		</ul>
		<div class="tab-content">
				
			<!-- English -->
			<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
			<div class="tab-pane active" id="pane-en">


				<div class="form-group <?php echo $model->hasErrors('title_en') ? 'has-error' : '' ?>">
					<?php echo $form->bsLabelEx2($model, 'title_en'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextField($model, 'title_en'); ?>
						<?php echo $form->bsError($model, 'title_en'); ?>
					</div>
				</div>


				<div class="form-group <?php echo $model->hasErrors('text_short_description_en') ? 'has-error' : '' ?>">
					<?php echo $form->bsLabelEx2($model, 'text_short_description_en'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model, 'text_short_description_en', array('rows' => 2)); ?>
						<?php echo $form->bsError($model, 'text_short_description_en'); ?>
					</div>
				</div>

			</div>
			<?php endif; ?>
			<!-- /English -->
			
			
			<!-- Bahasa -->
			<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
			<div class="tab-pane " id="pane-ms">


				<div class="form-group <?php echo $model->hasErrors('title_ms') ? 'has-error' : '' ?>">
					<?php echo $form->bsLabelEx2($model, 'title_ms'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextField($model, 'title_ms'); ?>
						<?php echo $form->bsError($model, 'title_ms'); ?>
					</div>
				</div>


				<div class="form-group <?php echo $model->hasErrors('text_short_description_ms') ? 'has-error' : '' ?>">
					<?php echo $form->bsLabelEx2($model, 'text_short_description_ms'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model, 'text_short_description_ms', array('rows' => 2)); ?>
						<?php echo $form->bsError($model, 'text_short_description_ms'); ?>
					</div>
				</div>

			</div>
			<?php endif; ?>
			<!-- /Bahasa -->
			
			
			<!-- 中文 -->
			<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
			<div class="tab-pane " id="pane-zh">

			</div>
			<?php endif; ?>
			<!-- /中文 -->
			
		
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

