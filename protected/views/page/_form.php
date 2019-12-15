<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'page-form',
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
			
	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'slug'); ?>
		<div class="col-sm-10">
							<?php echo $form->bsTextField($model, 'slug', array('disabled'=>$model->is_default?true:false)); ?>
				<?php echo $form->bsError($model,'slug'); ?>
					</div>
	</div>
		
	<div class="form-group <?php echo $model->hasErrors('menu_code') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'menu_code'); ?>
		<div class="col-sm-10">
							<?php echo $form->bsTextField($model, 'menu_code'); ?>
				<?php echo $form->bsError($model,'menu_code'); ?>
					</div>
	</div>
																										
	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_active'); ?>
		<div class="col-sm-10">
							<?php echo $form->bsBooleanList($model, 'is_active'); ?>
				<?php echo $form->bsError($model,'is_active'); ?>
					</div>
	</div>
		

	<ul class="nav nav-tabs">
			<li class="active"><a href="#pane-en" data-toggle="tab">English</a></li>
					<li class=""><a href="#pane-ms" data-toggle="tab">Bahasa</a></li>
					<li class=""><a href="#pane-zh" data-toggle="tab">中文</a></li>
				</ul>
	<div class="tab-content">
			<!-- English -->
		<div class="tab-pane active" id="pane-en">
			
																																						
				<div class="form-group <?php echo $model->hasErrors('title_en') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'title_en'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextField($model, 'title_en'); ?>
						<?php echo $form->bsError($model,'title_en'); ?>
					</div>
				</div>
				
																																					
				<div class="form-group <?php echo $model->hasErrors('text_keyword_en') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'text_keyword_en'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model,'text_keyword_en',array('rows'=>2)); ?>
						<?php echo $form->bsError($model,'text_keyword_en'); ?>
					</div>
				</div>
				
																																					
				<div class="form-group <?php echo $model->hasErrors('text_description_en') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'text_description_en'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model,'text_description_en',array('rows'=>2)); ?>
						<?php echo $form->bsError($model,'text_description_en'); ?>
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
		<!-- /English -->
					<!-- Bahasa -->
		<div class="tab-pane " id="pane-ms">
			
																																																
				<div class="form-group <?php echo $model->hasErrors('title_ms') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'title_ms'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextField($model, 'title_ms'); ?>
						<?php echo $form->bsError($model,'title_ms'); ?>
					</div>
				</div>
				
																																					
				<div class="form-group <?php echo $model->hasErrors('text_keyword_ms') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'text_keyword_ms'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model,'text_keyword_ms',array('rows'=>2)); ?>
						<?php echo $form->bsError($model,'text_keyword_ms'); ?>
					</div>
				</div>
				
																																					
				<div class="form-group <?php echo $model->hasErrors('text_description_ms') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'text_description_ms'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model,'text_description_ms',array('rows'=>2)); ?>
						<?php echo $form->bsError($model,'text_description_ms'); ?>
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
		<!-- /Bahasa -->
					<!-- 中文 -->
		<div class="tab-pane " id="pane-zh">
			
																																																										
				<div class="form-group <?php echo $model->hasErrors('title_zh') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'title_zh'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextField($model, 'title_zh'); ?>
						<?php echo $form->bsError($model,'title_zh'); ?>
					</div>
				</div>
				
																																					
				<div class="form-group <?php echo $model->hasErrors('text_keyword_zh') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'text_keyword_zh'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model,'text_keyword_zh',array('rows'=>2)); ?>
						<?php echo $form->bsError($model,'text_keyword_zh'); ?>
					</div>
				</div>
				
																																					
				<div class="form-group <?php echo $model->hasErrors('text_description_zh') ? 'has-error':'' ?>">
					<?php echo $form->bsLabelEx2($model,'text_description_zh'); ?>
					<div class="col-sm-10">
						<?php echo $form->bsTextArea($model,'text_description_zh',array('rows'=>2)); ?>
						<?php echo $form->bsError($model,'text_description_zh'); ?>
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
		<!-- /中文 -->
				
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->