<?php
$this->pageTitle = Yii::t('app', 'Sign-up');
$this->breadcrumbs = array(
	Yii::t('app', 'Sign-up'),
);
?>

<div class="center-block">
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
		<?php $form = $this->beginWidget('ActiveForm', array(
			'id' => 'form-signup',
			'htmlOptions' => array(
				'class' => 'form-horizontal well bg-white',
				'role' => 'form'
			)
		)); ?>
			
		<?php if ($model['form']->hasErrors()): ?>
			<?php //echo $form->bsErrorSummary($model['form']);?>
		<?php endif; ?>
		
		<div class="row">
			<div class="col-sm-12 text-center">
				<p class="lead"><small><?php echo Yii::t('app', 'Start by creating an account here.') ?></small></p>
			</div>
		</div>
		
		<div class="hr-line-dashed margin-top-xs"></div>

		<div class="form-group <?php echo $model['form']->hasErrors('email') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx3($model['form'], 'email'); ?>
			<div class="col-sm-9">
				<?php echo $form->bsEmailTextField($model['form'], 'email', array('placeholder' => Yii::t('app', 'Please enter your primary email address'))); ?>
				<?php echo $form->bsError($model['form'], 'email'); ?>
			</div>
		</div>

		<div class="form-group <?php echo $model['form']->hasErrors('cemail') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx3($model['form'], 'cemail'); ?>
			<div class="col-sm-9">
				<?php echo $form->bsEmailTextField($model['form'], 'cemail', array('placeholder' => Yii::t('app', 'Please retype the email address'))); ?>
				<?php echo $form->bsError($model['form'], 'cemail'); ?>
			</div>
		</div>

		<div class="form-group <?php echo $model['form']->hasErrors('fullname') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelEx3($model['form'], 'fullname'); ?>
			<div class="col-sm-9">
				<?php echo $form->bsTextField($model['form'], 'fullname', array('placeholder' => Yii::t('app', 'Please insert your full name'))); ?>
				<?php echo $form->bsError($model['form'], 'fullname'); ?>
			</div>
		</div>


		<?php if (CCaptcha::checkRequirements()): ?>
		<div class="form-group <?php echo $model['form']->hasErrors('verifyCode') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelFx3($model['form'], 'verifyCode', array('required' => true)); ?>
			<div class="col-sm-9 text-left">
				<p><?php $this->widget('CCaptcha', array('captchaAction' => '/site/captcha', 'buttonLabel' => 'Refresh Image', 'buttonOptions' => array('class' => 'btn btn-white btn-xs margin-left-sm'))); ?></p>
				<p><?php echo $form->bsTextField($model['form'], 'verifyCode', array('placeholder' => Yii::t('app', 'Please insert the text displayed above to proof you are human'))); ?></p>
				<?php echo $form->bsError($model['form'], 'verifyCode'); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="form-group">
			<?php echo $form->bsLabelEx3($model['form'], '');?>
			<div class="col-sm-9">
				<?php echo Html::htmlArea('tocContent', $model['form']->tocContent, array('rows' => 3, 'style' => 'height:100px'))?>
			</div>
		</div>

		<div class="form-group <?php echo $model['form']->hasErrors('agreeToc') ? 'has-error' : ''?>">
			<div class="col-sm-offset-3 col-sm-9">
				<label>
					<?php echo $form->checkbox($model['form'], 'agreeToc');?> <?php echo $form->labelEx($model['form'], 'agreeToc')?>
				</label>
				<?php echo $form->bsError($model['form'], 'agreeToc');?>
			
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-9 col-sm-offset-3 text-left">
				<p><?php echo $form->bsBtnSubmit(Yii::t('app', 'Create Account'), array('class' => 'btn-lg')); ?> <small class="margin-left-lg text-muted"><?php echo Html::link(Yii::t('app', 'or Login'), $this->createUrl('/site/localLogin')) ?></small></p>
			</div>
		</div>

		<?php $this->endWidget(); ?>
	</div>

</div>
</div>

