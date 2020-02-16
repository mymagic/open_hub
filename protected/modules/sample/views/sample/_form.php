<?php
/* @var $this SampleController */
/* @var $model Sample */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'sample-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array
	(
		'class'=>'form-horizontal crud-form',
		'role'=>'form',
		'enctype'=>'multipart/form-data',
	)
)); ?>

<?php echo Notice::inline(Yii::t('notice', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'code'); ?>
			<?php echo $form->bsError($model,'code'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('sample_group_id') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'sample_group_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'sample_group_id'); ?>
			<?php echo $form->bsError($model,'sample_group_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('sample_zone_code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'sample_zone_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'sample_zone_code'); ?>
			<?php echo $form->bsError($model,'sample_zone_code'); ?>
		</div>
	</div>
									

	<div class="form-group <?php echo $model->hasErrors('image_main') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'image_main'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_main'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_main'); ?>
			<?php echo $form->bsError($model,'image_main'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('file_backup') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'file_backup'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'file_backup'); ?>
			<?php echo $form->bsError($model,'file_backup'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('price_main') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'price_main'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'price_main'); ?>
			<?php echo $form->bsError($model,'price_main'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('gender') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'gender'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'gender'); ?>
			<?php echo $form->bsError($model,'gender'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('age') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'age'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'age'); ?>
			<?php echo $form->bsError($model,'age'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('csv_keyword') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'csv_keyword'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsCsvTextField($model, 'csv_keyword'); ?>
			<?php echo $form->bsError($model,'csv_keyword'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_posted') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'date_posted'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model, 'date_posted'); ?>
			<?php echo $form->bsError($model,'date_posted'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model,'is_active'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_public') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_public'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_public'); ?>
			<?php echo $form->bsError($model,'is_public'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_member') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_member'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_member'); ?>
			<?php echo $form->bsError($model,'is_member'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_admin') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_admin'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_admin'); ?>
			<?php echo $form->bsError($model,'is_admin'); ?>
		</div>
	</div>


	<ul class="nav nav-tabs">
		
	<?php if(array_key_exists('en', Yii::app()->params['backendLanguages'])): ?><li class="active"><a href="#pane-en" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['en']; ?></a></li><?php endif; ?>		
	<?php if(array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-ms" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['ms']; ?></a></li><?php endif; ?>		
	<?php if(array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?><li class=""><a href="#pane-zh" data-toggle="tab"><?php echo Yii::app()->params['backendLanguages']['zh']; ?></a></li><?php endif; ?>		
	</ul>
	<div class="tab-content">
			
		<!-- English -->
		<?php if(array_key_exists('en', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane active" id="pane-en">


			<div class="form-group <?php echo $model->hasErrors('title_en') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'title_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_en'); ?>
					<?php echo $form->bsError($model,'title_en'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('text_short_description_en') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'text_short_description_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextArea($model,'text_short_description_en',array('rows'=>2)); ?>
					<?php echo $form->bsError($model,'text_short_description_en'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('html_content_en') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'html_content_en'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsHtmlEditor($model, 'html_content_en'); ?>
					<?php echo $form->bsError($model,'html_content_en'); ?>
				</div>
			</div>

		</div>
		<?php endif; ?>
		<!-- /English -->
		
		
		<!-- Bahasa -->
		<?php if(array_key_exists('ms', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane " id="pane-ms">


			<div class="form-group <?php echo $model->hasErrors('title_ms') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'title_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_ms'); ?>
					<?php echo $form->bsError($model,'title_ms'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('text_short_description_ms') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'text_short_description_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextArea($model,'text_short_description_ms',array('rows'=>2)); ?>
					<?php echo $form->bsError($model,'text_short_description_ms'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('html_content_ms') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'html_content_ms'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsHtmlEditor($model, 'html_content_ms'); ?>
					<?php echo $form->bsError($model,'html_content_ms'); ?>
				</div>
			</div>

		</div>
		<?php endif; ?>
		<!-- /Bahasa -->
		
		
		<!-- 中文 -->
		<?php if(array_key_exists('zh', Yii::app()->params['backendLanguages'])): ?>
		<div class="tab-pane " id="pane-zh">


			<div class="form-group <?php echo $model->hasErrors('title_zh') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'title_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextField($model, 'title_zh'); ?>
					<?php echo $form->bsError($model,'title_zh'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('text_short_description_zh') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'text_short_description_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsTextArea($model,'text_short_description_zh',array('rows'=>2)); ?>
					<?php echo $form->bsError($model,'text_short_description_zh'); ?>
				</div>
			</div>


			<div class="form-group <?php echo $model->hasErrors('html_content_zh') ? 'has-error':'' ?>">
				<?php echo $form->bsLabelEx2($model,'html_content_zh'); ?>
				<div class="col-sm-10">
					<?php echo $form->bsHtmlEditor($model, 'html_content_zh'); ?>
					<?php echo $form->bsError($model,'html_content_zh'); ?>
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

