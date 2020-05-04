<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs = array(
	'Members' => array('index'),
	'Create',
);

$this->menu = array(
	array(
		'label' => Yii::t('backend', 'Manage Member'), 'url' => array('/member/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('backend', 'Create Member'), 'url' => array('/member/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('backend', 'Create Member'); ?></h1>

<div class="">

<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'member-form',
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


	<div class="form-group <?php echo $model->hasErrors('username') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'username'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsEmailTextField($model, 'username', array('placeholder' => Yii::t('backend', "User's primary email address"))); ?>
			<?php echo $form->bsError($model, 'username'); ?>
		</div>
	</div>


	<div class="form-group <?php echo $model->hasErrors('first_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'first_name'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'first_name', array('placeholder' => Yii::t('backend', "User's first name as per IC"))); ?>
			<?php echo $form->bsError($model, 'first_name'); ?>
		</div>
	</div>

	<div class="form-group <?php echo $model->hasErrors('last_name') ? 'has-error' : '' ?>">
		<?php echo $form->bsLabelEx3($model, 'last_name'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model, 'last_name', array('placeholder' => Yii::t('backend', "User's last name as per IC"))); ?>
			<?php echo $form->bsError($model, 'last_name'); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo $form->bsBtnSubmit($model->isNewRecord ? Yii::t('core', 'Create') : Yii::t('core', 'Save')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->