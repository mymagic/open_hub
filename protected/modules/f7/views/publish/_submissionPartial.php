<?php if($model->hasUserSubmission(Yii::app()->user->id)):?>
<h4>Your Submissions</h4>
<div class="ibox-content m-b-sm border-bottom gray-bg">
	<?php $n=1; $submissions = $model->getUserSubmission(Yii::app()->user->id); 
	foreach($submissions as $submission): ?>	
		<div class="faq-item">
			#<?php echo $n ?>
			<span class="badge badge-<?php echo ($submission->status=='submit')?'primary':'warning' ?>"><?php echo $submission->formatEnumStatus($submission->status) ?></span>
			<span class="badge badge-default"><?php echo $submission->formatEnumStage($submission->stage) ?></span>
			<small>
			<?php if(!empty($submission->date_submitted)):?>
				Last Submitted on 
				<?php echo Html::formatDateTimezone($submission->date_submitted, 'standard', 'standard', '-', $model->timezone); ?>
			<?php elseif(!empty($submission->date_modified)): ?>
				Last Modified on 
				<?php echo Html::formatDateTimezone($submission->date_modified, 'standard', 'standard', '-', $model->timezone) ?>
			<?php endif; ?>
			</small>
			<span style="margin-left:1em">
			<a class="btn btn-white btn-xs" href="<?php echo sprintf("%s/%s",$model->getPublicUrlView(),$submission->id) ?>" style="">View</a>
			<?php if(!$model->isApplicationClosed()):?>
				<a class="btn btn-primary btn-xs" href="<?php echo sprintf("%s/%s",$model->getPublicUrlConfirm(),$submission->id) ?>" style="">Edit</a>
			<?php endif; ?>
			</span>
		</div>
	<?php $n++; endforeach; ?>	
</div>
<?php endif; ?>