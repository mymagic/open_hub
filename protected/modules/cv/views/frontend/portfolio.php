<div id="site-profileView" class="margin-bottom-2x">
<div class="row"><div class="col col-sm-12 text-center">
    <?php echo Html::image($model->getImageAvatarThumbUrl(150, 150), $model->display_name, array('class' => 'noborder img-circle', 'width' => 150, 'height' => 150)) ?>
	<h1 class="margin-top-lg"><?php echo Html::encode($model->display_name) ?></h1>
	<p>
		<span class="text-subline text-info"><?php echo Html::encode($model->cvJobpos->title)?></span>
		<?php if (!empty($model->organization_name)): ?><strong> <?php echo Yii::t('cv', 'at')?> <?php echo Html::encode($model->organization_name) ?></strong><?php endif; ?>
	<p>
	<div id="profileView-socialLink">
		<ul>
			<?php if (!empty($model->url_website)): ?><li><a href="<?php echo $model->url_website ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-globe fa-inverse fa-stack-1x') ?></span> <?php echo Yii::t('cv', 'My Website')?></a></li><?php endif; ?>
			<?php if (!empty($model->url_linkedin)): ?><li><a href="<?php echo $model->url_linkedin ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-linkedin fa-inverse fa-stack-1x') ?></span> <?php echo Yii::t('cv', 'Linkedin')?></a></li><?php endif; ?>
			<?php if (!empty($model->url_facebook)): ?><li><a href="<?php echo $model->url_facebook ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-facebook fa-inverse fa-stack-1x') ?></span> <?php echo Yii::t('cv', 'Facebook')?></a></li><?php endif; ?>
			<?php if (!empty($model->url_twitter)): ?><li><a href="<?php echo $model->url_twitter ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-twitter fa-inverse fa-stack-1x') ?></span> <?php echo Yii::t('cv', 'Twitter')?></a></li><?php endif; ?>
			<?php if (!empty($model->url_github)): ?><li><a href="<?php echo $model->url_github ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-github fa-inverse fa-stack-1x') ?></span> <?php echo Yii::t('cv', 'Github')?></a></li><?php endif; ?>
			<?php if (!empty($model->url_stackoverflow)): ?><li><a href="<?php echo $model->url_stackoverflow ?>" target="_blank">
				<span class="fa-stack"><?php echo Html::faIcon('fa-circle fa-stack-2x') ?><?php echo Html::faIcon('fa-stack-overflow fa-inverse fa-stack-1x') ?></span> <?php echo Yii::t('cv', 'Stackoverflow')?></a></li><?php endif; ?>
		</ul>
	</div>
	<div id="profileView-shortDesc">
		<?php echo nl2br(Html::encode($model->text_short_description)) ?>
	</div>
</div>
</div>

<div class="row">
<div class="col col-sm-7 col-sm-offset-1">
	<!-- start of profileView-mainBox -->
	<div id="profileView-mainBox" class="rounded-md">
	<ul class="fa-ul">
		<?php if (!empty($model->hasLocalityInfo())): ?>
		<li>
			<?php echo Html::faIcon('fa-map-marker fa-lg fa fa-li') ?>
			<span class="dd">
				<?php if (!empty($model->location)): ?><?php echo $model->location ?>, <?php endif;?> 
				<?php if (!empty($model->state->title)): ?><?php echo $model->state->title ?>,<?php endif;?> 
				<?php echo $model->country->printable_name ?>
			</span>
		</li>
		<?php endif; ?>
		<?php if (!empty($model->highAcademyExperience)): ?>
		<li>
			<?php echo Html::faIcon('fa-graduation-cap fa-lg fa fa-li') ?>
			<span class="dd"><?php echo $model->highAcademyExperience->title ?> <?php if (!empty($model->highAcademyExperience->organization_name)): ?> at <?php echo $model->highAcademyExperience->organization_name ?><?php endif; ?></span>
		</li>
		<?php endif; ?>
	</ul>
	
	<?php if (!empty($skillsets)): ?>
	<hr />
	<h4><?php echo Yii::t('cv', 'SKILLS')?></h4>
		<div id="skillsets">
		<?php foreach ($skillsets as $skillset): ?>
			<span class="label label-info"><?php echo ucwords($skillset) ?></span>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>
	</div>
	<!-- /start of profileView-mainBox -->
	
	<div id="vue-cv-frontend-portfolio" class="margin-top-lg margin-bottom-3x">
	<input type="hidden" name="portfolioId" :value="portfolioId = '<?php echo $model->id ?>'" />

	<template v-if="loading">
		<div class="text-center margin-bottom-lg"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
	</template>

	<template v-if="status!='success'">
		<p class="text-danger">{{msg}}</p>
	</template>
	<template v-else>

		<div v-if="data" class="experiences">
			<span v-for="record in data" >
			<div class="box-experience rounded-md" v-bind:class="(record.isEndorsed=='1')?'box-experience-endorsed':''" >
				
				<div class="row">
					<div class="col col-sm-1"><i class="fa fa-2x" v-bind:class="record.faIcon"></i></div>
					<div class="col col-sm-11">
						<h3><span class="text-slim">{{record.title}}<template v-if="record.organization_name"> <span class="text-muted">&nbsp;at</span> {{record.organization_name}}</span></template></span></h3>
						<p class="text-muted">{{record.monthNameStart}} {{record.yearStart}}</p>
						<div class="text-shortDesc">{{record.description}}</div>
						<span class="endorsed" v-if="record.isEndorsed === '1'"><img src="/images/endorsed.png" alt=""></span>
						<p><?php if (Yii::app()->params['dev']): ?>Dev Only: {{record.email}}<?php endif ?></p>
					</div>
				</div>
			
			</div>
			</span>
		</div>

		<a class="btn btn-white btn-block margin-top-lg"  v-on:click="loadMore()" v-if="!allLoaded"><i class="fa fa-spinner fa-spin" v-if="loading"></i> <?php echo Yii::t('cv', 'Load More') ?> ({{page}}/{{meta.output.totalPages}})</a>

	</template>

	</div>
	
</div>

<div class="col col-sm-3">
	<div id="profileView-subBox" class="rounded-md">
		<h3 class="text-primary"><?php echo Html::faIcon('fa-briefcase fa-inverse') ?>&nbsp;&nbsp;<?php echo Yii::t('cv', "I'M LOOKING FOR") ?></h3>
		<?php if ($model->isNotLookingAnything()): ?>
			<p class="text-muted"><?php echo Yii::t('cv', 'Not speficied') ?></p>
		<?php else: ?>
		<ul>
			<?php if ($model->is_looking_fulltime): ?><li><?php echo Html::faIcon('fa-check text-info') ?> <?php echo Yii::t('cv', 'Full Time')?></li><?php endif; ?>
			<?php if ($model->is_looking_contract): ?><li><?php echo Html::faIcon('fa-check text-info') ?> <?php echo Yii::t('cv', 'Contract') ?></li><?php endif; ?>
			<?php if ($model->is_looking_freelance): ?><li><?php echo Html::faIcon('fa-check text-info') ?> <?php echo Yii::t('cv', 'Freelance') ?></li><?php endif; ?>
			<?php if ($model->is_looking_cofounder): ?><li><?php echo Html::faIcon('fa-check text-info') ?> <?php echo Yii::t('cv', 'Co-Founder') ?></li><?php endif; ?>
			<?php if ($model->is_looking_internship): ?><li><?php echo Html::faIcon('fa-check text-info') ?> <?php echo Yii::t('cv', 'Internship') ?></li><?php endif; ?>
			<?php if ($model->is_looking_apprenticeship): ?><li><?php echo Html::faIcon('fa-check text-info') ?> <?php echo Yii::t('cv', 'Apprenticeship') ?></li><?php endif; ?>
		</ul>
		<div class="text-center hidden"><a class="btn btn-info" data-toggle="modal" data-target="#modal-contact">CONTACT ME</a></div>
		<?php endif; ?>
	</div>
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
			<h4 class="modal-title"><?php echo Yii::t('cv', 'Contact')?> <?php echo $model->display_name ?></h4>
		</div>
		<div class="modal-body">
		<?php echo Yii::t('cv', 'To be implement')?>...
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('cv', 'Close')?></button>
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



<?php Yii::app()->clientScript->registerScript('cv-frontend-portfolio-vuejs', "
// vuejs2 code
var vue = new Vue({
	el: '#vue-cv-frontend-portfolio',
	data: {portfolioId:undefined, loading:false, page:'1', totalPages:'1', status:'fail', msg:'', meta:'', data:[], allLoaded:false},
	mounted: function(){this.fetchData(0);},
	methods: 
	{
		loadMore: function()
		{
			var self = this;
			self.page++;
			self.fetchData(0);
		},
		fetchData: function(forceRefresh)
		{
			var self = this;
			{
				this.loading = true;
				$.get(baseUrl+'/cv/frontend/listExperiences?portfolioId='+self.portfolioId+'&page='+self.page, function( json ) 
				{
					if(json.data != null && json.data.length>0)
					{
						for (var i=0; i < json.data.length; i++) {
							self.data.push( json.data[i] );
						}
					}
					else
					{
						self.allLoaded = true;
					}

					self.status = json.status;
					self.meta = json.meta;
					self.msg = json.msg;
					self.totalPages = json.meta.output.totalPages;

					if(json.meta.output.totalPages-json.meta.input.page <1){self.allLoaded = true;}
				}).always(function() {
					self.loading = false;
				});
			}
		}
	}
});");
?>