<?php

$this->pageTitle = Yii::t('app', 'Lost Password');
$this->breadcrumbs = array(
	Yii::t('app', 'Lost Password'),
);
?>

<div class="row">
	<div class="col-md-8">
		
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo Yii::t('app', 'Lost Password') ?></div>
			<div class="panel-body">

				<?php $form = $this->beginWidget('ActiveForm', array(
					'id' => 'form-lostPassword',
					'htmlOptions' => array(
						'class' => 'form-horizontal',
						'role' => 'form'
					)
				)); ?>
				
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

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<p><?php echo $form->bsBtnSubmit(Yii::t('app', 'Retrieve'), array('class' => 'btn-lg')); ?></p>
					</div>
				</div>

				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<h3 class="text-highlight nopadding margin-bottom-lg"><?php echo $model['embedLostPassword']->getAttrData('title') ?></h3>
		<div><?php echo $model['embedLostPassword']->getAttrData('html_content') ?></div>
	</div>
</div>
