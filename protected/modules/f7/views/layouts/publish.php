<?php $this->beginContent('layouts.frontend'); ?>
<?php $model = $this->layoutParams['form']; ?>

<div id="f7-publish">
<div class="row">
	<div class="col-lg-<?php echo $model->hasIntake() ? '8' : '12' ?>">
		<div class="wrapper wrapper-content">
			<div class="">

				<?php $this->renderPartial('layouts._translate') ?>
				<h2><?php echo $model->title ?></h2>
				
				<p class="small">This form is open from <strong><?php echo Html::formatDateTimezone($model->date_open, 'standard', 'short', '', $model->getTimezone()) ?></strong> to <strong><?php echo Html::formatDateTimezone($model->date_close, 'standard', 'short', '', $model->getTimezone()) ?></strong>.<span class="hidden text-warning">You will be blocked from submitting outside this date range.</span></p>
				
				<p><?php echo Html::encodeDisplay(strip_tags($model->text_short_description)) ?></p>
                
                <?php echo $content; ?>

			</div>
		</div>
	</div>
	

    <?php if ($model->hasIntake()):?>
	<div class="col-lg-4">
		<div class="wrapper wrapper-content project-manager">
			
			<?php if (!empty($model->getIntake()->image_logo)): ?>
				<?php echo Html::thumb(StorageHelper::getUrl($model->getIntake()->image_logo), array('class' => 'img-responsive margin-bottom-lg'))?>
			<?php endif; ?>

			<div class="job_provider_info">
				<h4><?php echo $model->getIntake()->title ?></h4>
				<?php if (!empty($model->getIntake()->text_oneliner)): ?>
					<p><?php echo $model->getIntake()->text_oneliner ?></p>
				<?php endif; ?>
				
				<div>
				<?php if (!empty($model->getIntake()->text_short_description)): ?>
					<?php echo nl2br($model->getIntake()->text_short_description) ?>
				<?php endif; ?>
				</div>
			</div>
			
			<?php if ((isset($model->jsonArray_extra->viewControls) && $model->jsonArray_extra->viewControls->hideAvailableFormForIntake)): ?>
			<?php else: ?>
			<div>
			<h5>Available forms for this intake</h5>
			<ul class="job_provider_vacancy">
				<?php $activeForms = $model->getIntake()->activeForms; foreach ($activeForms as $activeForm): ?>
				<?php if ($activeForm->isAvailableForPublic()): ?>
				<li class="<?php if ($activeForm->slug == $model->slug): ?>bg-success<?php endif; ?>">
					<a href="<?php echo $activeForm->getPublicUrl() ?>">
					<strong><?php echo $activeForm->title ?></strong><br />
					</a>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
				
			</ul>
			</div>
			<?php endif; ?>
			
		</div>
	</div>
	<?php endif; ?>
</div>
</div>
<?php $this->endContent(); ?>


<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/publish.css'); ?>