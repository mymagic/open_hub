<?php
/* @var $this IndustryKeywordController */
/* @var $model IndustryKeyword */

$this->breadcrumbs = array(
	'Industry Keywords' => array('index'),
	Yii::t('backend', 'Create'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage IndustryKeyword'), 'url' => array('/industryKeyword/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Bulk Create Industry Keyword'); ?></h1>

<?php
/* @var $this IndustryKeywordController */
/* @var $model IndustryKeyword */
/* @var $form CActiveForm */
?>


<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'industry-keyword-form',
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



<div class="form-group <?php echo $model->hasErrors('industry_code') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx2($model, 'industry_code'); ?>
		<div class="col-sm-10">
			<?php echo $form->bsForeignKeyDropDownList($model, 'industry_code', array('params' => array('key' => 'code'))); ?>
			<?php echo $form->bsError($model, 'industry_code'); ?>
		</div>
	</div>

    <?php for ($i = 0; $i < 10; $i++): ?>
	<div class="form-group">
		<div class="col-sm-2 text-right">Title <?php echo $i + 1 ?></div>
		<div class="col-sm-10">
			<?php echo $form->bsTextField($model, 'inputTitles[]'); ?>
			<?php echo $form->bsError($model, 'inputTitles[]'); ?>
		</div>
	</div>
    <?php endfor; ?>


	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit(Yii::t('core', 'Create')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

