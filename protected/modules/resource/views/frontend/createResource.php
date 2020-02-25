<?php
$this->breadcrumbs = array(
	'Resource Directory' => array('//resource'),
	'Add New Resource'
);

?>

<section class="container margin-top-lg">


<div class="col col-sm-9 margin-top-lg">
<h2>Create New Resource</h2>
<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'resource-form',
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

	<div class="form-group <?php echo $model->hasErrors('organization') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextHolder($organization, 'title'); ?>
			<?php echo $form->bsError($model, 'organization'); ?>
		</div>
	</div>
	

	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>

	<?php if (!$model->isNewRecord):?>
	<div class="form-group <?php echo $model->hasErrors('slug') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'slug'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'slug'); ?>
			<?php echo $form->bsError($model, 'slug'); ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="form-group <?php echo $model->hasErrors('typefor') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'typefor'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'typefor'); ?>
			<?php echo $form->bsError($model, 'typefor'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('inputResourceCategories') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputResourceCategories'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputResourceCategories', Html::listData(ResourceCategory::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputResourceCategories'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('html_content') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'html_content'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsHtmlMiniEditor($model, 'html_content'); ?>
			<?php echo $form->bsError($model, 'html_content'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_logo') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_logo'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_logo'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_logo'); ?>
			<?php echo $form->bsError($model, 'image_logo'); ?>
			</div>
		</div>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('url_website') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'url_website'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'url_website'); ?>
			<?php echo $form->bsError($model, 'url_website'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('full_address') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'full_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_address'); ?>
			<?php echo $form->bsError($model, 'full_address'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('latlong_address') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'latlong_address'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsGeoPointField($model, 'latlong_address', array('readonly' => 'readonly', 'isGeoCodingEnabled' => true, 'geoCodingAddress' => $model->full_address, 'mapZoom' => 10)); ?>
			<p class="help-block">Please double click on map to set the marker</p>
			<?php echo $form->bsError($model, 'latlong_address'); ?>
		</div>
	</div>


	<?php if ($realm == 'backend'): ?>
	<div class="form-group <?php echo $model->hasErrors('is_featured') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_featured'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_featured'); ?>
			<?php echo $form->bsError($model, 'is_featured'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>
	<?php endif; ?>




		
	<!-- many2many -->

	<div class="form-group <?php echo $model->hasErrors('inputIndustries') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputIndustries'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputIndustries', Html::listData(Industry::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputIndustries'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputPersonas') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputPersonas'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputPersonas', Html::listData(Persona::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputPersonas'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('inputStartupStages') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputStartupStages'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputStartupStages', Html::listData(StartupStage::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputStartupStages'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('inputResourceGeofocuses') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'inputResourceGeofocuses'); ?>
		<div class="col-sm-10">
			<?php echo $form->dropDownList($model, 'inputResourceGeofocuses', Html::listData(ResourceGeofocus::getForeignReferList()), array('class' => 'chosen form-control', 'multiple' => 'multiple')); ?>
			<?php echo $form->bsError($model, 'inputResourceGeofocuses'); ?>
		</div>
	</div>
	<!-- /many2many -->

	<div class="form-group">
		<div class="pull-right margin-top-lg margin-bottom-2x">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create Resource') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScript('google-map', '

	$(document).on("change", "#Resource_full_address", function(e){$("#geoCoding-address-Resource_latlong_address").val($(this).val());});
'); ?>



</div>

</section>
    