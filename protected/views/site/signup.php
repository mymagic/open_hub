<?php
$this->pageTitle = Yii::t('app', 'Sign-up');
$this->breadcrumbs = array(
	Yii::t('app', 'Sign-up'),
);
?>

<div id="box-signup">
<div class="center-block">
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		
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
			<div class="col-sm-3">
				<?php echo Html::image('/images/logo.png', 'MaGIC Profile', array('class' => 'img-responsive-full margin-md')) ?>
			</div>
			<div class="col-sm-9 text-left">
				<p class="lead">Get your MaGIC portfolio<br /> <small>Start by creating an account here.</small></p>
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


		<?php if (CCaptcha::checkRequirements()): ?>
		<div class="form-group <?php echo $model['form']->hasErrors('verifyCode') ? 'has-error' : '' ?>">
			<?php echo $form->bsLabelFx3($model['form'], 'verifyCode', array('required' => true)); ?>
			<div class="col-sm-9 text-left">
				<p><?php $this->widget('CCaptcha', array('captchaAction' => '/site/captcha', 'buttonLabel' => 'Refresh Image', 'buttonOptions' => array('class' => 'btn btn-default btn-sm margin-left-sm'))); ?></p>
				<p><?php echo $form->bsTextField($model['form'], 'verifyCode', array('placeholder' => Yii::t('app', 'Please enter the characters displayed in the image above'))); ?></p>
				<?php echo $form->bsError($model['form'], 'verifyCode'); ?>
			</div>
		</div>
		<?php endif; ?>
		
		
		<!--
		<div class="form-group <?php //echo $model['form']->hasErrors("agreetoc") ? 'has-error':''?>">
			<?php //echo $form->bsLabelEx3($model['form'], '');?>
			<div class="col-sm-9">
				<?php //echo Html::htmlArea('tocContent', $model['form']->tocContent)?>
			</div>
		</div>

		<div class="form-group <?php //echo $model['form']->hasErrors("agreetoc") ? 'has-error':''?>">
			<div class="col-sm-offset-3 col-sm-9">
			<div class="checkbox">
				<label>
					<?php //echo $form->checkbox($model['form'],'agreetoc');?> <?php //echo $form->labelEx($model['form'],'agreetoc')?>
				</label>
			</div>
			
			<?php //echo $form->bsError($model['form'],'agreetoc');?>
			</div>
		</div> -->

		<div class="form-group">
			<div class="col-sm-9 col-sm-offset-3 text-left">
				<p><?php echo $form->bsBtnSubmit(Yii::t('app', 'Sign-up')); ?> <small class="margin-left-lg text-muted"><?php echo Html::link(Yii::t('app', 'or Login'), $this->createUrl('/site/login')) ?></small></p>
			</div>
		</div>

		<?php $this->endWidget(); ?>
	</div>

</div>
</div>
</div>

