<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::t('app', 'Login');
$this->breadcrumbs = array(
	Yii::t('app', 'Login'),
);
?>

<div class="loginColumns">
<div class="row">

	<div class="col-lg-6 text-center">
		<br />
		<?php echo Html::image('/images/logo.png', 'MaGIC Orang', array('class' => 'img-responsive-full', 'id' => 'logo-magicOrang', 'style' => 'max-width:450px')) ?>
		<br />
		<!--<h2 class="font-bold lead">Title</h2>-->
		<p>Get direct access to skilled talent in our ecosystem.</p>
	</div>
	
	<div class="col-lg-6">
		<div class="ibox-content">
			<?php $form = $this->beginWidget('ActiveForm', array(
				'id' => 'form-login',
				'htmlOptions' => array(
					'class' => 'm-t',
					'role' => 'form'
				)
			)); ?>
				<?php if ($model['form']->hasErrors()): ?>
					<?php echo $form->bsErrorSummary($model['form']); ?>
				<?php endif; ?>
				
				<div class="form-group">
					<?php echo $form->bsTextField($model['form'], 'username', array('placeholder' => Yii::t('app', 'Email'))); ?>
				</div>
				<div class="form-group">
					<?php echo $form->bsPasswordField($model['form'], 'password', array('placeholder' => Yii::t('app', 'Password'))); ?>
				</div>
				
				<button type="submit" class="btn btn-primary block full-width m-b"><?php echo Yii::t('app', 'Login') ?></button>
			
				
				<small><?php echo CHtml::link(Yii::t('app', 'Forgot password?'), array('site/lostPassword')); ?></small>
				
				<p class="text-muted text-center">
					<small></small>
				</p>
				<!--<a class="btn btn-sm btn-white btn-block" href="<?php echo $this->createUrl('site/signup') ?>">New user? Create an account.</a>-->
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
</div>

