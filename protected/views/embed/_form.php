<?php
/* @var $this EmbedController */
/* @var $model Embed */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'embed-form',
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

	<div class="form-group <?php echo $model->hasErrors('code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'code', array('disabled' => $model->isNewRecord ? false : true)); ?>
			<?php echo $form->bsError($model, 'code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_note') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_note'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_note', array(
				'rows' => 2,
				// 'disabled' => Yii::app()->user->isDeveloper ? false : true
				'disabled' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']]) ? false : true
				)); ?>
			<?php echo $form->bsError($model, 'text_note'); ?>
		</div>
	</div>


	<?php // if (Yii::app()->user->isDeveloper):?>
	<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])): ?>
	<div class="form-group <?php echo $model->hasErrors('is_title_enabled') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_title_enabled'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_title_enabled'); ?>
			<?php echo $form->bsError($model, 'is_title_enabled'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_text_description_enabled') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_text_description_enabled'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_text_description_enabled'); ?>
			<?php echo $form->bsError($model, 'is_text_description_enabled'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_html_content_enabled') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_html_content_enabled'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_html_content_enabled'); ?>
			<?php echo $form->bsError($model, 'is_html_content_enabled'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_image_main_enabled') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_image_main_enabled'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_image_main_enabled'); ?>
			<?php echo $form->bsError($model, 'is_image_main_enabled'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_default') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_default'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_default'); ?>
			<?php echo $form->bsError($model, 'is_default'); ?>
		</div>
	</div>

	<?php endif; ?>

	<?php if (!$model->isNewRecord): ?>
	<ul class="nav nav-tabs">
		<?php if (array_key_exists('en', Yii::app()->params['languages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab">English</a></li><?php endif; ?>
		<?php if (array_key_exists('ms', Yii::app()->params['languages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab">Bahasa</a></li><?php endif; ?>
		<?php if (array_key_exists('zh', Yii::app()->params['languages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab">中文</a></li><?php endif; ?>
	</ul>
	<div class="tab-content">

		<?php if (array_key_exists('en', Yii::app()->params['languages'])): ?>
		<!-- English -->
		<div class="tab-pane active" id="pane-en">

			<?php if ($model->is_title_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('title_en') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'title_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_en'); ?>
					<?php echo $form->bsError($model, 'title_en'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_text_description_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('text_description_en') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'text_description_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextArea($model, 'text_description_en', array('rows' => 2)); ?>
					<?php echo $form->bsError($model, 'text_description_en'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_html_content_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('html_content_en') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'html_content_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsHtmlEditor($model, 'html_content_en'); ?>
					<?php echo $form->bsError($model, 'html_content_en'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_image_main_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('image_main_en') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'image_main_en'); ?>
				<div class="col-sm-10">
					<?php echo Html::activeFileField($model, 'imageFile_main_en'); ?>
					<?php echo $form->bsError($model, 'image_main_en'); ?>
				</div>
			</div>
			<?php endif; ?>

		</div>
		<!-- /English -->
		<?php endif; ?>

		<?php if (array_key_exists('ms', Yii::app()->params['languages'])): ?>
		<!-- Bahasa -->
		<div class="tab-pane " id="pane-ms">

			<?php if ($model->is_title_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('title_ms') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'title_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_ms'); ?>
					<?php echo $form->bsError($model, 'title_ms'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_text_description_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('text_description_ms') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'text_description_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextArea($model, 'text_description_ms', array('rows' => 2)); ?>
					<?php echo $form->bsError($model, 'text_description_ms'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_html_content_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('html_content_ms') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'html_content_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsHtmlMiniEditor($model, 'html_content_ms'); ?>
					<?php echo $form->bsError($model, 'html_content_ms'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_image_main_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('image_main_ms') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'image_main_ms'); ?>
				<div class="col-sm-10">
					<?php echo Html::activeFileField($model, 'imageFile_main_ms'); ?>
					<?php echo $form->bsError($model, 'image_main_ms'); ?>
				</div>
			</div>
			<?php endif; ?>

		</div>
		<!-- /Bahasa -->
		<?php endif; ?>


		<?php if (array_key_exists('zh', Yii::app()->params['languages'])): ?>
		<!-- 中文 -->
		<div class="tab-pane " id="pane-zh">

			<?php if ($model->is_title_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('title_zh') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'title_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_zh'); ?>
					<?php echo $form->bsError($model, 'title_zh'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_text_description_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('text_description_zh') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'text_description_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextArea($model, 'text_description_zh', array('rows' => 2)); ?>
					<?php echo $form->bsError($model, 'text_description_zh'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_html_content_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('html_content_zh') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'html_content_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsHtmlMiniEditor($model, 'html_content_zh'); ?>
					<?php echo $form->bsError($model, 'html_content_zh'); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($model->is_image_main_enabled): ?>
			<div class="form-group <?php echo $model->hasErrors('image_main_zh') ? 'has-error' : '' ?>">
				<?php echo $form->bsLabelEx2($model, 'image_main_zh'); ?>
				<div class="col-sm-10">
					<?php echo Html::activeFileField($model, 'imageFile_main_zh'); ?>
					<?php echo $form->bsError($model, 'image_main_zh'); ?>
				</div>
			</div>
			<?php endif; ?>

		</div>
		<!-- /中文 -->
		<?php endif; ?>


	</div>
	<?php endif; ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->