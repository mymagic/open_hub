<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::t('app', 'Login');
$this->breadcrumbs = array(
	Yii::t('app', 'Login'),
);
?>


	<div class="center-block">
		<?php $form = $this->beginWidget('ActiveForm', array(
					'id' => 'form-login',
					'htmlOptions' => array(
						'class' => 'form-horizontal',
						'role' => 'form'
					)
				)); ?>
				
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo Yii::t('app', 'Login') ?></div>
			<div class="panel-body">

				
				<?php if ($model['form']->hasErrors()): ?>
					<?php echo $form->bsErrorSummary($model['form']); ?>
				<?php endif; ?>


				<div class="form-group <?php echo $model['form']->hasErrors('username') ? 'has-error' : '' ?>">
					<?php echo $form->bsLabelEx3($model['form'], 'username'); ?>
					<div class="col-sm-9">
						<div class="input-group"> 
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
							<?php echo $form->bsTextField($model['form'], 'username', array('placeholder' => Yii::t('app', 'Your registered email address'))); ?>
						</div>
					</div>
				</div>
				
				<div class="form-group <?php echo $model['form']->hasErrors('password') ? 'has-error' : '' ?>">
					<?php echo $form->bsLabelEx3($model['form'], 'password'); ?>
					<div class="col-sm-9">
						<?php echo $form->bsPasswordField($model['form'], 'password'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-3">
						<?php echo $form->bsBtnSubmit(Yii::t('app', 'Log in')); ?>
					</div>
					<div class="col-sm-7">
						<!--<div class="checkbox"><label><?php echo $form->checkbox($model['form'], 'rememberMe'); ?> <?php echo $form->labelEx($model['form'], 'rememberMe') ?></label></div>-->
					</div>
				</div>
			
			</div>
			<div class="panel-footer text-right">
				
				<p class="text-muted"><small><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;<?php echo Yii::t('app', 'Keep your login information safe') ?></small></p>
				
			</div>
			
		</div>
		<?php $this->endWidget(); ?>
	</div>


