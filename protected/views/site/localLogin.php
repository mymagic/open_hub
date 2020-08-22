<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::t('app', 'Login');
$this->breadcrumbs = array(
	Yii::t('app', 'Login'),
);
?>

<div class="row bg-white">
	<div class="col-xs-12 white-bg padding-md">
	<br />
	<div class="col-md-7 col-sm-12">
		<h3><?php echo Yii::t('app', 'Welcome!') ?></h3>
		<p><?php echo Yii::t('app', 'Use your social account! One click access with no sign-up required.') ?></p>
		<br />
		<div class="btn-group-justified btn-group text-center" role="group">
			<a class="btn btn-success" href="<?php echo $this->createUrl('hauth/login', array('provider' => 'Facebook'))?>"><?php echo Html::faIcon('fa-facebook-square', array('class' => 'fa-lg')) ?> <?php echo Yii::t('app', 'Facebook') ?></a>
			
			<a class="btn btn-danger" href="<?php echo $this->createUrl('hauth/login', array('provider' => 'Google'))?>"><?php echo Html::faIcon('fa-google-plus', array('class' => 'fa-lg')) ?> <?php echo Yii::t('app', 'Google') ?></a>
		</div>

		<hr class="margin-top-2x margin-bottom-lg" style="border-color:#bbb" />

		<!-- traditional login -->
		<div class="margin-bottom-2x">
		<p><?php echo Yii::t('app', 'or, proceed with traditional login') ?>:</p>
			<div class="">
				<?php $form = $this->beginWidget('ActiveForm', array(
					'id' => 'form-login',
					'htmlOptions' => array(
						'class' => 'form-inline',
						'role' => 'form'
					)
				)); ?>

				<?php if ($model['form']->hasErrors()): ?>
					<?php echo $form->bsErrorSummary($model['form']); ?>
				<?php endif; ?>


				<div class="form-group <?php echo $model['form']->hasErrors('username') ? 'has-error' : '' ?>">
				
					<div class="">
						<div class="input-group"> 
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
							<?php echo $form->bsTextField($model['form'], 'username', array('placeholder' => Yii::t('app', 'Your registered email address'))); ?>
						</div>
					</div>
				</div>
				
				<div class="form-group <?php echo $model['form']->hasErrors('password') ? 'has-error' : '' ?>">
					
					<div class="">
						<div class="input-group"> 
							<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
							<?php echo $form->bsPasswordField($model['form'], 'password', array('placeholder' => Yii::t('app', 'Password'))); ?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="">
						<?php echo $form->bsBtnSubmit(Yii::t('app', 'Log in'), array('class' => 'btn-block')); ?>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</div>

			<p class="margin-top-lg"><?php echo Yii::t('app', 'Not a member? Get an account!')?>&nbsp;<?php echo CHtml::link('Sign-Up', array('site/signup'), array('class' => 'btn btn-xs btn-white')); ?>
			<br />
			<?php echo Yii::t('app', 'Forgot your password?')?>&nbsp;<?php echo CHtml::link('Retrieve here', array('site/lostPassword'), array('class' => 'btn btn-xs btn-white')); ?></p>
		</div>
		<!-- /traditional login -->

		<hr class="margin-top-lg margin-bottom-2x visible-xs" style="border-color:#bbb" />
		
	</div>
</div>
</div>

