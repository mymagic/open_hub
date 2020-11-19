<div id="site-profileView">
<div class="col col-sm-10 col-sm-offset-1 text-center">
    <?php echo Html::image($model->getImageAvatarThumbUrl(150, 150), $model->display_name, array('class' => 'noborder img-circle', 'width' => 150, 'height' => 150)) ?>
	<h1 class="margin-top-lg"><?php echo Html::encode($model->display_name) ?></h1>
	<p>
		<span class="text-subline text-info"><?php //echo Html::encode($model->jobr->title)?></span>
		<?php if (!empty($model->at)): ?><strong> at <?php echo Html::encode($model->at) ?></strong><?php endif; ?>
	<p>
	<div id="profileView-socialLink">
		<ul>
			<?php if (!empty($model->url_website)): ?><li><a href="<?php echo $model->url_website ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-globe fa-inverse fa-stack-1x') ?></span> My Website</a></li><?php endif; ?>
			<?php if (!empty($model->url_linkedin)): ?><li><a href="<?php echo $model->url_linkedin ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-linkedin fa-inverse fa-stack-1x') ?></span> Linkedin</a></li><?php endif; ?>
			<?php if (!empty($model->url_facebook)): ?><li><a href="<?php echo $model->url_facebook ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-facebook fa-inverse fa-stack-1x') ?></span> Facebook</a></li><?php endif; ?>
			<?php if (!empty($model->url_twitter)): ?><li><a href="<?php echo $model->url_twitter ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-twitter fa-inverse fa-stack-1x') ?></span> Twitter</a></li><?php endif; ?>
			<?php if (!empty($model->url_github)): ?><li><a href="<?php echo $model->url_github ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-github fa-inverse fa-stack-1x') ?></span> Github</a></li><?php endif; ?>
			<?php if (!empty($model->url_stackoverflow)): ?><li><a href="<?php echo $model->url_stackoverflow ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-stack-overflow fa-inverse fa-stack-1x') ?></span> Stackoverflow</a></li><?php endif; ?>
		</ul>
	</div>
	<div id="profileView-shortDesc">
		<?php echo nl2br(Html::encode($model->text_short_description)) ?>
	</div>
</div>

<div class="col col-sm-7 col-sm-offset-1">
	<div id="profileView-mainBox" class="rounded-md margin-bottom-3x">
	<ul class="fa-ul">
		<li>
			<?php echo Html::faIcon('fa-map-marker fa-lg fa fa-li') ?>
			<span class="dd">
				<?php if (!empty($model->location)): ?><?php echo $model->location ?>, <?php endif;?> 
				<?php if (!empty($model->state->title)): ?><?php echo $model->state->title ?>,<?php endif;?> 
				<?php echo $model->country->printable_name ?>
			</span>
		</li>
		<?php if (!empty($model->highAcademyExperience)): ?>
		<li>
			<?php echo Html::faIcon('fa-graduation-cap fa-lg fa fa-li') ?>
			<span class="dd"><?php echo $model->highAcademyExperience->title ?> <?php if (!empty($model->highAcademyExperience->at)): ?> at <?php echo $model->highAcademyExperience->at ?><?php endif; ?></span>
		</li>
		<?php endif; ?>
		<?php if (!empty($attendedPrograms)): ?>
		<li>
			<?php echo Html::faIcon('fa-star fa-lg fa fa-li text-warning') ?>
			<div class="dd">
				<?php $count = 0; $limit = 5; $total = count($attendedPrograms); foreach ($attendedPrograms as $p): ?>
					<?php if ($count < $limit): ?>
						<?php echo $p['title'] ?><br />
						<?php $count++; ?>						
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if ($total > $limit): ?>
					<span class="text-muted text-sm"><i>and <?php echo $total - $limit ?> more...</i></span>
				<?php endif; ?>
			</div>
		</li>
		<?php endif; ?>
	</ul>
	
	<?php if (!empty($skillsets)): ?>
	<hr />
	<h4>SKILLS</h4>
		<div id="skillsets">
		<?php foreach ($skillsets as $skillset): ?>
			<span class="label label-info"><?php echo ucwords($skillset) ?></span>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>
	</div>
	
	<?php if (!empty($items)): ?>
	<h2>MY EXPERIENCE</h2>
	<?php foreach ($items as $item): ?>
		<div class="box-experience rounded-md <?php if ($item['is_endorsed']): ?>box-experience-endorsed<?php endif; ?>">
		<div class="row">
			<div class="col col-sm-1"><?php echo Html::faIcon(sprintf('%s fa-2x', $item['faIcon'])) ?></div>
			<div class="col col-sm-11">
				<h3><span class="text-slim"><?php echo $item['title'] ?><?php if (!empty($item['at'])): ?> at <?php endif; ?></span> <?php if (!empty($item['at'])): ?><?php echo $item['at'] ?><?php endif; ?></h3>
				<p class="text-muted">
					<?php if (!empty($item['month_start'])): ?><?php echo ysUtil::monthNumber2Name($item['month_start']) ?> <?php endif; ?><?php echo $item['year_start'] ?> 
					<?php if ((!empty($item['year_end']) && !empty($item['month_end'])) && ($item['year_end'] != $item['year_start']) && $item['month_end'] != $item['month_start']): ?>- <?php echo ysUtil::monthNumber2Name($item['month_end']) ?> <?php echo $item['year_end'] ?><?php endif; ?>
				</p>
				<div class="text-shortDesc"><?php echo nl2br(Html::encode($item['text_short_desc'])) ?></div>
				<?php if ($item['is_endorsed']): ?><span class="endorsed"><?php echo Html::image('/images/endorsed.png') ?></span><?php endif; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
	
</div>

<div class="col col-sm-3">
	<div id="profileView-subBox" class="rounded-md">
		<h3><?php echo Html::faIcon('fa-briefcase fa-inverse') ?>&nbsp;&nbsp;I'M LOOKING FOR</h3>
		<ul>
			<?php if ($model->is_looking_fulltime): ?><li><?php echo Html::faIcon('fa-check text-info') ?> Full Time</li><?php endif; ?>
			<?php if ($model->is_looking_contract): ?><li><?php echo Html::faIcon('fa-check text-info') ?> Contract</li><?php endif; ?>
			<?php if ($model->is_looking_freelance): ?><li><?php echo Html::faIcon('fa-check text-info') ?> Freelance</li><?php endif; ?>
			<?php if ($model->is_looking_cofounder): ?><li><?php echo Html::faIcon('fa-check text-info') ?> Co-Founder</li><?php endif; ?>
			<?php if ($model->is_looking_internship): ?><li><?php echo Html::faIcon('fa-check text-info') ?> Internship</li><?php endif; ?>
			<?php if ($model->is_looking_apprenticeship): ?><li><?php echo Html::faIcon('fa-check text-info') ?> Apprenticeship</li><?php endif; ?>
		</ul>
		<div class="text-center hidden"><a class="btn btn-info" data-toggle="modal" data-target="#modal-contact">CONTACT ME</a></div>
	</div>
</div>

</div>



<div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="modalLabel-contact">
<div class="modal-dialog">
<?php $form = $this->beginWidget('ActiveForm', array(
	'id' => 'form-contactProfile',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Contact <?php echo $model->display_name ?></h4>
		</div>
		<div class="modal-body">
			To be implement...
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<?php echo $form->bsBtnSubmit(Yii::t('app', 'Send Email'), array('class' => 'btn btn-primary')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>
</div>

<script type="text/javascript">
    $(window).load(function(){
        //$('#myModal').modal('show');
    });
</script>