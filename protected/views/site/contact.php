<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
$this->pageTitle= Yii::t('app', 'Contact Us');
$this->breadcrumbs=array(
	Yii::t('app', 'Contact'),
);
?>

<?php echo Html::pageHeader(Yii::t('app', 'Contact Us')); ?>

<div class="row">
<div class="col-md-9">


<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'form-contact',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array
	(
		'class'=>'form-horizontal',
		'role'=>'form'
	)
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->bsErrorSummary($model['form']); ?>

	<div class="form-group <?php echo $model['form']->hasErrors("email") ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model['form'], 'email'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsEmailTextField($model['form'], 'email', array('placeholder'=>Yii::t('app', 'Please enter your primary email address'))); ?>
			<?php echo $form->bsError($model['form'], 'email'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model['form']->hasErrors("subject") ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model['form'], 'subject'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextField($model['form'], 'subject'); ?>
			<?php echo $form->bsError($model['form'], 'subject'); ?>
		</div>
	</div>
	
	<div class="form-group <?php echo $model['form']->hasErrors("body") ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model['form'], 'body'); ?>
		<div class="col-sm-9">
			<?php echo $form->bsTextArea($model['form'], 'body'); ?>
			<?php echo $form->bsError($model['form'], 'body'); ?>
		</div>
	</div>
	
	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="form-group <?php echo $model['form']->hasErrors("verifyCode") ? 'has-error':'' ?>">
		<?php echo $form->bsLabelEx3($model['form'],'verifyCode'); ?>
		<div class="col-sm-9">
			<p><?php $this->widget('CCaptcha', array('captchaAction' => '/site/captcha')); ?></p>
			<p><?php echo $form->bsTextField($model['form'], 'verifyCode', array('placeholder'=>'Please enter the letters as they are shown in the following image')); ?></p>
			<?php echo $form->bsError($model['form'],'verifyCode'); ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<?php echo $form->bsBtnSubmit(Yii::t('app', 'Submit')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
</div>
<div class="col-md-3">
	Todo...
</div>
</div>