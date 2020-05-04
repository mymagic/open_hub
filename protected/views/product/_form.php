<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form-new">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'product-form',
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


	<div class="form-group <?php echo $model->hasErrors('organization_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'organization_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextHolder($model->organization, 'title'); ?>
			<?php echo $form->bsError($model, 'organization_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('product_category_id') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'product_category_id'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'product_category_id', array('nullable' => true)); ?>
			<?php echo $form->bsError($model, 'product_category_id'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('title') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'title'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'title'); ?>
			<?php echo $form->bsError($model, 'title'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('text_short_description') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'text_short_description'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextArea($model, 'text_short_description', array('rows' => 2)); ?>
			<?php echo $form->bsError($model, 'text_short_description'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('typeof') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'typeof'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'typeof'); ?>
			<?php echo $form->bsError($model, 'typeof'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('image_cover') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'image_cover'); ?>
		<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-2 text-left">
			<?php echo Html::activeThumb($model, 'image_cover'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo Html::activeFileField($model, 'imageFile_cover'); ?>
			<?php echo $form->bsError($model, 'image_cover'); ?>
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

	<div class="form-group <?php echo ($model->hasErrors('price_min') || $model->hasErrors('price_max')) ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'price'); ?>
		<div class="col-sm-10 nopadding">
			<div class="col-xs-12 col-sm-6">
				<div class="input-group">
					<span class="input-group-addon" style="background:none; border:none">Minimum</span>
					<span class="input-group-addon"><?php echo Yii::app()->params['sourceCurrency'] ?></span>
					<?php echo $form->bsTextField($model, 'price_min'); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<div class="input-group">
					<span class="input-group-addon" style="background:none; border:none">Maximum</span>
					<span class="input-group-addon"><?php echo Yii::app()->params['sourceCurrency'] ?></span>
					<?php echo $form->bsTextField($model, 'price_max'); ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12">
				<p class="help-block">If the product only have one distinct value, insert the same to both min and max.</p>
				<?php echo $form->bsError($model, 'price_min'); ?>
				<?php echo $form->bsError($model, 'price_max'); ?>
			</div>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'is_active'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsBooleanList($model, 'is_active'); ?>
			<?php echo $form->bsError($model, 'is_active'); ?>
		</div>
	</div>

	<?php // if (Yii::app()->user->accessBackend && Yii::app()->user->isDeveloper):?>
	<?php if (Yii::app()->user->accessBackend && HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'developer']])):?>
	<?php echo Notice::inline(Yii::t('notice', 'Meta Data Only accessible by developer role'), Notice_WARNING) ?>
	<?php $this->renderPartial('../../yeebase/views/metaStructure/_sharedForm', array('form' => $form, 'model' => $model)); ?>
	<?php endif; ?>

	<div class="form-group">
		<div class="pull-right margin-top-lg margin-right-lg">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->