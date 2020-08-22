<?php
$this->breadcrumbs = array(
	Yii::t('app', 'Backend') => array('index'),
	Yii::t('app', 'Update Account'),
);
$this->menu = array(
	array('label' => Yii::t('app', 'My Account'), 'url' => array('/backend/me')),
	array('label' => Yii::t('app', 'Update Account'), 'url' => array('/backend/updateAccount'), 'linkOptions' => array('target' => '_blank')),
	//array('label'=>Yii::t('app', 'Change Password'), 'url'=>array('/backend/changePassword'))
);
?>

<h1><?php echo Yii::t('app', 'Update Account') ?></h1>

<div class="">
<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'profile-form',
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

	<div class="form-group <?php echo $model->hasErrors('full_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'full_name'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'full_name'); ?>
			<?php echo $form->bsError($model, 'full_name'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('gender') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'gender'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsEnumDropDownList($model, 'gender'); ?>
			<?php echo $form->bsError($model, 'gender'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('mobile_no') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'mobile_no'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'mobile_no'); ?>
			<?php echo $form->bsError($model, 'mobile_no'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('fax_no') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'fax_no'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'fax_no'); ?>
			<?php echo $form->bsError($model, 'fax_no'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('address_line1') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'address_line1'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'address_line1'); ?>
			<?php echo $form->bsError($model, 'address_line1'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('address_line2') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'address_line2'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'address_line2'); ?>
			<?php echo $form->bsError($model, 'address_line2'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('town') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'town'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'town'); ?>
			<?php echo $form->bsError($model, 'town'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('state') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'state'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'state'); ?>
			<?php echo $form->bsError($model, 'state'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('postcode') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'postcode'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'postcode'); ?>
			<?php echo $form->bsError($model, 'postcode'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model->hasErrors('country_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'country_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'country_code'); ?>
			<?php echo $form->bsError($model, 'country_code'); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('app', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->