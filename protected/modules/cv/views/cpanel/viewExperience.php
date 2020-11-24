
<div class="row">
	<div class="col col-sm-1"><i class="fa fa-2x <?php echo $model->getFaIcon() ?>"></i></div>
	<div class="col col-sm-11">
		<h3><span class="text-slim">
			<?php echo $model->title ?><?php if (!empty($model->organization_name)): ?> <span class="text-muted"><?php echo Yii::t('cv', 'at') ?></span> <?php echo $model->organization_name ?><?php endif; ?></span> 
		</h3>
		<p>
			<span class="text-muted"><?php echo $model->formatEnumMonthStart($model->month_start) ?> <?php echo $model->year_start ?></span>
			<?php if (!empty($model->month_end) || !empty($model->year_end)): ?>
			- 
			<span class="text-muted"><?php echo $model->formatEnumMonthStart($model->month_end) ?> <?php echo $model->year_end ?></span>
			<?php endif; ?>
			<?php if (!empty($model->location) || !empty($model->state) || !empty($model->country)): ?>

				<?php echo Html::faIcon('fa fa-map-marker margin-left-2x') ?>
				<span class="text-muted"><?php echo $model->location ?> <?php echo $model->state->title ?> <?php echo $model->country->printable_name ?></span>
			
			<?php endif; ?>

		</p>
		<div class="text-shortDesc"><?php echo $model->text_short_description ?></div>
	</div>
</div>

<?php 
	$this->layoutParams['overrideModalFooterHtml'] = '';

	if ($model->genre == 'job' || $model->genre == 'study') {
		$htmlSetExperience = '';
		$htmlSetExperience .= sprintf('<span class="dropdown margin-right-sm">
			<a class="btn btn-white dropdown-toggle" data-target="#" href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-spinner fa-spin hidden"></i>&nbsp;%s&nbsp;<span class="caret"></span></a><ul class="dropdown-menu" aria-labelledby="dLabel">', Yii::t('cv', 'Set'));
		if ($model->genre == 'job') {
			$htmlSetExperience .= sprintf(
				'<li><a id="btn-cv-setExperienceJob" data-call-url="%s">%s</a></li>',
				$this->createUrl('/cv/cpanel/setExperienceJob', array('id' => $model->id)),
			Yii::t('cv', 'as Current Job')
			);
		} elseif ($model->genre == 'study') {
			$htmlSetExperience .= sprintf(
				'<li><a id="btn-cv-setExperienceStudy" data-call-url="%s">%s</a></li>',
				$this->createUrl('/cv/cpanel/setExperienceStudy', array('id' => $model->id)),
			Yii::t('cv', 'as Highest Education')
			);
		}
		$htmlSetExperience .= '</ul></span>';

		$this->layoutParams['overrideModalFooterHtml'] .= $htmlSetExperience;
	}

	$this->layoutParams['overrideModalFooterHtml'] .= sprintf(
	'<a class="btn btn-white" id="btn-cv-updateExperience" data-load-url="%s">%s</a>
	<button type="button" class="btn btn-default" data-dismiss="modal">%s</button>',
	$this->createUrl('cpanel/updateExperience', array('id' => $model->id)),
	Yii::t('cv', 'Edit'),
	Yii::t('app', 'Close')
); ?>

<?php Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/javascript/cpanel.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScript(
'cv-cpanel-viewExperience',
<<<EOD

$('.dropdown-toggle').dropdown();

$('body').on( "click", '#btn-cv-updateExperience', function(e) {
    var url2Load = $(this).data('loadUrl');
    $('#modal-common').html('<div class="text-center text-white margin-top-3x">'+$('#block-spinner').html()+'</div>').load(url2Load, function(response, status, xhr){}).modal('show');
});

$('body').on( "click", '#btn-cv-setExperienceJob,#btn-cv-setExperienceStudy', function(e) {
    var url2Call = $(this).data('callUrl');
    $.ajax({
		method: "POST",
		url: url2Call,
		beforeSend: function( xhr ) {
			$('.fa-spinner').removeClass('hidden').show();
			$('.fa-spinner').closest('.btn').addClass('disabled');
		}
	})
	.always(function(){
		$('.fa-spinner').hide().addClass('hidden');
		$('.fa-spinner').closest('.btn').removeClass('disabled');
	})
	.done(function( json ) {
		if(json.status == 'success'){
			toastr.success(json.msg, '', {
				"closeButton": true,
				"newestOnTop": true,
				"preventDuplicates": true,
				"showDuration": "1000",
			});
		}
		else
		{
			toastr.error(json.msg, '', {
				"closeButton": true,
				"newestOnTop": true,
				"preventDuplicates": true,
				"showDuration": "1000",
			});
		}
	});
});
					

EOD
); ?>