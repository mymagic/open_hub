
<div class="item-flex col col-xs-12 col-sm-12 col-md-6">
<div class="contact-box full-width">
<a href="<?php echo $data->getPublicUrl($this) ?>">
<div class="col-sm-4">
	<div class="text-center">
		<img src="<?php echo $data->getImageAvatarThumbUrl(150, 150) ?>" class="noborder img-circle avatar img-responseive" />
		<div class="m-t-xs font-bold"><?php echo Html::encode($data->cvJobpos->title) ?></div>
	</div>
</div>
<div class="col-sm-8">
	<h3><strong><?php echo Html::encode($data->display_name) ?></strong></h3>
	<p><i class="fa fa-map-marker"></i> 
		<?php if (!empty($data->location)): ?><?php echo Html::encode($data->location) ?>, <?php endif;?> 
		<?php if (!empty($data->state->title)): ?><?php echo $data->state->title ?>,<?php endif;?> 
		<?php echo $data->country->printable_name ?>
	</p>
	<address>
		<?php if (!empty($data->at)): ?><strong> at <?php echo Html::encode($data->at) ?></strong><br /><?php endif; ?>
	</address>
</div>
<div class="clearfix"></div>
</a>
</div>
</div>
