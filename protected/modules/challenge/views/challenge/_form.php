<?php
/* @var $this ChallengeController */
/* @var $model Challenge */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'challenge-form',
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

<?php echo Notice::inline(Yii::t('core', 'Fields with <span class="required">*</span> are required.')); ?>
<?php if($model->hasErrors()): ?>
	<?php echo $form->bsErrorSummary($model); ?>
<?php endif; ?>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model,'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_short_description',array('rows'=>2)); ?>
			<?php echo $form->bsError($model,'text_short_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_cover') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'image_cover'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_cover'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_cover'); ?>
			<?php echo $form->bsError($model,'image_cover'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_header') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'image_header'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_header'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_header'); ?>
			<?php echo $form->bsError($model,'image_header'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('url_video') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'url_video'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_video'); ?>
			<?php echo $form->bsError($model,'url_video'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('url_application_form') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'url_application_form'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_application_form'); ?>
			<?php echo $form->bsError($model,'url_application_form'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('html_content') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'html_content'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsHtmlEditor($model, 'html_content'); ?>
			<?php echo $form->bsError($model,'html_content'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('html_deliverable') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'html_deliverable'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsHtmlEditor($model, 'html_deliverable'); ?>
			<?php echo $form->bsError($model,'html_deliverable'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('html_criteria') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'html_criteria'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsHtmlEditor($model, 'html_criteria'); ?>
			<?php echo $form->bsError($model,'html_criteria'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('prize_title') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'prize_title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'prize_title'); ?>
			<?php echo $form->bsError($model,'prize_title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('html_prize_detail') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'html_prize_detail'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsHtmlEditor($model, 'html_prize_detail'); ?>
			<?php echo $form->bsError($model,'html_prize_detail'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_open') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'date_open'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model,'date_open', array('nullable'=>true)); ?>
			<?php echo $form->bsError($model,'date_open'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('date_close') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'date_close'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsDateTextField($model,'date_close', array('nullable'=>true)); ?>
			<?php echo $form->bsError($model,'date_close'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('timezone') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'timezone'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'timezone'); ?>
			<?php echo $form->bsError($model,'timezone'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('owner_organization_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'owner_organization_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'owner_organization_id'); ?>
			<?php echo $form->bsError($model, 'owner_organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('creator_user_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'creator_user_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'creator_user_id'); ?>
			<?php echo $form->bsError($model, 'creator_user_id'); ?>
		</div>
	</div>



	<!-- many2many -->

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class'=>'chosen form-control', 'multiple'=>'multiple')); ?>
			<?php echo $form->bsError($model,'inputIndustries'); ?>
		</div>
	</div>
	<!-- /many2many -->
	
	<div class="form-group <?php echo $model->hasErrors('text_remark') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'text_remark'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model,'text_remark',array('rows'=>2)); ?>
			<?php echo $form->bsError($model,'text_remark'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('status') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'status'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'status'); ?>
			<?php echo $form->bsError($model,'status'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model,'is_active'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_publish') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_publish'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_publish'); ?>
			<?php echo $form->bsError($model,'is_publish'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_highlight') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model,'is_highlight'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_highlight'); ?>
			<?php echo $form->bsError($model,'is_highlight'); ?>
		</div>
	</div>



			
	<div class="form-group <?php echo $model->hasErrors('tag_backend') ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx2($model, 'tag_backend'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'tag_backend', array('id'=>'Challenge-tag_backend', 'class'=>'form-control csv_tags')) ?>
			<?php echo $form->bsError($model, 'tag_backend') ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

