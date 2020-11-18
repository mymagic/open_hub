<?php
/* @var $this SeolyticController */
/* @var $model Seolytic */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'seolytic-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
		'class' => 'form-horizontal crud-form',
		'role' => 'form',
		'enctype' => 'multipart/form-data',
		'action' => $model->isNewRecord ? $this->createProxyUrl('/seolytic/create') : $this->createProxyUrl('/seolytic/update', array('id' => $model->id))
	)
)); ?>

<?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if ($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('path_pattern') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'path_pattern'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'path_pattern'); ?>
			<?php echo $form->bsError($model, 'path_pattern'); ?>
		</div>
	</div>
						

	<div class="form-group <?php echo $model->hasErrors('js_header') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'js_header'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'js_header', array('rows' => 5)); ?>
			<p class="help-block">Without the &lt;scrip&gt; tag</p>
			<?php echo $form->bsError($model, 'js_header'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('js_footer') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'js_footer'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'js_footer', array('rows' => 5)); ?>
			<p class="help-block">Without the &lt;scrip&gt; tag</p>
			<?php echo $form->bsError($model, 'js_footer'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('css_header') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'css_header'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'css_header', array('rows' => 5)); ?>
			<p class="help-block">Without the &lt;style&gt; tag</p>
			<?php echo $form->bsError($model, 'css_header'); ?>
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
		
	<?php if (array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>		
	<?php if (array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>		
	<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab" data-tab-history="true" data-tab-history-changer="push" data-tab-history-update-url="true"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>		
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


			<div class="form-group <?php echo $model->hasErrors('description_en') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'description_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'description_en'); ?>
					<?php echo $form->bsError($model, 'description_en'); ?>
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


			<div class="form-group <?php echo $model->hasErrors('description_ms') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'description_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'description_ms'); ?>
					<?php echo $form->bsError($model, 'description_ms'); ?>
				</div>
			</div>

		</div>
		<?php endif; ?>
		<!-- /Bahasa -->
		
		
		<!-- 中文 -->
		<?php if (array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane " id="pane-zh">


			<div class="form-group <?php echo $model->hasErrors('title_zh') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'title_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_zh'); ?>
					<?php echo $form->bsError($model, 'title_zh'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('description_zh') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'description_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'description_zh'); ?>
					<?php echo $form->bsError($model, 'description_zh'); ?>
				</div>
			</div>

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

